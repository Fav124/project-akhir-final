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
        'nis', 'nama_lengkap', 'foto', 'jenis_kelamin', 'kelas_id', 'jurusan_id',
        'tempat_lahir', 'tanggal_lahir', 'angkatan_id', 'tahun_masuk', 'alamat', 'golongan_darah', 'riwayat_alergi',
        'status_kesehatan', 'status_akademik'
    ];

    protected static function booted()
    {
        static::saving(function ($santri) {
            // Auto-sync Angkatan and Year from Kelas ONLY if not already set (Registration)
            // This preserves their cohort even if they move classes later
            if ($santri->kelas_id && empty($santri->angkatan_id)) {
                $kelas = \App\Models\Kelas::with('angkatan')->find($santri->kelas_id);
                if ($kelas && $kelas->angkatan) {
                    $santri->angkatan_id = $kelas->angkatan_id;
                    if (empty($santri->tahun_masuk)) {
                        $santri->tahun_masuk = $kelas->angkatan->tahun;
                    }
                }
            }

            // Fallback for manual tahun_masuk or if still empty
            if (empty($santri->angkatan_id) && $santri->tahun_masuk) {
                $angkatan = \App\Models\Angkatan::firstOrCreate(
                    ['tahun' => $santri->tahun_masuk],
                    ['nama_angkatan' => 'Temporary Name']
                );
                $santri->angkatan_id = $angkatan->id;
                \App\Models\Angkatan::syncNames();
            }
        });
    }

    protected $casts = [
        'tahun_masuk' => 'integer',
        'tanggal_lahir' => 'date',
    ];

    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function jurusan() { return $this->belongsTo(Jurusan::class); }
    public function angkatan() { return $this->belongsTo(Angkatan::class); }
    public function wali() { return $this->hasOne(WaliSantri::class); }
    public function sakit() { return $this->hasMany(SantriSakit::class); }
}
