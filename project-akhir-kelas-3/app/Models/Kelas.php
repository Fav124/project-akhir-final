<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasActivityLog;

class Kelas extends Model
{
    use HasFactory, HasActivityLog;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'jurusan_id'
    ];

    /**
     * Relasi many-to-many dengan jurusan
     */
    public function jurusans()
    {
        return $this->belongsToMany(Jurusan::class, 'jurusan_kelas', 'kelas_id', 'jurusan_id')->withTimestamps();
    }

    /**
     * Get all santri in this kelas
     */
    public function santri()
    {
        return $this->hasMany(Santri::class);
    }

    /**
     * Get full name with jurusan
     */
    public function getFullNameAttribute(): string
    {
        $name = $this->nama_kelas;
        if ($this->jurusans->count() > 0) {
            $name .= ' (' . $this->jurusans->pluck('nama')->implode(', ') . ')';
        }
        return $name;
    }

    /**
     * Deskripsi untuk activity log
     */
    public function getActivityDescription(): string
    {
        return "Kelas: {$this->nama_kelas}";
    }
}
