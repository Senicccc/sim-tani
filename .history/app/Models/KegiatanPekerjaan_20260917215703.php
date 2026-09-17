<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanPekerjaan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_pekerjaan';

    protected $fillable = [
        'kegiatan_id',
        'jenis_pekerjaan_id',
        'jumlah_orang_dibutuhkan',
        'jumlah_satuan',
        'tarif_per_satuan',
        'tingkat_kemampuan_minimal',
        'catatan',
    ];

    protected $casts = [
        'jumlah_satuan' => 'decimal:2',
        'tarif_per_satuan' => 'decimal:2',
    ];

    public function activity()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function jobType()
    {
        return $this->belongsTo(JenisPekerjaan::class, 'jenis_pekerjaan_id');
    }

    public function assignments()
    {
        return $this->hasMany(Penugasan::class, 'kegiatan_pekerjaan_id');
    }
}
