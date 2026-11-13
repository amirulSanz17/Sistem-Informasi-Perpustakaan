
@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container">
    <h2>Tambah Kategori Buku</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Nama Kategori</label><br>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                maxlength="255"
            >

            @error('name')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="description">Deskripsi</label><br>

            <textarea
                id="description"
                name="description"
                rows="4"
            >{{ old('description') }}</textarea>

            @error('description')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Simpan</button>

        <a href="{{ route('categories.index') }}">
            Kembali
        </a>
    </form>
</div>
@endsection