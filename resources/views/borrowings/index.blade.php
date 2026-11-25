
@extends('layouts.app')

@section('title', 'Manajemen Peminjaman')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/borrowings/index.css') }}">
@endpush

@section('content')
<div class="container borrowings-page">

    <div class="page-header">
        <div>
            <h2 class="page-title">Data Peminjaman Buku</h2>
            <p class="page-description">
                Kelola transaksi peminjaman dan pengembalian buku perpustakaan.
            </p>
        </div>
        <a href="{{ route('borrowings.create') }}" class="btn btn-primary">
            + Tambah Peminjaman
        </a>
    </div>

    {{-- SEARCHING DAN FILTERING --}}
    <div class="filter-container">
        <form action="{{ route('borrowings.index') }}" method="GET">
            <div class="filter-top">
                <div class="search-group">
                    <label for="search">Pencarian</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama anggota atau petugas..."
                    >
                </div>
                <div class="status-group">
                    <label for="status">Status Peminjaman</label>
                    <select name="status" id="status">
                        <option value="">Semua Status</option>
                        <option value="dipinjam"
                            {{ request('status') == 'dipinjam' ? 'selected' : '' }}>
                            Dipinjam
                        </option>
                        <option value="terlambat"
                            {{ request('status') == 'terlambat' ? 'selected' : '' }}>
                            Terlambat
                        </option>
                        <option value="dikembalikan"
                            {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>
                            Dikembalikan
                        </option>
                    </select>
                </div>
            </div>
            <div class="filter-bottom">
                <div class="date-group">
                    <label for="date_from">Tanggal Mulai Pinjam</label>
                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                    >
                </div>
                <div class="date-group">
                    <label for="date_to">Tanggal Akhir Pinjam</label>
                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                    >
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-filter">
                        Cari / Filter
                    </button>
                    <a href="{{ route('borrowings.index') }}" class="btn btn-reset">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="table-container">
        <table class="borrowing-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Anggota</th>
                    <th>Petugas</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($borrowings as $borrowing)
                    @php
                        $today = now()->toDateString();
                        $dueDate = $borrowing->due_date->toDateString();
                        $isOverdue = (
                            $borrowing->status !== 'dikembalikan'
                            && $today > $dueDate
                        );
                    @endphp
                    <tr>
                        <td>
                            {{ $borrowings->firstItem() + $loop->index }}
                        </td>
                        <td>
                            {{ $borrowing->member->name ?? '-' }}
                        </td>
                        <td>
                            {{ $borrowing->user->name ?? '-' }}
                        </td>
                        <td>
                            {{ $borrowing->borrow_date->format('d-m-Y') }}
                        </td>
                        <td>
                            {{ $borrowing->due_date->format('d-m-Y') }}
                        </td>
                        <td>
                            {{ $borrowing->return_date
                                ? $borrowing->return_date->format('d-m-Y')
                                : '-' }}
                        </td>
                        <td>
                            @if ($borrowing->status === 'dikembalikan')
                                <span class="status-badge status-returned">
                                    Dikembalikan
                                </span>
                            @elseif ($isOverdue)
                                <span class="status-badge status-overdue">
                                    Terlambat
                                </span>
                            @else
                                <span class="status-badge status-borrowed">
                                    Dipinjam
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a
                                    href="{{ route('borrowings.show', $borrowing->id) }}"
                                    class="btn btn-detail"
                                >
                                    Detail
                                </a>
                                @if ($borrowing->status !== 'dikembalikan')
                                    <a
                                        href="{{ route('borrowings.show', $borrowing->id) }}#return-form"
                                        class="btn btn-return"
                                    >
                                        Kembalikan
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            Belum ada transaksi peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">
        {{ $borrowings->links() }}
    </div>
</div>
@endsection
