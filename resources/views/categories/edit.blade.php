
@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container">
    <h2>Edit Kategori Buku</h2>

    <form
        action="{{ route('categories.update', $category->id) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nama Kategori</label><br>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $category->name) }}"
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
            >{{ old('description', $category->description) }}</textarea>

            @error('description')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Update</button>

        <a href="{{ route('categories.index') }}">
            Kembali
        </a>
    </form>
</div>
@endsection