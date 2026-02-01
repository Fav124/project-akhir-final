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
            $batchNum = $index + 1;
            $newName = "Angkatan {$batchNum} ({$angkatan->tahun})";

            if ($angkatan->nama_angkatan !== $newName) {
                $angkatan->update(['nama_angkatan' => $newName]);
            }
        }
    }

    public function santris()
    {
        return $this->hasMany(Santri::class);
    }
}
