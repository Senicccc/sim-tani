<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upah extends Model
{
    use HasFactory;

    protected $table = 'upah';

    protected $fillable = [
        'penugasan_id',
        'mode_perhitungan',
        'tarif_per_satuan',
        'jumlah_satuan',
        'jumlah_upah',
        'status_pembayaran',
        'tanggal_pembayaran',
        'dibayar_oleh',
        'catatan',
    ];

    protected $casts = [
        'tarif_per_satuan' => 'decimal:2',
        'jumlah_satuan' => 'decimal:2',
        'jumlah_upah' => 'decimal:2',
        'tanggal_pembayaran' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(Penugasan::class, 'penugasan_id');
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'dibayar_oleh');
    }
}
