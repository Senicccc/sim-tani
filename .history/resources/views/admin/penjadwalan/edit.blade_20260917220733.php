@extends('layouts.app')

@section('title', 'Edit Penjadwalan Manual')

@section('content')
    <h1>Edit Penjadwalan Manual</h1>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="activity">Kegiatan</label>
            <input id="activity" name="activity" type="text" value="Panen Musim">
        </div>

        <div>
            <label for="job_type">Jenis Pekerjaan</label>
            <input id="job_type" name="job_type" type="text" value="Penanaman">
        </div>

        <div>
            <label for="current_member">Anggota Saat Ini</label>
            <input id="current_member" name="current_member" type="text" value="Anggota SimTani">
        </div>

        <div>
            <label for="replacement_member">Anggota Pengganti</label>
            <select id="replacement_member" name="replacement_member">
                <option value="1">Anggota SimTani</option>
                <option value="2">Anggota Lain</option>
            </select>
        </div>

        <div>
            <label for="reason">Alasan / Catatan</label>
            <textarea id="reason" name="reason">Perubahan jadwal karena kebutuhan lapangan</textarea>
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
@endsection
