<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'nomor_anggota')) {
                $table->string('nomor_anggota')->unique()->after('id');
            }

            if (! Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('nama_lengkap');
            }

            if (! Schema::hasColumn('users', 'nomor_wa')) {
                $table->string('nomor_wa', 20)->nullable()->after('foto');
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'anggota'])->default('anggota')->after('password');
            }

            if (! Schema::hasColumn('users', 'status_aktif')) {
                $table->boolean('status_aktif')->default(true)->after('role');
            }

            if (Schema::hasColumn('users', 'name') && ! Schema::hasColumn('users', 'nama_lengkap')) {
                $table->renameColumn('name', 'nama_lengkap');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['nomor_anggota', 'foto', 'nomor_wa', 'role', 'status_aktif'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }

            if (Schema::hasColumn('users', 'nama_lengkap') && ! Schema::hasColumn('users', 'name')) {
                $table->renameColumn('nama_lengkap', 'name');
            }
        });
    }
};