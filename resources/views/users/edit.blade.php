@extends('layouts.app')

@section('title', 'Edit User')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users/edit.css') }}">
@endpush

@section('content')

<div class="users-page">
    <h1>Edit User</h1>
    <p>Perbarui informasi akun pengguna.</p>

    <div class="users-form-card">
        @if ($errors->any())
            <ul class="users-error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="users-form-group">
                <label for="name">Nama Lengkap</label>
                <input id="name" name="name" type="text"
                       value="{{ old('name', $user->name) }}"
                       maxlength="255" required>
            </div>

            <div class="users-form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email"
                       value="{{ old('email', $user->email) }}"
                       maxlength="255" required>
            </div>

            <div class="users-form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="admin"
                        @selected(old('role', $user->role) === 'admin')>
                        Admin
                    </option>
                    <option value="petugas"
                        @selected(old('role', $user->role) === 'petugas')>
                        Petugas
                    </option>
                </select>
            </div>

            <div class="users-form-group">
                <label for="password">Password Baru (Opsional)</label>
                <input id="password" name="password" type="password"
                       minlength="8" autocomplete="new-password">
                <p class="users-hint">
                    Kosongkan jika tidak ingin mengganti password.
                </p>
            </div>

            <div class="users-form-group">
                <label for="password_confirmation">
                    Konfirmasi Password Baru
                </label>
                <input id="password_confirmation"
                       name="password_confirmation"
                       type="password" minlength="8"
                       autocomplete="new-password">
            </div>

            <div class="users-form-actions">
                <button type="submit" class="users-add">
                    Simpan Perubahan
                </button>
                <a class="users-back" href="{{ route('users.index') }}">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@endsection