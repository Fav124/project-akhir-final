<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_obat', 'nama_obat', 'kategori', 'deskripsi', 'stok_awal', 'stok',
        'stok_minimum', 'satuan', 'harga_satuan', 'tanggal_kadaluarsa', 'lokasi_penyimpanan', 'foto'
    ];

    protected $casts = [
        'tanggal_kadaluarsa' => 'date',
        'harga_satuan' => 'double',
    ];
}
