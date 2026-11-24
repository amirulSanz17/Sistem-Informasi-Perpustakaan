
@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/borrowings/show.css') }}">
@endpush

@section('content')
<div class="container borrowings-page">

    <div class="page-header">
        <div>
            <h2 class="page-title">Detail Peminjaman</h2>
            <p class="page-description">
                Informasi lengkap transaksi peminjaman buku.
            </p>
        </div>

        <a href="{{ route('borrowings.index') }}" class="btn btn-back">
            Kembali
        </a>
    </div>

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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

    <div class="detail-card">

        {{-- HEADER TRANSAKSI --}}
        <div class="detail-card-header">
            <div>
                <h3>Informasi Transaksi</h3>
                <p>ID Transaksi: #{{ $borrowing->id }}</p>
            </div>

            @if ($borrowing->status === 'dikembalikan')
                <span class="status-badge status-returned">
                    Dikembalikan
                </span>

            @elseif ($borrowing->status === 'terlambat')
                <span class="status-badge status-overdue">
                    Terlambat
                </span>

            @else
                <span class="status-badge status-borrowed">
                    Dipinjam
                </span>
            @endif
        </div>

        {{-- INFORMASI TRANSAKSI --}}
        <div class="detail-grid">

            <div class="detail-item">
                <span>Nama Anggota</span>
                <strong>
                    {{ $borrowing->member->name ?? '-' }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Petugas</span>
                <strong>
                    {{ $borrowing->user->name ?? '-' }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Tanggal Peminjaman</span>
                <strong>
                    {{ $borrowing->borrow_date->format('d-m-Y') }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Batas Pengembalian (Due Date)</span>
                <strong>
                    {{ $borrowing->due_date->format('d-m-Y') }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Tanggal Pengembalian Aktual</span>
                <strong>
                    {{ $borrowing->return_date
                        ? $borrowing->return_date->format('d-m-Y')
                        : 'Belum dikembalikan' }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Status Transaksi</span>

                @if ($borrowing->status === 'dikembalikan')
                    <strong class="text-success">
                        Sudah Dikembalikan
                    </strong>

                @elseif ($borrowing->status === 'terlambat')
                    <strong class="text-danger">
                        Terlambat
                    </strong>

                @else
                    <strong class="text-warning">
                        Sedang Dipinjam
                    </strong>
                @endif
            </div>

        </div>

        {{-- DETAIL BUKU --}}
        <div class="detail-books">

            <h3>Daftar Buku yang Dipinjam</h3>

            <div class="table-container">

                <table class="borrowing-table">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($borrowing->borrowingDetails as $detail)

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $detail->book->title ?? 'Buku tidak tersedia' }}
                                </td>

                                <td>
                                    {{ $detail->book->author ?? '-' }}
                                </td>

                                <td>
                                    {{ $detail->book->category->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $detail->quantity }}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="empty-state">
                                    Tidak ada detail buku.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- FORM PENGEMBALIAN --}}
        @if ($borrowing->status !== 'dikembalikan')

            <div class="return-section" id="return-form">

                <h3>Form Pengembalian Buku</h3>

                <p>
                    Isi tanggal ketika buku benar-benar diterima kembali
                    oleh petugas.
                </p>

                <form
                    action="{{ route('borrowings.return', $borrowing->id) }}"
                    method="POST"
                    onsubmit="return confirm('Apakah kamu yakin ingin memproses pengembalian buku ini?')"
                >
                    @csrf

                    <div class="form-group">

                        <label for="return_date">
                            Tanggal Pengembalian Aktual
                        </label>

                        <input
                            type="date"
                            name="return_date"
                            id="return_date"
                            value="{{ old('return_date', now()->toDateString()) }}"
                            min="{{ $borrowing->borrow_date->toDateString() }}"
                            max="{{ now()->toDateString() }}"
                            required
                        >

                        <small>
                            Isi tanggal aktual saat buku diterima kembali.
                        </small>

                    </div>

                    <button type="submit" class="btn btn-return">
                        Konfirmasi Pengembalian
                    </button>

                </form>

            </div>

        @else

            {{-- INFORMASI JIKA SUDAH DIKEMBALIKAN --}}
            <div class="returned-info">

                <h3>Buku Sudah Dikembalikan</h3>

                <p>
                    Transaksi ini telah diselesaikan pada tanggal
                    <strong>
                        {{ $borrowing->return_date->format('d-m-Y') }}
                    </strong>.
                </p>

            </div>

        @endif

        {{-- TOMBOL KEMBALI --}}
        <div class="detail-actions">

            <a href="{{ route('borrowings.index') }}" class="btn btn-back">
                Kembali ke Daftar Peminjaman
            </a>

        </div>

    </div>

</div>
@endsection
