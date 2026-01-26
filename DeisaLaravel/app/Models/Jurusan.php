<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    
    protected $fillable = ['nama_jurusan', 'kode_jurusan', 'deskripsi'];
    
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_jurusan');
    }
}
