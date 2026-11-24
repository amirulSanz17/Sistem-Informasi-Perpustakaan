<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    // Menampilkan seluruh transaksi peminjaman
    public function index()
    {
        // Mengubah status menjadi terlambat jika due date sudah lewat
        Borrowing::where('status', 'dipinjam')
            ->whereDate('due_date', '<', now()->toDateString())
            ->update([
                'status' => 'terlambat'
            ]);
        $borrowings = Borrowing::with([
            'user',
            'member'
        ])
            ->latest()
            ->paginate(10);
        return view('borrowings.index', compact('borrowings'));
    }
    // Menampilkan form tambah peminjaman
    public function create()
    {
        $members = Member::orderBy('name')->get();
        $books = Book::where('stock', '>', 0)
            ->orderBy('title')
            ->get();
        return view('borrowings.create', compact(
            'members',
            'books'
        ));
    }
    // Menyimpan transaksi peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => ['required','exists:members,id'],
            'borrow_date' => ['required','date_format:Y-m-d','before_or_equal:today'],
            'items' => ['required','array','min:1'],
            'items.*.book_id' => ['required','distinct','exists:books,id'],
            'items.*.quantity' => ['required','integer','min:1'],
        ], [
            'member_id.required' => 'Anggota harus dipilih.',
            'member_id.exists' => 'Anggota tidak ditemukan.',

            'borrow_date.required' => 'Tanggal peminjaman harus diisi.',
            'borrow_date.date_format' => 'Format tanggal peminjaman tidak valid.',
            'borrow_date.before_or_equal' => 'Tanggal peminjaman tidak boleh melebihi hari ini.',

            'items.required' => 'Minimal harus memilih satu buku.',
            'items.min' => 'Minimal harus memilih satu buku.',

            'items.*.book_id.required' => 'Buku harus dipilih.',
            'items.*.book_id.distinct' => 'Buku yang sama tidak boleh dipilih dua kali.',
            'items.*.book_id.exists' => 'Buku tidak ditemukan.',

            'items.*.quantity.required' => 'Jumlah buku harus diisi.',
            'items.*.quantity.integer' => 'Jumlah buku harus berupa angka.',
            'items.*.quantity.min' => 'Jumlah buku minimal satu.',
        ]);
        DB::transaction(function () use ($validated) {
            // Menghitung due date otomatis 7 hari setelah peminjaman
            $borrowDate = Carbon::createFromFormat(
                'Y-m-d',
                $validated['borrow_date']
            );
            $dueDate = $borrowDate->copy()->addDays(7);
            // Menyimpan data buku yang akan dipinjam
            $books = [];
            // Mengunci dan memeriksa stok buku
            foreach ($validated['items'] as $item) {
                $book = Book::where('id', $item['book_id'])
                    ->lockForUpdate()
                    ->firstOrFail();
                if ($book->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => "Stok buku {$book->title} tidak mencukupi. Stok tersedia: {$book->stock}.",
                    ]);
                }
                $books[$book->id] = $book;
            }
            // Membuat transaksi peminjaman
            $borrowing = Borrowing::create([
                'user_id' => auth()->id(),
                'member_id' => $validated['member_id'],
                'borrow_date' => $borrowDate->toDateString(),
                'due_date' => $dueDate->toDateString(),
                'return_date' => null,
                'status' => 'dipinjam',
            ]);

            // Menyimpan detail peminjaman dan mengurangi stok
            foreach ($validated['items'] as $item) {
                $book = $books[$item['book_id']];
                $borrowing->borrowingDetails()->create([
                    'book_id' => $book->id,
                    'quantity' => $item['quantity'],
                ]);
                $book->decrement('stock', $item['quantity']);
            }
        });
        return redirect()
            ->route('borrowings.index')
            ->with('success', 'Peminjaman buku berhasil disimpan.');
    }
    // Menampilkan detail transaksi peminjaman
    public function show(Borrowing $borrowing)
    {
        // Memeriksa apakah peminjaman sudah melewati due date
        if (
            $borrowing->status === 'dipinjam' &&
            $borrowing->due_date->toDateString() < now()->toDateString()
        ) {
            $borrowing->update([
                'status' => 'terlambat'
            ]);
        }
        $borrowing->load([
            'user',
            'member',
            'borrowingDetails.book.category'
        ]);
        return view('borrowings.show', compact('borrowing'));
    }
    // Memproses pengembalian buku
    public function returnBook(Request $request, Borrowing $borrowing)
    {
        $validated = $request->validate([
            'return_date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:' . $borrowing->borrow_date->toDateString(),
                'before_or_equal:today',
            ],
        ], [
            'return_date.required' => 'Tanggal pengembalian harus diisi.',
            'return_date.date_format' => 'Format tanggal pengembalian tidak valid.',
            'return_date.after_or_equal' => 'Tanggal pengembalian tidak boleh sebelum tanggal peminjaman.',
            'return_date.before_or_equal' => 'Tanggal pengembalian tidak boleh melebihi hari ini.',
        ]);
        DB::transaction(function () use ($borrowing, $validated) {
            // Mengunci transaksi untuk mencegah pengembalian ganda
            $borrowing = Borrowing::where('id', $borrowing->id)
                ->lockForUpdate()
                ->firstOrFail();
            // Memastikan transaksi belum dikembalikan
            if ($borrowing->status === 'dikembalikan') {
                throw ValidationException::withMessages([
                    'return_date' => 'Buku pada transaksi ini sudah dikembalikan.',
                ]);
            }
            // Mengambil detail buku
            $borrowing->load('borrowingDetails');
            // Mengembalikan stok buku
            foreach ($borrowing->borrowingDetails as $detail) {
                $book = Book::where('id', $detail->book_id)
                    ->lockForUpdate()
                    ->firstOrFail();
                $book->increment('stock', $detail->quantity);
            }
            // Memperbarui tanggal dan status pengembalian
            $borrowing->update([
                'return_date' => $validated['return_date'],
                'status' => 'dikembalikan',
            ]);
        });
        return redirect()
            ->route('borrowings.show', $borrowing->id)
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}
