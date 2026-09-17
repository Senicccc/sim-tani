@extends('layouts.app')

@section('title', 'Tambah Jenis Pekerjaan')

@section('content')
    <h1>Tambah Jenis Pekerjaan</h1>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="nama_pekerjaan">Nama Pekerjaan</label>
            <input id="nama_pekerjaan" name="nama_pekerjaan" type="text">
        </div>

        <div>
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi"></textarea>
        </div>

        <div>
            <label for="satuan">Satuan</label>
            <input id="satuan" name="satuan" type="text" placeholder="contoh: hari">
        </div>

        <div>
            <label for="tarif_default">Tarif Default</label>
            <input id="tarif_default" name="tarif_default" type="number">
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection
