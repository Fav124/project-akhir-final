<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaanObat extends Model
{
    use HasFactory;

    protected $fillable = ['santri_sakit_id', 'obat_id', 'jumlah', 'satuan'];

    public function santri_sakit() { return $this->belongsTo(SantriSakit::class); }
    public function obat() { return $this->belongsTo(Obat::class); }
}
