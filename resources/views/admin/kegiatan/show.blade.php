@extends('layouts.app')

@section('title', 'Detail Kegiatan')

@section('content')
    <h1>Detail Kegiatan</h1>

    <p><strong>Nama:</strong> Panen Musim</p>
    <p><strong>Lokasi:</strong> Lahan Desa</p>
    <p><strong>Tanggal:</strong> 2026-10-01 s/d 2026-10-03</p>
    <p><strong>Status:</strong> Draft</p>
    <p><strong>Metode Penjadwalan:</strong> Manual</p>

    <div>
        <h2>Kebutuhan Pekerjaan</h2>
        <ul>
            <li>Penanaman - 5 orang - 1 hari</li>
            <li>Pembersihan Lahan - 3 orang - 2 hari</li>
        </ul>
    </div>

    <div>
        <h2>Penugasan</h2>
        <ul>
            <li>Belum dibuat</li>
        </ul>
    </div>

    <p>
        <a href="{{ route('admin.kegiatan.pekerjaan', ['activity' => $id]) }}">Tambah Kebutuhan Pekerjaan</a>
    </p>
    <p>
        <a href="{{ route('admin.penjadwalan.index') }}">Generate Jadwal Otomatis</a>
    </p>
    <p>
        <a href="{{ route('admin.kegiatan.edit', ['id' => $id]) }}">Edit Kegiatan</a>
    </p>
@endsection
