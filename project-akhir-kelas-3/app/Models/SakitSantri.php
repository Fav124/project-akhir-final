<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasActivityLog;

class SakitSantri extends Model
{
    use HasFactory, HasActivityLog;

    protected $table = 'sakit_santris';

    protected $fillable = [
        'santri_id',
        'user_id',
        'foto',
        'kelas_text',
        'tanggal_mulai_sakit',
        'tanggal_selesai_sakit',
        'diagnosis',
        'gejala',
        'tindakan',
        'resep_obat',
        'suhu_tubuh',
        'status',
        'tingkat_kondisi',
        'catatan'
    ];

    protected $casts = [
        'tanggal_mulai_sakit' => 'date',
        'tanggal_selesai_sakit' => 'date',
        'suhu_tubuh' => 'decimal:1'
    ];

    /**
     * Tingkat kondisi options with descriptions
     */
    public const TINGKAT_KONDISI = [
        'ringan' => 'Cukup istirahat / obat ringan',
        'sedang' => 'Aktivitas terganggu, perlu pantauan',
        'berat' => 'Butuh tindakan cepat / rujukan'
    ];

    /**
     * Get the santri that is sick
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    /**
     * Get the user who recorded this (petugas)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias for user - petugas
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi many-to-many dengan diagnosis (tags)
     */
    public function diagnoses()
    {
        return $this->belongsToMany(Diagnosis::class, 'diagnosis_sakit_santri', 'sakit_santri_id', 'diagnosis_id')
            ->withTimestamps();
    }

    /**
     * Relasi many-to-many dengan obat
     */
    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'sakit_santri_obat')
            ->withPivot('jumlah', 'dosis', 'tujuan', 'keterangan')
            ->withTimestamps();
    }

    /**
     * Check if santri has recovered
     */
    public function isRecovered(): bool
    {
        return $this->status === 'sembuh';
    }

    /**
     * Get duration of sickness in days
     */
    public function getDurationAttribute(): ?int
    {
        if (!$this->tanggal_mulai_sakit) {
            return null;
        }
        
        $endDate = $this->tanggal_selesai_sakit ?? now();
        return $this->tanggal_mulai_sakit->diffInDays($endDate);
    }

    /**
     * Get tingkat kondisi badge color
     */
    public function getTingkatBadgeAttribute(): string
    {
        return match($this->tingkat_kondisi) {
            'ringan' => 'success',
            'sedang' => 'warning',
            'berat' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'sakit' => 'danger',
            'sembuh' => 'success',
            'kontrol' => 'info',
            default => 'secondary'
        };
    }

    /**
     * Scope to get active sick records (not recovered)
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'sembuh');
    }

    /**
     * Scope to get records from today
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_mulai_sakit', today());
    }

    /**
     * Deskripsi untuk activity log
     */
    public function getActivityDescription(): string
    {
        $santriName = $this->santri ? $this->santri->nama_lengkap : 'N/A';
        return "Catatan Sakit: {$santriName} (Status: {$this->status})";
    }
}
