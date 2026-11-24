@extends('layouts.app')

@section('title', 'Tambah Buku')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/books/create.css') }}">
@endpush

@section('content')
<div class="books-form-page">
    <div class="form-card">
        <h1>Tambah Buku</h1>
        <p class="subtitle">Masukkan informasi buku yang ingin ditambahkan.</p>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('books.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Judul Buku</label>
                <input type="text" id="title" name="title"
                    value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="author">Penulis</label>
                <input type="text" id="author" name="author"
                    value="{{ old('author') }}" required>
            </div>

            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="publisher">Penerbit</label>
                <input type="text" id="publisher" name="publisher"
                    value="{{ old('publisher') }}">
            </div>

            <div class="form-group">
                <label for="year">Tahun Terbit</label>
                <input type="number" id="year" name="year"
                    value="{{ old('year') }}" min="1000" max="{{ date('Y') }}">
            </div>

            <div class="form-group">
                <label for="stock">Stok Buku</label>
                <input type="number" id="stock" name="stock"
                    value="{{ old('stock', 0) }}" min="0" required>
            </div>

            <div class="actions">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('books.index') }}" class="btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection