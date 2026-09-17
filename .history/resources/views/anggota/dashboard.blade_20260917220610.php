@extends('layouts.app')

@section('title', 'Dashboard Anggota')

@section('content')
    <h1>Dashboard Anggota</h1>

    <div>
        <h2>Ringkasan Saya</h2>
        <ul>
            <li>Tugas hari ini: 3</li>
            <li>Tugas mendatang: 2</li>
            <li>Jumlah tugas selesai: 18</li>
            <li>Permintaan yang sedang diproses: 1</li>
            <li>Total upah belum dibayar: Rp 1.150.000</li>
        </ul>
    </div>

    <div>
        <h2>Menu Anggota</h2>
        <ul>
            <li><a href="{{ route('anggota.profil') }}">Profil</a></li>
            <li><a href="{{ route('anggota.tugas.index') }}">Daftar Tugas</a></li>
            <li><a href="{{ route('anggota.riwayat-tugas') }}">Riwayat Tugas</a></li>
            <li><a href="{{ route('anggota.presensi') }}">Presensi</a></li>
            <li><a href="{{ route('anggota.upah') }}">Upah</a></li>
            <li><a href="{{ route('anggota.permintaan.index') }}">Permintaan Perubahan</a></li>
        </ul>
    </div>
@endsection
