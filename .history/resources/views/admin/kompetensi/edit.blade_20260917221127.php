@extends('layouts.app')

@section('title', 'Edit Kompetensi')

@section('content')
    <h1>Edit Kompetensi</h1>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="anggota_id">Anggota</label>
            <select id="anggota_id" name="anggota_id">
                <option value="1" selected>Anggota SimTani</option>
            </select>
        </div>

        <div>
            <label for="jenis_pekerjaan_id">Jenis Pekerjaan</label>
            <select id="jenis_pekerjaan_id" name="jenis_pekerjaan_id">
                <option value="1" selected>Penanaman</option>
            </select>
        </div>

        <div>
            <label for="tingkat_kemampuan">Tingkat Kemampuan</label>
            <select id="tingkat_kemampuan" name="tingkat_kemampuan">
                <option value="pemula">Pemula</option>
                <option value="menengah" selected>Menengah</option>
                <option value="mahir">Mahir</option>
            </select>
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
@endsection
