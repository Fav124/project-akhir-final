<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasActivityLog;

class Santri extends Model
{
    use HasFactory, HasActivityLog;
    
    protected $table = 'santris';

    protected $fillable = [
        'foto',
        'nis',
        'nama_lengkap',
        'jenis_kelamin',
        'kelas_id',
        'jurusan_id',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_daerah',
        'status',
        'status_kesehatan',
        'nama_ayah',
        'nama_ibu',
        'nama_wali',
        'pekerjaan_wali',
        'phone_wali',
        'alamat_wali'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    /**
     * Get the kelas that owns this santri
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Get the jurusan that owns this santri
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Get all sakit records for this santri
     */
    public function sakitSantris()
    {
        return $this->hasMany(SakitSantri::class);
    }

    /**
     * Get info kesehatan
     */
    public function info()
    {
        return $this->belongsTo(InfoKesehatanSantri::class);
    }

    /**
     * Get riwayat pemeriksaan
     */
    public function riwayat()
    {
        return $this->belongsTo(RiwayatPemeriksaan::class);
    }

    /**
     * Get wali santri
     */
    public function wali()
    {
        return $this->hasOne(WaliSantri::class);
    }

    /**
     * Get foto URL
     */
    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }

    /**
     * Check if santri is currently sick
     */
    public function isSick(): bool
    {
        return $this->status_kesehatan === 'sakit';
    }

    /**
     * Get full kelas name with jurusan
     */
    public function getKelasFullAttribute(): string
    {
        if ($this->kelas) {
            return $this->kelas->full_name;
        }
        return '-';
    }

    /**
     * Deskripsi untuk activity log
     */
    public function getActivityDescription(): string
    {
        return "Santri: {$this->nama_lengkap} ({$this->nis})";
    }
}
