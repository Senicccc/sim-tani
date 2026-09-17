<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'nama_lengkap');

            $table->string('nomor_anggota')->unique()->after('id');
            $table->string('foto')->nullable()->after('nama_lengkap');
            $table->string('nomor_wa', 20)->nullable()->after('foto');
            $table->text('alamat')->nullable()->after('nomor_wa');

            $table->enum('role', ['admin', 'anggota'])
                ->default('anggota')
                ->after('password');

            $table->boolean('status_aktif')
                ->default(true)
                ->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nomor_anggota']);
            $table->dropColumn([
                'nomor_anggota',
                'foto',
                'nomor_wa',
                'alamat',
                'role',
                'status_aktif',
            ]);

            $table->renameColumn('nama_lengkap', 'name');
        });
    }
};