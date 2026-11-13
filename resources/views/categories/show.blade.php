@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<style>
    :root {
        --prussian: #032A42;
        --columbia: #D1E2F3;
        --beige: #F0F0DC;
        --wheat: #F0D8B6;
        --lion: #B3926F;
        --lion-dark: #8C6A4D;
    }

    .container {
        font-family: "Segoe UI", Arial, sans-serif;
        color: var(--prussian);
        max-width: 820px;
    }

    h2 {
        color: var(--prussian);
        font-size: 30px;
        margin: 0 0 20px;
    }

    .detail-card {
        background: white;
        border: 1px solid #D9C4AA;
        border-radius: 13px;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(3, 42, 66, 0.10);
    }

    .detail-header {
        background: var(--prussian);
        color: var(--beige);
        padding: 18px 25px;
        border-bottom: 4px solid var(--lion);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .badge-count {
        background: var(--lion);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .detail-body {
        padding: 25px;
    }

    .detail-row {
        padding: 14px 0;
        border-bottom: 1px solid #E9DFD2;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--lion-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .detail-value {
        font-size: 15px;
        line-height: 1.6;
        color: var(--prussian);
        margin: 0;
    }

    .detail-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        background: #FCFAF6;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #E9DFD2;
        margin-top: 10px;
    }

    .detail-actions {
        padding: 18px 25px;
        background: #FCFAF6;
        border-top: 1px solid #E9DFD2;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-edit {
        display: inline-block;
        padding: 10px 18px;
        background: var(--lion);
        color: white;
        text-decoration: none;
        border: 1px solid var(--lion-dark);
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-edit:hover {
        background: var(--prussian);
        border-color: var(--prussian);
    }

    .btn-back {
        display: inline-block;
        padding: 10px 18px;
        background: var(--wheat);
        color: var(--prussian);
        text-decoration: none;
        border: 1px solid var(--lion);
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-back:hover {
        background: var(--columbia);
        border-color: var(--prussian);
    }

    .btn-delete {
        cursor: pointer;
        padding: 10px 18px;
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
        margin-left: auto;
    }

    .btn-delete:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    @media (max-width: 768px) {
        h2 {
            font-size: 25px;
        }

        .detail-meta {
            grid-template-columns: 1fr;
        }

        .btn-delete {
            margin-left: 0;
        }
    }
</style>

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