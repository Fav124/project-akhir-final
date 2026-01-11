<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;
    
    protected $fillable = ['nama_diagnosis', 'kategori', 'deskripsi'];
}
