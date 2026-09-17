@extends('layouts.app')

@section('title', 'Kelola Kegiatan')

@section('content')
    <h1>Kelola Kegiatan</h1>

    <p><a href="{{ route('admin.kegiatan.create') }}">Tambah Kegiatan</a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Kegiatan</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Metode Penjadwalan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Panen Musim</td>
                <td>Lahan Desa</td>
                <td>2026-10-01 s/d 2026-10-03</td>
                <td>Draft</td>
                <td>Manual</td>
                <td>
                    <a href="{{ route('admin.kegiatan.show', ['id' => 1]) }}">Lihat</a>
                    <a href="{{ route('admin.kegiatan.edit', ['id' => 1]) }}">Edit</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
