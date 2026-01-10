<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pemeriksaans';
    protected $fillable = [
        'santri_id',
        'tanggal_pemeriksaan',
        'keluhan',
        'suhu_tubuh',
        'tindakan',
        'status_kondisi'
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'suhu_tubuh' => 'decimal:1'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
