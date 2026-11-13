@extends('layouts.app')

@section('title', 'Tambah Anggota')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/members/create.css') }}">
@endpush

@section('content')
    <div class="form-card">

        <h1>Tambah Anggota</h1>
        <p class="subtitle">
            Masukkan informasi anggota perpustakaan.
        </p>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('members.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap *</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                >
            </div>

            <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="Masukkan nomor telepon"
                >
            </div>

            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea
                    id="address"
                    name="address"
                    placeholder="Masukkan alamat anggota"
                >{{ old('address') }}</textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">
                    Simpan Anggota
                </button>

                <a href="{{ route('members.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection