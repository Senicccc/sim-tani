<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'nomor_anggota' => 'ADM001',
            'nama_lengkap' => 'Admin SimTani',
            'email' => 'admin@simtani.test',
            'password' => Hash::make('password123'),
            'nomor_wa' => '081234567890',
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        User::query()->create([
            'nomor_anggota' => 'AGT001',
            'nama_lengkap' => 'Anggota SimTani',
            'email' => 'anggota@simtani.test',
            'password' => Hash::make('password123'),
            'nomor_wa' => '081234567891',
            'role' => 'anggota',
            'status_aktif' => true,
        ]);
    }
}
