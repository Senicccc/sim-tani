<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'SIM-TANI')</title>
    </head>
    <body>
        <header>
            <nav>
                <div>
                    <strong><a href="{{ route('home') }}">SIM-TANI</a></strong>
                </div>

                <div>
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                    <a href="{{ route('anggota.dashboard') }}">Dashboard Anggota</a>
                    <a href="{{ route('admin.anggota.index') }}">Anggota</a>
                    <a href="{{ route('admin.jenis-pekerjaan.index') }}">Jenis Pekerjaan</a>
                    <a href="{{ route('admin.kompetensi.index') }}">Kompetensi</a>
                    <a href="{{ route('admin.kegiatan.index') }}">Kegiatan</a>
                    <a href="{{ route('admin.penjadwalan.index') }}">Penjadwalan</a>
                    <a href="{{ route('admin.penugasan.index') }}">Penugasan</a>
                    <a href="{{ route('admin.presensi.index') }}">Presensi</a>
                    <a href="{{ route('admin.upah.index') }}">Upah</a>
                    <a href="{{ route('admin.permintaan.index') }}">Permintaan</a>
                    <a href="{{ route('admin.riwayat-tugas') }}">Riwayat</a>
                    <a href="{{ route('admin.laporan') }}">Laporan</a>
                    <a href="{{ route('admin.profil') }}">Profil</a>
                </div>
            </nav>
        </header>

        <main>
            @if(session('success'))
                <div>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </body>
</html>
