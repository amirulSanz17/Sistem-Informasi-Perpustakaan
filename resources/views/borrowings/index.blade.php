
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
