<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['kode_kelas', 'nama_kelas', 'jenjang', 'tingkat', 'tahun_ajaran'];

    protected static function booted()
    {
        static::creating(function ($kelas) {
            if (empty($kelas->kode_kelas)) {
                $lastKelas = self::where('kode_kelas', 'like', 'K-%')
                    ->orderBy('id', 'desc')
                    ->first();

                if ($lastKelas && preg_match('/K-(\d+)/', $lastKelas->kode_kelas, $matches)) {
                    $lastSequence = intval($matches[1]);
                    $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
                } else {
                    $newSequence = '0001';
                }

                $kelas->kode_kelas = 'K-' . $newSequence;
            }
        });

        static::saving(function ($kelas) {
            if (empty($kelas->nama_kelas) && $kelas->tingkat) {
                $kelas->nama_kelas = ($kelas->jenjang ?? 'Kelas') . ' ' . $kelas->tingkat;
            }
        });
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
