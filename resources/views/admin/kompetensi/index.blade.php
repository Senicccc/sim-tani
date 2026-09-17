@extends('layouts.app')

@section('title', 'Kompetensi Anggota')

@section('content')
    <h1>Kompetensi Anggota</h1>

    <p><a href="{{ route('admin.kompetensi.create') }}">Tambah Kompetensi</a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Anggota</th>
                <th>Jenis Pekerjaan</th>
                <th>Tingkat Kemampuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Anggota SimTani</td>
                <td>Penanaman</td>
                <td>Menengah</td>
                <td>
                    <a href="{{ route('admin.kompetensi.edit', ['id' => 1]) }}">Edit</a>
                    <button type="button">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Anggota Lain</td>
                <td>Pembersihan Lahan</td>
                <td>Pemula</td>
                <td>
                    <a href="{{ route('admin.kompetensi.edit', ['id' => 2]) }}">Edit</a>
                    <button type="button">Hapus</button>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
