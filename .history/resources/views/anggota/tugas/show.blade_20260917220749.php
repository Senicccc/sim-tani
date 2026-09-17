@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
    <h1>Detail Tugas</h1>

    <p><strong>Kegiatan:</strong> Panen Musim</p>
    <p><strong>Jenis Pekerjaan:</strong> Penanaman</p>
    <p><strong>Tanggal:</strong> 2026-10-01</p>
    <p><strong>Lokasi:</strong> Lahan Desa</p>
    <p><strong>Status:</strong> Assigned</p>
    <p><strong>Catatan:</strong> Tunggu konfirmasi presensi dari admin.</p>

    <div>
        <p><a href="#">Kirim Presensi</a></p>
        <p><a href="#">Ajukan Permintaan</a></p>
        <p><a href="{{ route('anggota.riwayat.index') }}">Riwayat Pekerjaan</a></p>
    </div>
@endsection
