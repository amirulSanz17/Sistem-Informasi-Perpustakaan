<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    public function index()
    {
        // Memperbarui status peminjaman yang terlambat
        Borrowing::where('status', 'dipinjam')
            ->whereDate('due_date', '<', now()->toDateString())
            ->update([
                'status' => 'terlambat'
            ]);

        // Statistik perpustakaan
        $totalBooks = Book::count();
        $totalStock = Book::sum('stock');
        $totalMembers = Member::count();

        $activeBorrowings = Borrowing::whereIn('status', [
            'dipinjam',
            'terlambat'
        ])->count();

        // Lima transaksi peminjaman terbaru
        $recentBorrowings = Borrowing::with('member')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalBooks',
            'totalStock',
            'totalMembers',
            'activeBorrowings',
            'recentBorrowings'
        ));
    }
}
