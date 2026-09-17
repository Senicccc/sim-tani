@extends('layouts.app')

@section('title', 'Jenis Pekerjaan')

@section('content')
    <h1>Jenis Pekerjaan</h1>

    <p><a href="{{ route('admin.jenis-pekerjaan.create') }}">Tambah Jenis Pekerjaan</a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Pekerjaan</th>
                <th>Deskripsi</th>
                <th>Satuan</th>
                <th>Tarif Default</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Penanaman</td>
                <td>Memasukkan benih ke lahan</td>
                <td>hari</td>
                <td>Rp 150.000</td>
                <td>Aktif</td>
                <td>
                    <a href="{{ route('admin.jenis-pekerjaan.edit', ['id' => 1]) }}">Edit</a>
                    <button type="button">Nonaktifkan</button>
                </td>
            </tr>
            <tr>
                <td>Pembersihan Lahan</td>
                <td>Pembersihan area kerja</td>
                <td>hari</td>
                <td>Rp 200.000</td>
                <td>Aktif</td>
                <td>
                    <a href="{{ route('admin.jenis-pekerjaan.edit', ['id' => 2]) }}">Edit</a>
                    <button type="button">Nonaktifkan</button>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
