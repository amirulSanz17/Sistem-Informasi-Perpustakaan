@extends('layouts.app')

@section('title', 'Manajemen Anggota')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/members/index.css') }}">
@endpush

@section('content')
    <div class="members-page">

        <div class="page-header">
            <div>
                <h1 class="page-title">Data Anggota Perpustakaan</h1>
                <p class="page-description">
                    Kelola data anggota perpustakaan.
                </p>
            </div>

            <a href="{{ route('members.create') }}" class="btn btn-primary">
                + Tambah Anggota
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="member-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td>{{ $members->firstItem() + $loop->index }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email ?? '-' }}</td>
                            <td>{{ $member->phone ?? '-' }}</td>
                            <td>{{ $member->address ?? '-' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a
                                        href="{{ route('members.show', $member) }}"
                                        class="btn btn-primary"
                                    >
                                        Detail
                                    </a>

                                    <a
                                        href="{{ route('members.edit', $member) }}"
                                        class="btn btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('members.destroy', $member) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus anggota ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                Belum ada data anggota.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $members->links() }}
        </div>

    </div>
@endsection