<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    use HasFactory;
    
    protected $fillable = ['tahun', 'nama_angkatan'];
    
    public function santris()
    {
        return $this->hasMany(Santri::class);
    }
}
