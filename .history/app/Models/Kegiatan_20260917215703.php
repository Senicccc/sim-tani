<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'metode_penjadwalan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function jobRequirements()
    {
        return $this->hasMany(KegiatanPekerjaan::class, 'kegiatan_id');
    }

    public function assignments()
    {
        return $this->hasManyThrough(Penugasan::class, KegiatanPekerjaan::class, 'kegiatan_id', 'kegiatan_pekerjaan_id');
    }
}
