@extends('layouts.app')

@section('title', 'Manajemen Buku')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/books/index.css') }}">
@endpush

@section('content')
<div class="container books-page">

    <div class="page-header">
        <div>
            <h2 class="page-title">Daftar Buku</h2>
            <p class="page-description">
                Kelola data buku yang tersedia di perpustakaan.
            </p>
        </div>

        <a href="{{ route('books.create') }}" class="btn btn-primary">
            + Tambah Buku
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

    <div class="filter-card">
        <form action="{{ route('books.index') }}" method="GET">
            <div class="filter-grid">

                <div class="filter-group search-group">
                    <label for="search">Pencarian</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Cari judul, penulis, atau penerbit..."
                    >
                </div>

                <div class="filter-group">
                    <label for="category_id">Kategori</label>
                    <select name="category_id" id="category_id">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="stock_status">Ketersediaan Stok</label>
                    <select name="stock_status" id="stock_status">
                        <option value="">Semua Stok</option>
                        <option value="available"
                            {{ request('stock_status') === 'available' ? 'selected' : '' }}>
                            Tersedia
                        </option>
                        <option value="out"
                            {{ request('stock_status') === 'out' ? 'selected' : '' }}>
                            Habis
                        </option>
                    </select>
                </div>

            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-filter">
                    Cari / Filter
                </button>

                <a href="{{ route('books.index') }}" class="btn btn-reset">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="table-info">
        Menampilkan
        <strong>{{ $books->firstItem() ?? 0 }}–{{ $books->lastItem() ?? 0 }}</strong>
        dari
        <strong>{{ $books->total() }}</strong>
        buku
    </div>

    <div class="table-container">
        <table class="book-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @if ($books->count() > 0)
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $books->firstItem() + $loop->index }}</td>

                            <td>
                                @if ($book->cover_image)
                                    <img
                                        src="{{ asset('storage/' . $book->cover_image) }}"
                                        alt="Cover {{ $book->title }}"
                                        class="book-cover-thumbnail"
                                    >
                                @else
                                    <div class="book-cover-empty">
                                        No Cover
                                    </div>
                                @endif
                            </td>

                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category->name }}</td>
                            <td>{{ $book->publisher ?: '-' }}</td>
                            <td>{{ $book->year ?: '-' }}</td>

                            <td>
                                <span class="stock-badge {{ $book->stock > 0 ? 'stock-available' : 'stock-empty' }}">
                                    {{ $book->stock }}
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('books.show', $book->id) }}"
                                       class="btn btn-detail">
                                        Detail
                                    </a>

                                    <a href="{{ route('books.edit', $book->id) }}"
                                       class="btn btn-edit">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('books.destroy', $book->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus buku ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="empty-state">
                            Belum ada data buku.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $books->links() }}
    </div>

</div>
@endsection