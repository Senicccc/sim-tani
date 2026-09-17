@extends('layouts.app')

@section('title', 'Tugas Saya')

@section('content')
    <h1>Tugas Saya</h1>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Kegiatan</th>
                <th>Jenis Pekerjaan</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Panen Musim</td>
                <td>Penanaman</td>
                <td>2026-10-01</td>
                <td>Lahan Desa</td>
                <td>Assigned</td>
                <td>
                    <a href="{{ route('anggota.tugas.show', ['id' => 1]) }}">Detail</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
