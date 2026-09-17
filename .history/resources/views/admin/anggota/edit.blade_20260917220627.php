@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <h1>Edit Anggota</h1>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="nama_lengkap">Nama Lengkap</label>
            <input id="nama_lengkap" name="nama_lengkap" type="text" value="Anggota SimTani">
        </div>

        <div>
            <label for="nomor_wa">Nomor WA</label>
            <input id="nomor_wa" name="nomor_wa" type="text" value="081234567891">
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="anggota@simtani.test">
        </div>

        <div>
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="aktif" selected>Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
@endsection
