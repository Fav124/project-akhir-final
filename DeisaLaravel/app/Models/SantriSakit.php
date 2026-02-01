<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Santri;
use App\Models\Diagnosis;
use App\Models\Obat;

class SantriSakit extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'kode_riwayat', // New
        'tgl_masuk',
        'tgl_sembuh',
        'tanggal_mulai_sakit', // New
        'keluhan',             // New
        'diagnosis',           // New (string fallback)
        'tingkat_kondisi',     // New
        'diagnosis_utama',
        'gejala',
        'tindakan',
        'catatan',
        'status',
        'jenis_perawatan',
        'tujuan_rujukan'
    ];

    protected static function booted()
    {
        static::creating(function ($sakit) {
            if (empty($sakit->kode_riwayat)) {
                $datePrefix = now()->format('ymd');
                $prefix = 'RS-' . $datePrefix . '-';

                $lastSakit = self::where('kode_riwayat', 'like', $prefix . '%')
                    ->orderBy('id', 'desc')
                    ->first();

                if ($lastSakit && preg_match('/-(\d+)$/', $lastSakit->kode_riwayat, $matches)) {
                    $lastSequence = intval($matches[1]);
                    $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
                } else {
                    $newSequence = '001';
                }

                $sakit->kode_riwayat = $prefix . $newSequence;
            }
        });
    }

    protected $casts = [
        'tgl_masuk' => 'date',
        'tgl_sembuh' => 'date',
        'tanggal_mulai_sakit' => 'date',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
    public function diagnoses()
    {
        return $this->belongsToMany(Diagnosis::class, 'santri_sakit_diagnoses');
    }
    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'penggunaan_obats')->withPivot('jumlah', 'satuan');
    }
}
