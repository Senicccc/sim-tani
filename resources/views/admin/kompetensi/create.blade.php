@extends('layouts.app')

@section('title', 'Tambah Kompetensi')

@section('content')
    <h1>Tambah Kompetensi</h1>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="anggota_id">Anggota</label>
            <select id="anggota_id" name="anggota_id">
                <option value="1">Anggota SimTani</option>
                <option value="2">Anggota Lain</option>
            </select>
        </div>

        <div>
            <label for="jenis_pekerjaan_id">Jenis Pekerjaan</label>
            <select id="jenis_pekerjaan_id" name="jenis_pekerjaan_id">
                <option value="1">Penanaman</option>
                <option value="2">Pembersihan Lahan</option>
            </select>
        </div>

        <div>
            <label for="tingkat_kemampuan">Tingkat Kemampuan</label>
            <select id="tingkat_kemampuan" name="tingkat_kemampuan">
                <option value="pemula">Pemula</option>
                <option value="menengah">Menengah</option>
                <option value="mahir">Mahir</option>
            </select>
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection
