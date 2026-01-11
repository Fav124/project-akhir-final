<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\SantriSakit;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function getSummary()
    {
        $totalSantri = Santri::count();
        $totalSakit = SantriSakit::where('status', 'Sakit')->count();
        $totalSembuh = SantriSakit::where('status', 'Sembuh')->count();
        $lowStockObat = Obat::whereColumn('stok', '<=', 'stok_minimum')->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_santri' => $totalSantri,
                'total_sakit' => $totalSakit,
                'total_sembuh' => $totalSembuh,
                'low_stock_obat' => $lowStockObat,
            ]
        ]);
    }

    public function getStatistics()
    {
        // Top 5 Diagnoses
        $topDiagnoses = DB::table('santri_sakit_diagnoses')
            ->join('diagnoses', 'santri_sakit_diagnoses.diagnosis_id', '=', 'diagnoses.id')
            ->select('diagnoses.nama_diagnosis', DB::raw('count(*) as count'))
            ->groupBy('diagnoses.id', 'diagnoses.nama_diagnosis')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        // Monthly Sickness Trend (Last 6 Months) - MySQL compatible
        $monthlyTrend = SantriSakit::select(
                DB::raw("DATE_FORMAT(tgl_masuk, '%Y-%m') as month"),
                DB::raw('count(*) as count')
            )
            ->where('tgl_masuk', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'top_diagnoses' => $topDiagnoses,
                'monthly_trend' => $monthlyTrend
            ]
        ]);
    }
}
