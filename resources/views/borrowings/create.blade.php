
@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/borrowings/create.css') }}">
@endpush

@section('content')
<div class="container borrowings-page">

    <div class="page-header">
        <div>
            <h2 class="page-title">Tambah Peminjaman</h2>
            <p class="page-description">
                Masukkan data anggota, tanggal peminjaman,
                dan buku yang akan dipinjam.
            </p>
        </div>

        <a href="{{ route('borrowings.index') }}" class="btn btn-back">
            Kembali
        </a>
    </div>

    {{-- NOTIFIKASI VALIDASI --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('borrowings.store') }}"
        method="POST"
        class="borrowing-form"
    >
        @csrf

        {{-- INFORMASI PEMINJAMAN --}}
        <div class="form-section">

            <h3>Informasi Peminjaman</h3>

            <div class="form-group">
                <label for="member_id">Nama Anggota</label>

                <select name="member_id" id="member_id" required>
                    <option value="">-- Pilih Anggota --</option>

                    @foreach ($members as $member)
                        <option
                            value="{{ $member->id }}"
                            {{ old('member_id') == $member->id ? 'selected' : '' }}
                        >
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="borrow_date">Tanggal Peminjaman</label>

                <input
                    type="date"
                    name="borrow_date"
                    id="borrow_date"
                    value="{{ old('borrow_date', now()->toDateString()) }}"
                    max="{{ now()->toDateString() }}"
                    required
                >

                <small>
                    Pilih tanggal ketika anggota mulai meminjam buku.
                </small>
            </div>

            <div class="form-group">
                <label for="duration">Durasi Peminjaman</label>

                <input
                    type="text"
                    id="duration"
                    value="7 hari"
                    readonly
                >

                <small>
                    Due date dihitung otomatis oleh sistem,
                    yaitu 7 hari setelah tanggal peminjaman.
                </small>
            </div>

        </div>

        {{-- DAFTAR BUKU --}}
        <div class="form-section">

            <div class="section-header">
                <div>
                    <h3>Daftar Buku</h3>
                    <p>
                        Pilih buku dan masukkan jumlah yang dipinjam.
                    </p>
                </div>

                <button
                    type="button"
                    class="btn btn-add"
                    id="add-book"
                >
                    + Tambah Buku
                </button>
            </div>

            <div id="book-items">

                @php
                    $oldItems = old('items', [
                        ['book_id' => '', 'quantity' => 1]
                    ]);
                @endphp

                @foreach ($oldItems as $index => $oldItem)

                    <div class="book-item">

                        <div class="form-group book-select">
                            <label>Buku</label>

                            <select
                                name="items[{{ $index }}][book_id]"
                                required
                            >
                                <option value="">-- Pilih Buku --</option>

                                @foreach ($books as $book)
                                    <option
                                        value="{{ $book->id }}"
                                        {{ ($oldItem['book_id'] ?? '') == $book->id ? 'selected' : '' }}
                                    >
                                        {{ $book->title }} (Stok: {{ $book->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group quantity-group">
                            <label>Jumlah</label>

                            <input
                                type="number"
                                name="items[{{ $index }}][quantity]"
                                value="{{ $oldItem['quantity'] ?? 1 }}"
                                min="1"
                                required
                            >
                        </div>

                        <button
                            type="button"
                            class="btn btn-remove"
                            onclick="removeBook(this)"
                        >
                            Hapus
                        </button>

                    </div>

                @endforeach

            </div>

        </div>

        {{-- TOMBOL AKSI --}}
        <div class="form-actions">

            <a href="{{ route('borrowings.index') }}" class="btn btn-back">
                Batal
            </a>

            <button type="submit" class="btn btn-primary">
                Simpan Peminjaman
            </button>

        </div>

    </form>

</div>

<script>
    let bookIndex = {{ count($oldItems) }};

    // Menambahkan pilihan buku
    document.getElementById('add-book').addEventListener('click', function () {

        const container = document.getElementById('book-items');

        const item = document.createElement('div');

        item.className = 'book-item';

        item.innerHTML = `
            <div class="form-group book-select">
                <label>Buku</label>

                <select name="items[${bookIndex}][book_id]" required>
                    <option value="">-- Pilih Buku --</option>

                    @foreach ($books as $book)
                        <option value="{{ $book->id }}">
                            {{ $book->title }} (Stok: {{ $book->stock }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group quantity-group">
                <label>Jumlah</label>

                <input
                    type="number"
                    name="items[${bookIndex}][quantity]"
                    value="1"
                    min="1"
                    required
                >
            </div>

            <button
                type="button"
                class="btn btn-remove"
                onclick="removeBook(this)"
            >
                Hapus
            </button>
        `;

        container.appendChild(item);

        bookIndex++;
    });

    // Menghapus pilihan buku
    function removeBook(button) {

        const container = document.getElementById('book-items');

        if (container.children.length <= 1) {
            alert('Minimal harus ada satu buku.');
            return;
        }

        button.closest('.book-item').remove();
    }
</script>
@endsection
