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
        'nis', 'nama_lengkap', 'nama', 'foto', 'jenis_kelamin', 'kelas_id', 'jurusan_id',
        'tempat_lahir', 'tanggal_lahir', 'tahun_masuk', 'alamat', 'golongan_darah', 'riwayat_alergi',
        'status_kesehatan'
    ];

    protected $casts = [
        'tahun_masuk' => 'integer',
        'tanggal_lahir' => 'date',
    ];

    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function jurusan() { return $this->belongsTo(Jurusan::class); }
    public function wali() { return $this->hasOne(WaliSantri::class); }
    public function sakit() { return $this->hasMany(SantriSakit::class); }
}
