<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SantriSakit;
use App\Models\Obat;
use App\Models\PenggunaanObat;
use App\Models\Santri;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Stats Cards
        $totalPasienHariIni = SantriSakit::whereDate('created_at', $today)->count();
        $menungguPemeriksaan = SantriSakit::where('status', 'menunggu')->count();
        $obatKeluarHariIni = PenggunaanObat::whereDate('created_at', $today)->sum('jumlah');
        $totalSakit = SantriSakit::where('status', 'sakit')->orWhere('status', 'Pulang')->count();

        // 2. Medicine Alerts
        $criticalObatCount = Obat::whereRaw('stok <= stok_minimum')->count();
        $expiredObatCount = Obat::where('tanggal_kadaluarsa', '<', $today)->count();

        // 2. Trend Chart (Last 7 Days)
        $dates = collect();
        $trendData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dates->push($date->format('D'));
            $trendData->push(SantriSakit::whereDate('created_at', $date)->count());
        }

        // 3. Top Diagnosis
        $topDiagnosis = SantriSakit::select('diagnosis_utama')
            ->selectRaw('count(*) as count')
            ->whereNotNull('diagnosis_utama')
            ->groupBy('diagnosis_utama')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $diagLabels = $topDiagnosis->pluck('diagnosis_utama');
        $diagData = $topDiagnosis->pluck('count');

        // 4. Recent Patients
        $recentPatients = SantriSakit::with('santri')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPasienHariIni',
            'menungguPemeriksaan',
            'obatKeluarHariIni',
            'totalSakit',
            'criticalObatCount',
            'expiredObatCount',
            'dates',
            'trendData',
            'diagLabels',
            'diagData',
            'recentPatients'
        ));
    }
}
