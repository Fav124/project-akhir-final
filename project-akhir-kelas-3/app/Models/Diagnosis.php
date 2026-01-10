<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function sakitSantris()
    {
        return $this->belongsToMany(SakitSantri::class, 'diagnosis_sakit_santri', 'diagnosis_id', 'sakit_santri_id');
    }
}
