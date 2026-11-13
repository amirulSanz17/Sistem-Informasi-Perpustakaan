@extends('layouts.app')

@section('title', 'Detail Anggota')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/members/show.css') }}">
@endpush

@section('content')
    <div class="detail-card">
        <div class="card-header">
            <h1>Detail Anggota</h1>
            <p>Informasi lengkap anggota perpustakaan</p>
        </div>

        <div class="card-body">
            <div class="avatar">👤</div>

            <div class="detail-row">
                <div class="detail-label">Nama Lengkap</div>
                <div class="detail-value">{{ $member->name }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Email</div>
                <div class="detail-value">{{ $member->email ?? '-' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Nomor Telepon</div>
                <div class="detail-value">{{ $member->phone ?? '-' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Alamat</div>
                <div class="detail-value">{{ $member->address ?? '-' }}</div>
            </div>

            <div class="actions">
                <a href="{{ route('members.edit', $member) }}" class="btn btn-primary">
                    Edit Anggota
                </a>

                <a href="{{ route('members.index') }}" class="btn btn-secondary">
                    ← Kembali ke Daftar Anggota
                </a>
            </div>
        </div>
    </div>
@endsection