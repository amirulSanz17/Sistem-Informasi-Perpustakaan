@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<style>
    :root {
        --prussian: #032A42;
        --columbia: #D1E2F3;
        --beige: #F0F0DC;
        --wheat: #F0D8B6;
        --lion: #B3926F;
        --lion-dark: #8C6A4D;
    }

    .container {
        font-family: "Segoe UI", Arial, sans-serif;
        color: var(--prussian);
    }

    h2 {
        color: var(--prussian);
        font-size: 30px;
        margin: 0 0 20px;
    }

    .alert-success {
        color: var(--prussian);
        background: var(--columbia);
        border-left: 5px solid var(--prussian);
        padding: 13px 16px;
        margin-bottom: 20px;
        border-radius: 8px;
    }

    .alert-error {
        color: #721c24;
        background: #f8d7da;
        border-left: 5px solid #dc3545;
        padding: 13px 16px;
        margin-bottom: 20px;
        border-radius: 8px;
    }

    .btn-add {
        display: inline-block;
        padding: 12px 17px;
        margin-bottom: 20px;
        background: var(--lion);
        color: white;
        text-decoration: none;
        border: 1px solid var(--lion-dark);
        border-radius: 9px;
        font-weight: 600;
        box-shadow: 0 5px 12px rgba(179, 146, 111, 0.2);
        transition: 0.2s;
    }

    .btn-add:hover {
        background: var(--prussian);
        border-color: var(--prussian);
        color: white;
        transform: translateY(-1px);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        background: white;
        border: 1px solid #D9C4AA;
        border-radius: 13px;
        box-shadow: 0 12px 30px rgba(3, 42, 66, 0.10);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #E9DFD2;
    }

    th {
        background: var(--prussian);
        color: var(--beige);
        font-size: 14px;
        font-weight: 600;
        border-bottom: 4px solid var(--lion);
    }

    tbody tr:nth-child(even) {
        background: #FCFAF6;
    }

    tbody tr:hover {
        background: var(--columbia);
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    td {
        font-size: 14px;
    }

    td a {
        color: var(--lion-dark);
        font-weight: 600;
        text-decoration: none;
    }

    td a:hover {
        color: var(--prussian);
        text-decoration: underline;
    }

    .action-form {
        display: inline;
        margin-left: 5px;
    }

    .btn-delete {
        cursor: pointer;
        padding: 7px 11px;
        background: var(--wheat);
        color: var(--prussian);
        border: 1px solid var(--lion);
        border-radius: 6px;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-delete:hover {
        background: var(--lion);
        color: white;
    }

    .pagination-wrapper {
        margin-top: 22px;
    }

    @media (max-width: 768px) {
        h2 {
            font-size: 25px;
        }

        th, td {
            padding: 12px;
        }
    }
</style>

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