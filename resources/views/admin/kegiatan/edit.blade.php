@extends('layouts.app')

@section('title', 'Edit Kegiatan')

@section('content')
    <h1>Edit Kegiatan</h1>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="nama_kegiatan">Nama Kegiatan</label>
            <input id="nama_kegiatan" name="nama_kegiatan" type="text" value="Panen Musim">
        </div>

        <div>
            <label for="lokasi">Lokasi</label>
            <input id="lokasi" name="lokasi" type="text" value="Lahan Desa">
        </div>

        <div>
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input id="tanggal_mulai" name="tanggal_mulai" type="date" value="2026-10-01">
        </div>

        <div>
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input id="tanggal_selesai" name="tanggal_selesai" type="date" value="2026-10-03">
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
@endsection
