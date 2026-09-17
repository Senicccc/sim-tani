@extends('layouts.app')

@section('title', 'Login SIM-TANI')

@section('content')
    <h1>Login SIM-TANI</h1>
    <p>Prototype halaman login. Autentikasi aktual tetap di backend API Laravel Sanctum.</p>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="identifier">Email atau Nomor Anggota</label>
            <input id="identifier" name="identifier" type="text" placeholder="contoh: admin@simtani.test">
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password">
        </div>

        <button type="submit">Login</button>
    </form>

    <p>
        <a href="{{ route('admin.dashboard') }}">Demo masuk admin</a>
    </p>
    <p>
        <a href="{{ route('anggota.dashboard') }}">Demo masuk anggota</a>
    </p>
@endsection
