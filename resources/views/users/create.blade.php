@extends('layouts.app')

@section('title', 'Tambah User')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users/create.css') }}">
@endpush

@section('content')
<div class="users-page">
    <h1>Tambah User</h1>

    <p>Buat akun baru untuk Admin atau Petugas perpustakaan.</p>

    @if ($errors->any())
        <ul class="users-error">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="users-form-card">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="users-form-group">
                <label for="name">Nama Lengkap</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    maxlength="255"
                    required
                >
            </div>

            <div class="users-form-group">
                <label for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    maxlength="255"
                    required
                >
            </div>

            <div class="users-form-group">
                <label for="password">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >
                <p class="users-hint">Minimal 8 karakter.</p>
            </div>

            <div class="users-form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >
            </div>

            <div class="users-form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" @selected(old('role') === 'admin')>
                        Admin
                    </option>
                    <option value="petugas" @selected(old('role') === 'petugas')>
                        Petugas
                    </option>
                </select>
            </div>

            <div class="users-form-actions">
                <button type="submit" class="users-add">
                    Simpan User
                </button>

                <a class="users-back" href="{{ route('users.index') }}">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection