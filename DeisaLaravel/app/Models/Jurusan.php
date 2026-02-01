<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_jurusan', 'kode_jurusan', 'deskripsi'];

    protected static function booted()
    {
        static::creating(function ($jurusan) {
            if (empty($jurusan->kode_jurusan)) {
                $lastJurusan = self::where('kode_jurusan', 'like', 'J-%')
                    ->orderBy('id', 'desc')
                    ->first();

                if ($lastJurusan && preg_match('/J-(\d+)/', $lastJurusan->kode_jurusan, $matches)) {
                    $lastSequence = intval($matches[1]);
                    $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
                } else {
                    $newSequence = '001';
                }

                $jurusan->kode_jurusan = 'J-' . $newSequence;
            }
        });
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_jurusan');
    }
}
