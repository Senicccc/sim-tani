@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
    <h1>Tambah Anggota</h1>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="nomor_anggota">Nomor Anggota</label>
            <input id="nomor_anggota" name="nomor_anggota" type="text">
        </div>

        <div>
            <label for="nama_lengkap">Nama Lengkap</label>
            <input id="nama_lengkap" name="nama_lengkap" type="text">
        </div>

        <div>
            <label for="nomor_wa">Nomor WA</label>
            <input id="nomor_wa" name="nomor_wa" type="text">
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email">
        </div>

        <div>
            <label for="role">Role</label>
            <select id="role" name="role">
                <option value="anggota">Anggota</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection
