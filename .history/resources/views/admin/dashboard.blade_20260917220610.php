@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h1>Dashboard Admin</h1>

    <div>
        <h2>Ringkasan</h2>
        <ul>
            <li>Total Anggota: 128</li>
            <li>Total Kegiatan: 18</li>
            <li>Tugas Berjalan: 24</li>
            <li>Permintaan Perubahan: 5</li>
            <li>Upah Belum Dibayar: Rp 4.800.000</li>
            <li>Tugas Selesai: 142</li>
        </ul>
    </div>

    <div>
        <h2>Menu Utama</h2>
        <ul>
            <li><a href="{{ route('admin.anggota.index') }}">Kelola Anggota</a></li>
            <li><a href="{{ route('admin.jenis-pekerjaan.index') }}">Kelola Jenis Pekerjaan</a></li>
            <li><a href="{{ route('admin.kompetensi.index') }}">Kelola Kompetensi Anggota</a></li>
            <li><a href="{{ route('admin.kegiatan.index') }}">Kelola Kegiatan</a></li>
            <li><a href="{{ route('admin.penjadwalan.index') }}">Generate Jadwal Otomatis</a></li>
            <li><a href="{{ route('admin.penugasan.index') }}">Kelola Penugasan</a></li>
            <li><a href="{{ route('admin.presensi.index') }}">Kelola Presensi</a></li>
            <li><a href="{{ route('admin.upah.index') }}">Kelola Upah</a></li>
            <li><a href="{{ route('admin.permintaan.index') }}">Permintaan Perubahan</a></li>
            <li><a href="{{ route('admin.riwayat-tugas') }}">Riwayat Tugas</a></li>
            <li><a href="{{ route('admin.laporan') }}">Laporan</a></li>
            <li><a href="{{ route('admin.profil') }}">Profil Admin</a></li>
        </ul>
    </div>
@endsection
