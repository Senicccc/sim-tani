<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pekerjaan');
            $table->text('deskripsi')->nullable();
            $table->string('satuan', 50);
            $table->decimal('tarif_default', 15, 2)->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('anggota_jenis_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('jenis_pekerjaan_id')->constrained('jenis_pekerjaan')->cascadeOnDelete();
            $table->enum('tingkat_kemampuan', ['pemula', 'menengah', 'mahir']);
            $table->timestamps();
            $table->unique(['anggota_id', 'jenis_pekerjaan_id']);
        });

        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->text('deskripsi')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['draft', 'scheduled', 'ongoing', 'completed', 'cancelled']);
            $table->enum('metode_penjadwalan', ['otomatis', 'manual']);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('kegiatan_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->cascadeOnDelete();
            $table->foreignId('jenis_pekerjaan_id')->constrained('jenis_pekerjaan')->cascadeOnDelete();
            $table->unsignedInteger('jumlah_orang_dibutuhkan');
            $table->decimal('jumlah_satuan', 12, 2)->nullable();
            $table->decimal('tarif_per_satuan', 15, 2)->nullable();
            $table->enum('tingkat_kemampuan_minimal', ['pemula', 'menengah', 'mahir'])->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['kegiatan_id', 'jenis_pekerjaan_id']);
        });

        Schema::create('penugasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_pekerjaan_id')->constrained('kegiatan_pekerjaan')->cascadeOnDelete();
            $table->foreignId('anggota_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['assigned', 'in_progress', 'waiting_verification', 'completed', 'cancelled']);
            $table->enum('sumber_penugasan', ['otomatis', 'manual', 'hasil_perubahan']);
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('catatan_penyelesaian')->nullable();
            $table->string('bukti_selesai')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('catatan_verifikasi')->nullable();
            $table->timestamps();
        });

        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penugasan_id')->unique()->constrained('penugasan')->cascadeOnDelete();
            $table->timestamp('waktu_check_in')->nullable();
            $table->timestamp('waktu_check_out')->nullable();
            $table->enum('status', ['hadir', 'tidak_hadir', 'izin']);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('upah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penugasan_id')->unique()->constrained('penugasan')->cascadeOnDelete();
            $table->enum('mode_perhitungan', ['otomatis', 'manual']);
            $table->decimal('tarif_per_satuan', 15, 2)->nullable();
            $table->decimal('jumlah_satuan', 12, 2)->nullable();
            $table->decimal('jumlah_upah', 15, 2);
            $table->enum('status_pembayaran', ['belum_dibayar', 'sudah_dibayar'])->default('belum_dibayar');
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->foreignId('dibayar_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('permintaan_perubahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penugasan_id')->constrained('penugasan')->cascadeOnDelete();
            $table->foreignId('diajukan_oleh')->constrained('users')->cascadeOnDelete();
            $table->enum('jenis_permintaan', ['tukar', 'sanggah']);
            $table->foreignId('target_penugasan_id')->nullable()->constrained('penugasan')->nullOnDelete();
            $table->foreignId('target_anggota_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('alasan');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('diproses_at')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_perubahan');
        Schema::dropIfExists('upah');
        Schema::dropIfExists('presensi');
        Schema::dropIfExists('penugasan');
        Schema::dropIfExists('kegiatan_pekerjaan');
        Schema::dropIfExists('kegiatan');
        Schema::dropIfExists('anggota_jenis_pekerjaan');
        Schema::dropIfExists('jenis_pekerjaan');
    }
};
