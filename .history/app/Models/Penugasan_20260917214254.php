<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;

    protected $table = 'penugasan';

    protected $fillable = [
        'kegiatan_pekerjaan_id',
        'anggota_id',
        'status',
        'sumber_penugasan',
        'assigned_at',
        'started_at',
        'completed_at',
        'catatan_penyelesaian',
        'bukti_selesai',
        'verified_by',
        'verified_at',
        'catatan_verifikasi',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function activityJobRequirement()
    {
        return $this->belongsTo(KegiatanPekerjaan::class, 'kegiatan_pekerjaan_id');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function attendance()
    {
        return $this->hasOne(Presensi::class, 'penugasan_id');
    }

    public function wage()
    {
        return $this->hasOne(Upah::class, 'penugasan_id');
    }

    public function changeRequests()
    {
        return $this->hasMany(PermintaanPerubahan::class, 'penugasan_id');
    }
}
