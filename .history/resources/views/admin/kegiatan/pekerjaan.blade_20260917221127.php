@extends('layouts.app')

@section('title', 'Kebutuhan Pekerjaan Kegiatan')

@section('content')
    <h1>Kebutuhan Pekerjaan Kegiatan</h1>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="jenis_pekerjaan_id">Jenis Pekerjaan</label>
            <select id="jenis_pekerjaan_id" name="jenis_pekerjaan_id">
                <option value="1">Penanaman</option>
                <option value="2">Pembersihan Lahan</option>
            </select>
        </div>

        <div>
            <label for="jumlah_orang_dibutuhkan">Jumlah Orang Dibutuhkan</label>
            <input id="jumlah_orang_dibutuhkan" name="jumlah_orang_dibutuhkan" type="number" value="5">
        </div>

        <div>
            <label for="jumlah_satuan">Jumlah Satuan</label>
            <input id="jumlah_satuan" name="jumlah_satuan" type="number" value="1">
        </div>

        <div>
            <label for="tarif_per_satuan">Tarif per Satuan</label>
            <input id="tarif_per_satuan" name="tarif_per_satuan" type="number" value="150000">
        </div>

        <div>
            <label for="tingkat_kemampuan_minimal">Tingkat Kemampuan Minimal</label>
            <select id="tingkat_kemampuan_minimal" name="tingkat_kemampuan_minimal">
                <option value="pemula">Pemula</option>
                <option value="menengah">Menengah</option>
                <option value="mahir">Mahir</option>
            </select>
        </div>

        <div>
            <label for="catatan">Catatan</label>
            <textarea id="catatan" name="catatan"></textarea>
        </div>

        <button type="submit">Simpan Kebutuhan</button>
    </form>
@endsection
