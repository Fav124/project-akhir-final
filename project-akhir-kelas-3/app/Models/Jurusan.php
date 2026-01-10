<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusans';

    protected $fillable = [
        'nama',
        'deskripsi'
    ];

    /**
     * Relasi many-to-many dengan kelas
     */
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'jurusan_kelas', 'jurusan_id', 'kelas_id')->withTimestamps();
    }

    /**
     * Get all santri in this jurusan
     */
    public function santris()
    {
        return $this->hasMany(Santri::class);
    }
}
