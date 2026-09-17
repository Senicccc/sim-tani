@extends('layouts.app')

@section('title', 'Detail Penugasan')

@section('content')
    <h1>Detail Penugasan</h1>

    <p><strong>Kegiatan:</strong> Panen Musim</p>
    <p><strong>Jenis Pekerjaan:</strong> Penanaman</p>
    <p><strong>Anggota:</strong> Anggota SimTani</p>
    <p><strong>Status:</strong> Assigned</p>
    <p><strong>Sumber:</strong> Otomatis</p>
    <p><strong>Catatan Penyelesaian:</strong> -</p>
    <p><strong>Bukti:</strong> -</p>

    <div>
        <p><a href="#">Edit Penugasan</a></p>
        <p><a href="#">Verifikasi</a></p>
        <p><a href="{{ route('admin.presensi.index') }}">Lihat Presensi</a></p>
        <p><a href="{{ route('admin.upah.index') }}">Lihat Upah</a></p>
    </div>
@endsection
