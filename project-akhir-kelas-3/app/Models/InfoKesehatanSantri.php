<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoKesehatanSantri extends Model
{
    use HasFactory;

    protected $table = 'info_kesehatan_santris';
    protected $fillable = [
        'santri_id',
        'tinggi_badan',
        'berat_badan',
        'golongan_darah',
        'catatan'
    ];

    public function santri()
    {
        return $this->hasMany(Santri::class);
    }
}
