<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Santri;

class WaliSantri extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id', 'nama_wali', 'hubungan', 'no_hp', 'no_hp_alt', 'no_telp_wali', 'pekerjaan', 'alamat'
    ];

    public function santri() { return $this->belongsTo(Santri::class); }
}
