@extends('layouts.app')

@section('title', 'Penjadwalan Otomatis')

@section('content')
    <h1>Penjadwalan Otomatis</h1>

    <p>Prototype halaman jadwal otomatis. Logika otomatis sudah ada di backend service, UI akan dihubungkan di fase berikutnya.</p>

    <form method="POST" action="{{ route('admin.penjadwalan.generate') }}">
        @csrf

        <div>
            <label for="activity_id">Pilih Kegiatan</label>
            <select id="activity_id" name="activity_id">
                <option value="1">Panen Musim</option>
                <option value="2">Pembersihan Lahan</option>
            </select>
        </div>

        <button type="submit">Generate Jadwal Otomatis</button>
    </form>

    <h2>Persyaratan</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Jenis Pekerjaan</th>
                <th>Jumlah</th>
                <th>Skill Minimal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Penanaman</td>
                <td>5</td>
                <td>Pemula</td>
            </tr>
        </tbody>
    </table>

    <h2>Jadwal Terbaru</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Anggota</th>
                <th>Jenis Pekerjaan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Anggota SimTani</td>
                <td>Penanaman</td>
                <td>Assigned</td>
            </tr>
        </tbody>
    </table>

    <p><a href="{{ route('admin.penjadwalan.edit', ['id' => 1]) }}">Edit Manual</a></p>
@endsection
