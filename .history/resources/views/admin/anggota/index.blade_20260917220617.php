@extends('layouts.app')

@section('title', 'Kelola Anggota')

@section('content')
    <h1>Kelola Anggota</h1>

    <p><a href="{{ route('admin.anggota.create') }}">Tambah Anggota</a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Nomor Anggota</th>
                <th>Nama</th>
                <th>Nomor WA</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ADM001</td>
                <td>Admin SimTani</td>
                <td>081234567890</td>
                <td>admin@simtani.test</td>
                <td>admin</td>
                <td>Aktif</td>
                <td>
                    <a href="{{ route('admin.anggota.show', ['id' => 1]) }}">Lihat</a>
                    <a href="{{ route('admin.anggota.edit', ['id' => 1]) }}">Edit</a>
                    <button type="button">Nonaktifkan</button>
                </td>
            </tr>
            <tr>
                <td>AGT001</td>
                <td>Anggota SimTani</td>
                <td>081234567891</td>
                <td>anggota@simtani.test</td>
                <td>anggota</td>
                <td>Aktif</td>
                <td>
                    <a href="{{ route('admin.anggota.show', ['id' => 2]) }}">Lihat</a>
                    <a href="{{ route('admin.anggota.edit', ['id' => 2]) }}">Edit</a>
                    <button type="button">Nonaktifkan</button>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
