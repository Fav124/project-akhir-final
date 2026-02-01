<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'kategori',
        'deskripsi',
        'stok_awal',
        'stok',
        'stok_minimum',
        'satuan',
        'harga_satuan',
        'tanggal_kadaluarsa',
        'lokasi_penyimpanan',
        'foto'
    ];

    protected static function booted()
    {
        static::creating(function ($obat) {
            if (empty($obat->kode_obat)) {
                $lastObat = self::where('kode_obat', 'like', 'OBT-%')
                    ->orderBy('id', 'desc')
                    ->first();

                if ($lastObat && preg_match('/OBT-(\d+)/', $lastObat->kode_obat, $matches)) {
                    $lastSequence = intval($matches[1]);
                    $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
                } else {
                    $newSequence = '001';
                }

                $obat->kode_obat = 'OBT-' . $newSequence;
            }
        });
    }

    protected $casts = [
        'tanggal_kadaluarsa' => 'date',
        'harga_satuan' => 'double',
    ];
}
