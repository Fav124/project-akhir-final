<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SantriSakit;
use App\Models\Obat;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    public function getSummaryData()
    {
        // 1. Get Sick Students (Currently Sick)
        $sickStudents = SantriSakit::with(['santri', 'santri.kelas'])
            ->where('status', 'Sakit')
            ->latest()
            ->get();

        // 2. Get Low Stock Medicines
        $lowStockObats = Obat::where('stok', '<=', \DB::raw('stok_minimum'))
            ->where('stok', '>', 0)
            ->get();

        // 3. Get Expired or Near Expiry Medicines (within 30 days)
        $expiryAlerts = Obat::where('tanggal_kadaluarsa', '<=', now()->addDays(30))
            ->where('stok', '>', 0)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'sick_students' => $sickStudents->map(function($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->santri->nama_lengkap,
                        'kelas' => $s->santri->kelas->nama_kelas ?? '-',
                        'diagnosis' => $s->diagnosis_utama,
                        'days' => $s->created_at->diffInDays(now()),
                        'type' => 'sick'
                    ];
                }),
                'low_stock' => $lowStockObats->map(function($o) {
                    return [
                        'id' => $o->id,
                        'name' => $o->nama_obat,
                        'stok' => $o->stok,
                        'min' => $o->stok_minimum,
                        'type' => 'stock'
                    ];
                }),
                'expiry' => $expiryAlerts->map(function($o) {
                    return [
                        'id' => $o->id,
                        'name' => $o->nama_obat,
                        'expiry_date' => $o->tanggal_kadaluarsa->format('d M Y'),
                        'is_expired' => $o->tanggal_kadaluarsa->isPast(),
                        'type' => 'expiry'
                    ];
                })
            ]
        ]);
    }
}
