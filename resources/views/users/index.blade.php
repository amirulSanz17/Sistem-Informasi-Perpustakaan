@extends('layouts.app')

@section('title', 'Manajemen User')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users/index.css') }}">
@endpush

@section('content')
<div class="users-page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen User</h1>
            <p class="page-description">
                Login sebagai: {{ auth()->user()->name }}
                ({{ ucfirst(auth()->user()->role) }})
            </p>
        </div>

        <a href="{{ route('users.create') }}" class="btn btn-primary">
            + Tambah User
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-container">
        <table class="user-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @if ($users->count() > 0)
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-edit">
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

                                            <button type="submit" class="btn btn-delete">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="empty-state">
                            Belum ada user.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>

</div>
@endsection