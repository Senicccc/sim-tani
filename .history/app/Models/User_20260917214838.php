<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nomor_anggota',
        'nama_lengkap',
        'foto',
        'nomor_wa',
        'email',
        'password',
        'role',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'status_aktif' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function createdActivities()
    {
        return $this->hasMany(Kegiatan::class, 'created_by');
    }

    public function createdJobTypes()
    {
        return $this->hasMany(JenisPekerjaan::class, 'created_by');
    }

    public function competencies()
    {
        return $this->hasMany(AnggotaJenisPekerjaan::class, 'anggota_id');
    }

    public function assignments()
    {
        return $this->hasMany(Penugasan::class, 'anggota_id');
    }

    public function verifiedAssignments()
    {
        return $this->hasMany(Penugasan::class, 'verified_by');
    }

    public function submittedChangeRequests()
    {
        return $this->hasMany(PermintaanPerubahan::class, 'diajukan_oleh');
    }

    public function processedRequests()
    {
        return $this->hasMany(PermintaanPerubahan::class, 'diproses_oleh');
    }
}
