@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<div class="dashboard-page">

    <div class="dashboard-header">
        <div>
            <h1>Halo, {{ auth()->user()->name }}! 👋</h1>
            <p>Welcome back to Library System. Kelola aktivitas perpustakaan dengan mudah.</p>
        </div>

        <div class="dashboard-date">
            {{ now()->format('d M Y') }}
        </div>
    </div>

    <div class="dashboard-cards">

        <div class="dashboard-card">
            <div class="card-info">
                <p>Total Books</p>
                <h2>{{ $totalBooks }}</h2>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-info">
                <p>Total Members</p>
                <h2>{{ $totalMembers }}</h2>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-info">
                <p>Active Borrowings</p>
                <h2>{{ $activeBorrowings }}</h2>
            </div>
        </div>

    </div>

    <div class="dashboard-section quick-section">
        <div class="section-header">
            <div>
                <h2>Quick Actions</h2>
                <p>Akses fitur perpustakaan dengan cepat.</p>
            </div>
        </div>

        <div class="quick-actions">

            <a href="{{ route('borrowings.create') }}" class="quick-action">
                <div>
                    <h3>Tambah Peminjaman</h3>
                    <p>Buat transaksi peminjaman baru.</p>
                </div>
                <span>→</span>
            </a>

            <a href="{{ route('books.index') }}" class="quick-action">
                <div>
                    <h3>Kelola Buku</h3>
                    <p>Lihat dan kelola koleksi buku.</p>
                </div>
                <span>→</span>
            </a>

            <a href="{{ route('members.index') }}" class="quick-action">
                <div>
                    <h3>Kelola Member</h3>
                    <p>Lihat data anggota perpustakaan.</p>
                </div>
                <span>→</span>
            </a>

        </div>
    </div>

    <div class="dashboard-section">
        <div class="section-header">
            <div>
                <h2>Recent Borrowings</h2>
                <p>Aktivitas peminjaman buku terbaru.</p>
            </div>

            <a href="{{ route('borrowings.index') }}" class="view-all">
                View All →
            </a>
        </div>

        <div class="table-wrapper">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($recentBorrowings->isEmpty())
                        <tr>
                            <td colspan="5" class="empty-data">
                                Belum ada transaksi peminjaman.
                            </td>
                        </tr>
                    @else
                        @foreach ($recentBorrowings as $borrowing)
                            <tr>
                                <td>{{ $borrowing->member->name }}</td>
                                <td>{{ $borrowing->borrow_date->format('d-m-Y') }}</td>
                                <td>{{ $borrowing->due_date->format('d-m-Y') }}</td>

                                <td>
                                    @if ($borrowing->status === 'dipinjam')
                                        <span class="status-badge status-borrowed">Dipinjam</span>
                                    @elseif ($borrowing->status === 'terlambat')
                                        <span class="status-badge status-late">Terlambat</span>
                                    @else
                                        <span class="status-badge status-returned">Dikembalikan</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('borrowings.show', $borrowing->id) }}"
                                       class="detail-link">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection