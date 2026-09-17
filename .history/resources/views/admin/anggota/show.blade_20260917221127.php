@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
    <h1>Detail Anggota</h1>

    <p><strong>Nomor Anggota:</strong> AGT001</p>
    <p><strong>Nama:</strong> Anggota SimTani</p>
    <p><strong>Nomor WA:</strong> 081234567891</p>
    <p><strong>Email:</strong> anggota@simtani.test</p>
    <p><strong>Role:</strong> anggota</p>
    <p><strong>Status:</strong> aktif</p>

    <p>
        <a href="{{ route('admin.anggota.edit', ['id' => $id]) }}">Edit Anggota</a>
    </p>
@endsection
