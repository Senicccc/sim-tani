@extends('layouts.app')

@section('title', 'Edit Jenis Pekerjaan')

@section('content')
    <h1>Edit Jenis Pekerjaan</h1>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="nama_pekerjaan">Nama Pekerjaan</label>
            <input id="nama_pekerjaan" name="nama_pekerjaan" type="text" value="Penanaman">
        </div>

        <div>
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi">Memasukkan benih ke lahan</textarea>
        </div>

        <div>
            <label for="satuan">Satuan</label>
            <input id="satuan" name="satuan" type="text" value="hari">
        </div>

        <div>
            <label for="tarif_default">Tarif Default</label>
            <input id="tarif_default" name="tarif_default" type="number" value="150000">
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
@endsection
