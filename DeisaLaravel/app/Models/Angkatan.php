<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    use HasFactory;
    
    protected $fillable = ['tahun', 'nama_angkatan'];

    public static function syncNames()
    {
        $angkatans = self::orderBy('tahun', 'asc')->get();
        foreach ($angkatans as $index => $angkatan) {
            $newName = "Angkatan " . ($index + 1);
            if ($angkatan->nama_angkatan !== $newName) {
                $angkatan->update(['nama_angkatan' => $newName]);
            }
        }
    }
    
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function santris()
    {
        return $this->hasMany(Santri::class);
    }
}
