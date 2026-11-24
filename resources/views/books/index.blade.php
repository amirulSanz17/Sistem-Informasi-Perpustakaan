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

    <div class="table-container">
        <table class="book-table">
            <thead>
                <tr>
                    <th>No</th>
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
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $books->firstItem() + $loop->index }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->category->name }}</td>
                        <td>{{ $book->publisher ?: '-' }}</td>
                        <td>{{ $book->year ?: '-' }}</td>
                        <td>{{ $book->stock }}</td>

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
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            Belum ada data buku.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $books->links() }}
    </div>

</div>
@endsection