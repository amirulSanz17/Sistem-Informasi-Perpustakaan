@extends('layouts.app')

@section('title', 'Edit Kategori')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/categories/edit.css') }}">
@endpush

@section('content')
<div class="categories-form-page">
    <div class="form-card">

        <h1>Edit Kategori</h1>
        <p class="subtitle">Perbarui informasi kategori yang dipilih.</p>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Kategori</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea
                    id="description"
                    name="description"
                    rows="4"
                >{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>

                <a href="{{ route('categories.index') }}" class="btn-secondary">
                    Kembali
                </a>
            </div>
        </form>

    </div>
</div>
@endsection