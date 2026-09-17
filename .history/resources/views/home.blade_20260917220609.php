@extends('layouts.app')

@section('title', 'SIM-TANI - Beranda')

@section('content')
    <h1>SIM-TANI</h1>
    <p>Sistem Informasi Manajemen Kelompok Tani.</p>
    <p>Prototype UI untuk alur admin dan anggota.</p>

    <p>
        <a href="{{ route('login') }}">Masuk ke Login</a>
    </p>
    <p>
        <a href="{{ route('admin.dashboard') }}">Lihat Dashboard Admin</a>
    </p>
    <p>
        <a href="{{ route('anggota.dashboard') }}">Lihat Dashboard Anggota</a>
    </p>
@endsection
