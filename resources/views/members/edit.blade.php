@extends('layouts.app')

@section('title', 'Edit Anggota')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/members/edit.css') }}">
@endpush

@section('content')
    <div class="form-card">

        <h1>Edit Anggota</h1>
        <p class="subtitle">
            Perbarui informasi anggota perpustakaan di bawah ini.
        </p>

        @if ($errors->any())
            <div class="errors">
                <strong>Periksa kembali data kamu:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('members.update', $member) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Lengkap *</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $member->name) }}"
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
                    value="{{ old('email', $member->email) }}"
                    placeholder="contoh@email.com"
                >
            </div>

            <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $member->phone) }}"
                    placeholder="Masukkan nomor telepon"
                >
            </div>

            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea
                    id="address"
                    name="address"
                    placeholder="Masukkan alamat anggota"
                >{{ old('address', $member->address) }}</textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a href="{{ route('members.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection