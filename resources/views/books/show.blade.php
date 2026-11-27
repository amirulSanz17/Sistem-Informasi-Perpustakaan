@extends('layouts.app')

@section('title', 'Detail Buku')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/books/show.css') }}">
@endpush

@section('content')
<div class="books-show-page">
    <div class="page-header">
        <div>
            <h1>Detail Buku</h1>
            <p class="subtitle">Informasi lengkap buku yang dipilih.</p>
        </div>

        <a href="{{ route('books.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>

    <div class="detail-card">
        <div class="detail-header">
            <h2>{{ $book->title }}</h2>
            <span class="book-category">
                {{ $book->category->name }}
            </span>
        </div>

        <div class="book-cover-section">
            <span>Cover Buku</span>
            @if ($book->cover_image)
                <img
                    src="{{ asset('storage/' . $book->cover_image) }}"
                    alt="Cover {{ $book->title }}"
                    class="book-detail-cover"
                >
            @else
                <div class="no-cover">
                    <span>Belum tersedia</span>
                </div>
            @endif
        </div>

        <div class="detail-content">
            <div class="detail-item">
                <span>Judul Buku</span>
                <strong>{{ $book->title }}</strong>
            </div>

            <div class="detail-item">
                <span>Penulis</span>
                <strong>{{ $book->author }}</strong>
            </div>

            <div class="detail-item">
                <span>Kategori</span>
                <strong>{{ $book->category->name }}</strong>
            </div>

            <div class="detail-item">
                <span>Penerbit</span>
                <strong>{{ $book->publisher ?? '-' }}</strong>
            </div>

            <div class="detail-item">
                <span>Tahun Terbit</span>
                <strong>{{ $book->year ?? '-' }}</strong>
            </div>

            <div class="detail-item">
                <span>Stok Buku</span>
                <strong>{{ $book->stock }}</strong>
            </div>

            <div class="detail-item">
                <span>Ditambahkan</span>
                <strong>{{ $book->created_at->format('d-m-Y H:i') }}</strong>
            </div>

            <div class="detail-item">
                <span>Terakhir Diperbarui</span>
                <strong>{{ $book->updated_at->format('d-m-Y H:i') }}</strong>
            </div>
        </div>

        <div class="detail-actions">
            <a href="{{ route('books.edit', $book->id) }}" class="btn-edit">
                Edit Buku
            </a>

            <form action="{{ route('books.destroy', $book->id) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn-delete">
                    Hapus Buku
                </button>
            </form>
        </div>
    </div>
</div>
@endsection