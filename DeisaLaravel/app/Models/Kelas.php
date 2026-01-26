<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    protected $fillable = ['nama_kelas', 'jenjang', 'tingkat', 'angkatan_id', 'tahun_ajaran'];

    protected static function booted()
    {
        static::saving(function ($kelas) {
            if ($kelas->tingkat && $kelas->tahun_ajaran) {
                // Extract start year from "2024/2025" -> 2024
                preg_match('/^\d{4}/', $kelas->tahun_ajaran, $matches);
                if (!empty($matches)) {
                    $startYear = intval($matches[0]);
                    
                    // Calculation for Angkatan:
                    // Entry Year = Start Year of current academic year - (Tingkat - 1)
                    // If Tingkat 1 in 2024/2025 -> Entry year is 2024
                    // If Tingkat 3 in 2024/2025 -> Entry year is 2022
                    $cohortYear = $startYear - ($kelas->tingkat - 1);

                    $angkatan = \App\Models\Angkatan::firstOrCreate(
                        ['tahun' => $cohortYear],
                        ['nama_angkatan' => 'Temporary Name']
                    );
                    
                    $kelas->angkatan_id = $angkatan->id;
                    \App\Models\Angkatan::syncNames();

                    // Auto-generate name if empty
                    if (empty($kelas->nama_kelas)) {
                        $kelas->nama_kelas = ($kelas->jenjang ?? 'Kelas') . ' ' . $kelas->tingkat;
                    }
                }
            }
        });
    }
    
    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class);
    }

    public function jurusans()
    {
        return $this->belongsToMany(Jurusan::class, 'kelas_jurusan');
    }
    
    public function santri()
    {
        return $this->hasMany(Santri::class);
    }
}
