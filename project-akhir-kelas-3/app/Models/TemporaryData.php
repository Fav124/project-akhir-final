<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryData extends Model
{
    use HasFactory;

    protected $table = 'temporary_data';
    public $timestamps = true;

    protected $fillable = [
        'session_id',
        'form_type',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Simpan atau update data sementara berdasarkan session + form
     */
    public static function storeFormData(string $sessionId, string $formType, array $data)
    {
        return static::updateOrCreate(
            [
                'session_id' => $sessionId,
                'form_type' => $formType,
            ],
            [
                'data' => $data,
            ]
        );
    }

    /**
     * Ambil data sementara berdasarkan session + form
     */
    public static function getFormData(string $sessionId, string $formType): ?self
    {
        return static::where('session_id', $sessionId)
            ->where('form_type', $formType)
            ->first();
    }

    /**
     * Hapus data sementara berdasarkan session + form
     */
    public static function clearFormData(string $sessionId, string $formType): bool
    {
        return (bool) static::where('session_id', $sessionId)
            ->where('form_type', $formType)
            ->delete();
    }

    /**
     * Hapus semua data sementara milik session ini (opsional)
     */
    public static function clearAllBySession(string $sessionId): bool
    {
        return (bool) static::where('session_id', $sessionId)->delete();
    }
}
