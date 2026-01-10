<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Traits\HasActivityLog;

class Obat extends Model
{
    use HasFactory, HasActivityLog;

    protected $table = 'obats';

    protected $fillable = [
        'nama_obat',
        'foto',
        'deskripsi',
        'stok',
        'satuan',
        'stok_minimum',
        'harga_satuan',
        'tanggal_kadaluarsa',
        'total_terpakai'
    ];

    protected $casts = [
        'stok' => 'integer',
        'stok_minimum' => 'integer',
        'harga_satuan' => 'decimal:2',
        'tanggal_kadaluarsa' => 'date',
        'total_terpakai' => 'integer'
    ];

    /**
     * Relasi many-to-many dengan sakit_santri
     */
    public function sakitSantris()
    {
        return $this->belongsToMany(SakitSantri::class, 'sakit_santri_obat')
            ->withPivot('jumlah', 'dosis', 'tujuan', 'keterangan')
            ->withTimestamps();
    }

    /**
     * Get purchase history for this obat
     */
    public function histories()
    {
        return $this->hasMany(ObatHistory::class);
    }

    /**
     * Check if stock is low
     */
    public function isStockLow(): bool
    {
        return $this->stok <= $this->stok_minimum;
    }

    /**
     * Check if obat is expiring soon (within 30 days)
     */
    public function isExpiringSoon(): bool
    {
        if (!$this->tanggal_kadaluarsa) {
            return false;
        }
        $thirtyDaysFromNow = Carbon::now()->addDays(30);
        return $this->tanggal_kadaluarsa->lte($thirtyDaysFromNow) && $this->tanggal_kadaluarsa->gte(Carbon::now());
    }

    /**
     * Check if obat is expired
     */
    public function isExpired(): bool
    {
        if (!$this->tanggal_kadaluarsa) {
            return false;
        }
        return $this->tanggal_kadaluarsa->lt(Carbon::now());
    }

    /**
     * Scope to get expiring medicines (within days)
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->whereNotNull('tanggal_kadaluarsa')
            ->whereBetween('tanggal_kadaluarsa', [
                Carbon::now()->toDateString(),
                Carbon::now()->addDays($days)->toDateString()
            ]);
    }

    /**
     * Scope to get expired medicines
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('tanggal_kadaluarsa')
            ->where('tanggal_kadaluarsa', '<', Carbon::now()->toDateString());
    }

    /**
     * Scope to get low stock medicines
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('stok <= stok_minimum');
    }

    /**
     * Reduce stock
     */
    public function reduceStock($amount): bool
    {
        if ($this->stok >= $amount) {
            $this->decrement('stok', $amount);
            $this->increment('total_terpakai', $amount);
            return true;
        }
        return false;
    }

    /**
     * Restore stock and decrease usage count
     */
    public function restoreStock($amount): void
    {
        $this->increment('stok', $amount);
        $this->decrement('total_terpakai', $amount);
    }

    /**
     * Add stock
     */
    public function addStock($amount): void
    {
        $this->increment('stok', $amount);
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
     * Deskripsi untuk activity log
     */
    public function getActivityDescription(): string
    {
        return "Obat: {$this->nama_obat}";
    }
}
