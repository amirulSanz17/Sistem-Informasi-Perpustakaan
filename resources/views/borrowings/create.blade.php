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
        id="borrowingForm"
        action="{{ route('borrowings.store') }}"
        method="POST"
        class="borrowing-form"
    >
        @csrf
        <div class="form-section">
            <h3>Informasi Anggota</h3>
            <div class="form-group">
                <label for="member_search">Cari Nama Anggota</label>
                <input
                    type="text"
                    id="member_search"
                    placeholder="Ketik nama anggota..."
                    autocomplete="off"
                >
                <small>
                    Ketik nama anggota untuk mencari dan memilih anggota.
                </small>
            </div>
            <div class="member-list" id="member-list">
                @forelse ($members as $member)
                    <label
                        class="member-result"
                        data-name="{{ strtolower($member->name) }}"
                    >
                        <input
                            type="radio"
                            name="member_id"
                            value="{{ $member->id }}"
                            {{ old('member_id') == $member->id ? 'checked' : '' }}
                            required
                        >
                        <span>{{ $member->name }}</span>
                    </label>
                @empty
                    <p class="member-not-found">
                        Belum ada data anggota.
                    </p>
                @endforelse
            </div>
            <p class="member-empty" id="member-empty" hidden>
                Anggota tidak ditemukan.
            </p>
        </div>

        <div class="form-section">
            <h3>Informasi Peminjaman</h3>
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
            @php
                $oldItems = old('items', [
                    ['book_id' => '', 'quantity' => 1]
                ]);
            @endphp
            <div id="book-items">
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
                                        {{ $book->title }}
                                        (Stok: {{ $book->stock }})
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
                        >
                            Hapus
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-actions">
            <a
                href="{{ route('borrowings.index') }}"
                class="btn btn-back"
            >
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                Simpan Peminjaman
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('member_search');
    const memberResults = document.querySelectorAll('.member-result');
    const emptyMessage = document.getElementById('member-empty');

    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();
        let found = 0;
        memberResults.forEach(function (member) {
            const name = member.dataset.name;
            const match = name.includes(keyword);
            member.style.display = match ? 'flex' : 'none';
            if (match) {
                found++;
            }
        });
        emptyMessage.hidden = found !== 0;
    });

    const memberSearch = document.getElementById('member_search');
    const memberList = document.querySelector('.member-list');

    memberSearch.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();
        const members = document.querySelectorAll('.member-result');
        let found = 0;
        members.forEach(function (member) {
            const name = member.querySelector('span').textContent.toLowerCase();
            if (keyword !== '' && name.includes(keyword)) {
                member.style.display = 'flex';
                found++;
            } else {
                member.style.display = 'none';
            }
        });
        if (keyword !== '' && found > 0) {
            memberList.classList.add('show');
        } else {
            memberList.classList.remove('show');
        }
    });

    let bookIndex = {{ count($oldItems) }};
    const addBookButton = document.getElementById('add-book');
    const bookContainer = document.getElementById('book-items');
    addBookButton.addEventListener('click', function () {
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
            <button type="button" class="btn btn-remove">
                Hapus
            </button>
        `;
        bookContainer.appendChild(item);
        bookIndex++;
    });

    bookContainer.addEventListener('click', function (event) {
        if (!event.target.classList.contains('btn-remove')) {
            return;
        }
        if (bookContainer.children.length <= 1) {
            alert('Minimal harus ada satu buku.');
            return;
        }
        event.target.closest('.book-item').remove();
    });
});
</script>

@endsection
