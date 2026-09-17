<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaJenisPekerjaan extends Model
{
    use HasFactory;

    protected $table = 'anggota_jenis_pekerjaan';

    protected $fillable = [
        'anggota_id',
        'jenis_pekerjaan_id',
        'tingkat_kemampuan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    public function jobType()
    {
        return $this->belongsTo(JenisPekerjaan::class, 'jenis_pekerjaan_id');
    }
}