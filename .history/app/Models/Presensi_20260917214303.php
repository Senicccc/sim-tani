<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'penugasan_id',
        'waktu_check_in',
        'waktu_check_out',
        'status',
        'catatan',
    ];

    protected $casts = [
        'waktu_check_in' => 'datetime',
        'waktu_check_out' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(Penugasan::class, 'penugasan_id');
    }
}
