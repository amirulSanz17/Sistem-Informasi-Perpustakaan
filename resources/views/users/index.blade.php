@extends('layouts.app')

@section('title', 'Manajemen User')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users/index.css') }}">
@endpush

@section('content')
<div class="users-page">

    <div class="users-header">
        <div>
            <h1>Manajemen User</h1>

            <p class="page-description">
                Login sebagai: {{ auth()->user()->name }}
                ({{ ucfirst(auth()->user()->role) }})
            </p>
        </div>

        <a class="users-add" href="{{ route('users.create') }}">
            + Tambah User
        </a>
    </div>

    @if (session('success'))
        <p class="users-message">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p class="users-error">{{ session('error') }}</p>
    @endif

    @if ($errors->any())
        <ul class="users-error">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="users-table-wrapper">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <a class="users-edit"
                               href="{{ route('users.edit', $user) }}">
                                Edit
                            </a>

                            @if ($user->id !== auth()->id())
                                <form
                                    action="{{ route('users.destroy', $user) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus user ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button class="users-delete"
                                            type="submit">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}

</div>
@endsection