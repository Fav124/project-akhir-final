<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatHistory extends Model
{
    use HasFactory;

    protected $table = 'obat_histories';

    protected $fillable = [
        'obat_id',
        'tanggal_pembelian',
        'jumlah',
        'supplier',
        'harga_total',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'jumlah' => 'integer',
        'harga_total' => 'decimal:2'
    ];

    /**
     * Get the obat that owns this history
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
