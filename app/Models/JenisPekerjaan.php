<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPekerjaan extends Model
{
    use HasFactory;

    protected $table = 'jenis_pekerjaan';

    protected $fillable = [
        'nama_pekerjaan',
        'deskripsi',
        'satuan',
        'tarif_default',
        'status_aktif',
        'created_by',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'tarif_default' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function competencies()
    {
        return $this->hasMany(AnggotaJenisPekerjaan::class, 'jenis_pekerjaan_id');
    }

    public function activityRequirements()
    {
        return $this->hasMany(KegiatanPekerjaan::class, 'jenis_pekerjaan_id');
    }
}
