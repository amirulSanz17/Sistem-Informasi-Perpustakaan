<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Searching berdasarkan judul, penulis, atau penerbit
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter berdasarkan kondisi stok
        if ($request->stock_status === 'available') {
            $query->where('stock', '>', 0);
        } elseif ($request->stock_status === 'out') {
            $query->where('stock', '=', 0);
        }

        // Urutkan dan tampilkan 10 data per halaman
        $books = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Data kategori untuk dropdown filter
        $categories = Category::orderBy('name')->get();

        return view('books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('cover_image')) {
        $validated['cover_image'] = $request->file('cover_image')
            ->store('covers', 'public');
        }
        Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $book = Book::with('category')->findOrFail($id);

        return view('books.show', compact('book'));
    }

    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('cover_image')) {
            // Hapus cover lama
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            // Simpan cover baru
            $validated['cover_image'] = $request->file('cover_image')
                ->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->borrowingDetails()->exists()) {
            return redirect()
                ->route('books.index')
                ->with('error', 'Buku tidak dapat dihapus karena sudah memiliki riwayat peminjaman.');
        }

        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}