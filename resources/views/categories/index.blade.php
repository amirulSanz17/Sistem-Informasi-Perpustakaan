@extends('layouts.app')

@section('title', 'Manajemen Anggota')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/categories/index.css') }}">
@endpush

@section('content')
<div class="container">
    <h2>Daftar Kategori Buku</h2>

    @if (session('success'))
        <p class="alert-success">
            {{ session('success') }}
        </p>
    @endif

    @if (session('error'))
        <p class="alert-error">
            {{ session('error') }}
        </p>
    @endif

    @if ($errors->any())
        <div class="alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('categories.create') }}" class="btn-add">
        + Tambah Kategori
    </a>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>
                            {{ $categories->firstItem() + $loop->index }}
                        </td>

                        <td>{{ $category->name }}</td>

                        <td>
                            {{ $category->description ?: '-' }}
                        </td>

                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}">
                                Edit
                            </a>
                            
                            |

                            <form
                                action="{{ route('categories.destroy', $category->id) }}"
                                method="POST"
                                class="action-form"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">
                            Belum ada data kategori.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $categories->links() }}
    </div>
</div>
@endsection