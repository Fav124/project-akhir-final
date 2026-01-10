<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliSantri extends Model
{
    use HasFactory;

    protected $table = 'wali_santris';
    protected $fillable = [
        'santri_id',
        'nama_wali',
        'foto',
        'tempat_lahir',
        'tanggal_lahir',
        'hubungan',
        'no_hp',
        'alamat'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];
}
