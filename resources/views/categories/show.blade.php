@extends('layouts.app')

@section('title', 'Detail Kategori')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/categories/show.css') }}">
@endpush

@section('content')

<div class="container">
    <h2>Detail Kategori Buku</h2>

    <div class="detail-card">
        <div class="detail-header">
            <h3>{{ $category->name }}</h3>
            @if(isset($category->books))
                <span class="badge-count">
                    {{ $category->books->count() }} Buku
                </span>
            @endif
        </div>

        <div class="detail-body">
            <div class="detail-row">
                <div class="detail-label">Nama Kategori</div>
                <p class="detail-value">{{ $category->name }}</p>
            </div>

            <div class="detail-row">
                <div class="detail-label">Deskripsi</div>
                <p class="detail-value">
                    {{ $category->description ?: 'Tidak ada deskripsi untuk kategori ini.' }}
                </p>
            </div>

            <div class="detail-row">
                <div class="detail-meta">
                    <div>
                        <div class="detail-label">Dibuat Pada</div>
                        <p class="detail-value">
                            {{ $category->created_at ? $category->created_at->format('d M Y, H:i') : '-' }}
                        </p>
                    </div>
                    <div>
                        <div class="detail-label">Terakhir Diperbarui</div>
                        <p class="detail-value">
                            {{ $category->updated_at ? $category->updated_at->format('d M Y, H:i') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-actions">
            <a href="{{ route('categories.edit', $category->id) }}" class="btn-edit">
                Edit Kategori
            </a>

            <a href="{{ route('categories.index') }}" class="btn-back">
                Kembali
            </a>

            <form
                action="{{ route('categories.destroy', $category->id) }}"
                method="POST"
                style="display: inline; margin-left: auto;"
                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
            >
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection