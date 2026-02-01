<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\WaliSantri;
use App\Models\SantriSakit;

class Santri extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nama_lengkap',
        'foto',
        'jenis_kelamin',
        'kelas_id',
        'jurusan_id',
        'tempat_lahir',
        'tanggal_lahir',
        'angkatan_id',
        'tahun_masuk',
        'alamat',
        'golongan_darah',
        'riwayat_alergi',
        'status_kesehatan',
        'status_akademik',
        'is_repeating'
    ];

    protected static function booted()
    {
        static::creating(function ($santri) {
            if (empty($santri->nis)) {
                $datePrefix = now()->format('ymd');
                $lastSantri = self::where('nis', 'like', $datePrefix . '%')
                    ->orderBy('nis', 'desc')
                    ->first();

                if ($lastSantri) {
                    $lastSequence = intval(substr($lastSantri->nis, -3));
                    $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
                } else {
                    $newSequence = '001';
                }

                $santri->nis = $datePrefix . $newSequence;
            }
        });

        // The automatic Angkatan calculation is removed as per user request for manual selection.
    }

    protected $casts = [
        'tahun_masuk' => 'integer',
        'tanggal_lahir' => 'date',
        'is_repeating' => 'boolean',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class);
    }
    public function wali()
    {
        return $this->hasOne(WaliSantri::class);
    }
    public function sakit()
    {
        return $this->hasMany(SantriSakit::class);
    }
}
