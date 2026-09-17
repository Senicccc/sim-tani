<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanPerubahan extends Model
{
    use HasFactory;

    protected $table = 'permintaan_perubahan';

    protected $fillable = [
        'penugasan_id',
        'diajukan_oleh',
        'jenis_permintaan',
        'target_penugasan_id',
        'target_anggota_id',
        'alasan',
        'status',
        'diproses_oleh',
        'diproses_at',
        'catatan_admin',
    ];

    protected $casts = [
        'diproses_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(Penugasan::class, 'penugasan_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'diajukan_oleh');
    }

    public function targetAssignment()
    {
        return $this->belongsTo(Penugasan::class, 'target_penugasan_id');
    }

    public function targetMember()
    {
        return $this->belongsTo(User::class, 'target_anggota_id');
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}
