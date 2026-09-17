@extends('layouts.app')

@section('title', 'Kelola Penugasan')

@section('content')
    <h1>Kelola Penugasan</h1>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Kegiatan</th>
                <th>Anggota</th>
                <th>Jenis Pekerjaan</th>
                <th>Status</th>
                <th>Sumber</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Panen Musim</td>
                <td>Anggota SimTani</td>
                <td>Penanaman</td>
                <td>Assigned</td>
                <td>Otomatis</td>
                <td>2026-10-01</td>
                <td>
                    <a href="{{ route('admin.penugasan.show', ['id' => 1]) }}">Lihat</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
