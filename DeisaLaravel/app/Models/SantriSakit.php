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

    protected $casts = [
        'tgl_masuk' => 'date',
        'tgl_sembuh' => 'date',
        'tanggal_mulai_sakit' => 'date',
    ];

    public function santri() { return $this->belongsTo(Santri::class); }
    public function diagnoses() { return $this->belongsToMany(Diagnosis::class, 'santri_sakit_diagnoses'); }
    public function obats() { return $this->belongsToMany(Obat::class, 'penggunaan_obats')->withPivot('jumlah', 'satuan'); }
}
