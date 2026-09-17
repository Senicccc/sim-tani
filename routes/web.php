<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/anggota', function () {
        return view('admin.anggota.index');
    })->name('anggota.index');
    Route::get('/anggota/create', function () {
        return view('admin.anggota.create');
    })->name('anggota.create');
    Route::get('/anggota/{id}', function ($id) {
        return view('admin.anggota.show', ['id' => $id]);
    })->name('anggota.show');
    Route::get('/anggota/{id}/edit', function ($id) {
        return view('admin.anggota.edit', ['id' => $id]);
    })->name('anggota.edit');

    Route::get('/jenis-pekerjaan', function () {
        return view('admin.jenis-pekerjaan.index');
    })->name('jenis-pekerjaan.index');
    Route::get('/jenis-pekerjaan/create', function () {
        return view('admin.jenis-pekerjaan.create');
    })->name('jenis-pekerjaan.create');
    Route::get('/jenis-pekerjaan/{id}/edit', function ($id) {
        return view('admin.jenis-pekerjaan.edit', ['id' => $id]);
    })->name('jenis-pekerjaan.edit');

    Route::get('/kompetensi', function () {
        return view('admin.kompetensi.index');
    })->name('kompetensi.index');
    Route::get('/kompetensi/create', function () {
        return view('admin.kompetensi.create');
    })->name('kompetensi.create');
    Route::get('/kompetensi/{id}/edit', function ($id) {
        return view('admin.kompetensi.edit', ['id' => $id]);
    })->name('kompetensi.edit');

    Route::get('/kegiatan', function () {
        return view('admin.kegiatan.index');
    })->name('kegiatan.index');
    Route::get('/kegiatan/create', function () {
        return view('admin.kegiatan.create');
    })->name('kegiatan.create');
    Route::get('/kegiatan/{id}', function ($id) {
        return view('admin.kegiatan.show', ['id' => $id]);
    })->name('kegiatan.show');
    Route::get('/kegiatan/{id}/edit', function ($id) {
        return view('admin.kegiatan.edit', ['id' => $id]);
    })->name('kegiatan.edit');
    Route::get('/kegiatan/{activity}/pekerjaan', function ($activity) {
        return view('admin.kegiatan.pekerjaan', ['activity' => $activity]);
    })->name('kegiatan.pekerjaan');

    Route::get('/penjadwalan', function () {
        return view('admin.penjadwalan.index');
    })->name('penjadwalan.index');
    Route::post('/penjadwalan/generate', function () {
        return redirect()->route('admin.penjadwalan.index')->with('success', 'Prototype: jadwal otomatis akan dihubungkan ke backend API di fase berikutnya.');
    })->name('penjadwalan.generate');
    Route::get('/penjadwalan/{id}/edit', function ($id) {
        return view('admin.penjadwalan.edit', ['id' => $id]);
    })->name('penjadwalan.edit');

    Route::get('/penugasan', function () {
        return view('admin.penugasan.index');
    })->name('penugasan.index');
    Route::get('/penugasan/{id}', function ($id) {
        return view('admin.penugasan.show', ['id' => $id]);
    })->name('penugasan.show');

    Route::get('/presensi', function () {
        return view('admin.presensi.index');
    })->name('presensi.index');

    Route::get('/upah', function () {
        return view('admin.upah.index');
    })->name('upah.index');

    Route::get('/permintaan', function () {
        return view('admin.permintaan.index');
    })->name('permintaan.index');
    Route::get('/permintaan/{id}', function ($id) {
        return view('admin.permintaan.show', ['id' => $id]);
    })->name('permintaan.show');

    Route::get('/riwayat-tugas', function () {
        return view('admin.riwayat-tugas');
    })->name('riwayat-tugas');

    Route::get('/laporan', function () {
        return view('admin.laporan.index');
    })->name('laporan');

    Route::get('/profil', function () {
        return view('admin.profil');
    })->name('profil');
});

Route::prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', function () {
        return view('anggota.dashboard');
    })->name('dashboard');

    Route::get('/profil', function () {
        return view('anggota.profil');
    })->name('profil');

    Route::get('/tugas', function () {
        return view('anggota.tugas.index');
    })->name('tugas.index');
    Route::get('/tugas/{id}', function ($id) {
        return view('anggota.tugas.show', ['id' => $id]);
    })->name('tugas.show');
    Route::get('/tugas/{id}/selesai', function ($id) {
        return view('anggota.tugas.complete', ['id' => $id]);
    })->name('tugas.complete');

    Route::get('/riwayat-tugas', function () {
        return view('anggota.riwayat-tugas');
    })->name('riwayat-tugas');

    Route::get('/presensi', function () {
        return view('anggota.presensi.index');
    })->name('presensi');

    Route::get('/upah', function () {
        return view('anggota.upah.index');
    })->name('upah');

    Route::get('/permintaan', function () {
        return view('anggota.permintaan.index');
    })->name('permintaan.index');
    Route::get('/permintaan/create', function () {
        return view('anggota.permintaan.create');
    })->name('permintaan.create');
});

Route::fallback(function () {
    return view('errors.404');
});
