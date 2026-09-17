@extends('layouts.app')

@section('title', 'Tambah Kegiatan')

@section('content')
    <h1>Tambah Kegiatan</h1>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="nama_kegiatan">Nama Kegiatan</label>
            <input id="nama_kegiatan" name="nama_kegiatan" type="text">
        </div>

        <div>
            <label for="lokasi">Lokasi</label>
            <input id="lokasi" name="lokasi" type="text">
        </div>

        <div>
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input id="tanggal_mulai" name="tanggal_mulai" type="date">
        </div>

        <div>
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input id="tanggal_selesai" name="tanggal_selesai" type="date">
        </div>

        <div>
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="draft">Draft</option>
                <option value="scheduled">Scheduled</option>
                <option value="ongoing">Ongoing</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div>
            <label for="metode_penjadwalan">Metode Penjadwalan</label>
            <select id="metode_penjadwalan" name="metode_penjadwalan">
                <option value="manual">Manual</option>
                <option value="otomatis">Otomatis</option>
            </select>
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection
