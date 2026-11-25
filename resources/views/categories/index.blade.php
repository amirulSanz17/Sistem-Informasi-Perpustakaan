
@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/categories/index.css') }}">
@endpush

@section('content')
    <div class="categories-page">

        <div class="page-header">
            <div>
                <h1 class="page-title">Daftar Kategori Buku</h1>
                <p class="page-description">
                    Kelola kategori buku perpustakaan.
                </p>
            </div>

            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                + Tambah Kategori
            </a>
        </div>

    <div class="filter-card">
        <form action="{{ route('categories.index') }}" method="GET">
            <div class="filter-grid">
                {{-- SEARCH --}}
                <div class="filter-group search-group">
                    <label for="search">Pencarian</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Nama Kategori atau Deskripsi"
                    >
                </div>
            </div>

            {{-- TOMBOL FILTER --}}
            <div class="categories-actions">

                <button type="submit" class="btn btn-filter">
                    Cari
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-reset">
                    Reset
                </a>
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
            <table class="category-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>
                                {{ $categories->firstItem() + $loop->index }}
                            </td>

                            <td>{{ $category->name }}</td>

                            <td>
                                {{ $category->description ?? '-' }}
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a
                                        href="{{ route('categories.edit', $category->id) }}"
                                        class="btn btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('categories.destroy', $category->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
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
                            <td colspan="4" class="empty-state">
                                Belum ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $categories->links() }}
        </div>

    </div>
@endsection
