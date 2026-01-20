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
        $totalSakit = SantriSakit::count();
        $uniqueSantriSakit = SantriSakit::distinct('santri_id')->count('santri_id');
        $currentlySick = SantriSakit::where('status', '!=', 'Sembuh')->count();

        $byTingkat = [
            'ringan' => SantriSakit::where('tingkat_kondisi', 'Ringan')->count(),
            'sedang' => SantriSakit::where('tingkat_kondisi', 'Sedang')->count(),
            'berat' => SantriSakit::where('tingkat_kondisi', 'Berat')->count(),
        ];

        // Top 10 Santri yang paling sering sakit
        $topSantri = Santri::select('santris.id', 'santris.nis', 'santris.nama_lengkap')
            ->leftJoin('santri_sakits', 'santris.id', '=', 'santri_sakits.santri_id')
            ->groupBy('santris.id', 'santris.nis', 'santris.nama_lengkap')
            ->selectRaw('COUNT(santri_sakits.id) as sakit_count')
            ->orderBy('sakit_count', 'desc')
            ->having('sakit_count', '>', 0)
            ->limit(10)
            ->get();

        // Top 10 Obat yang paling sering digunakan
        $topObat = DB::table('penggunaan_obats')
            ->join('obats', 'penggunaan_obats.obat_id', '=', 'obats.id')
            ->select('obats.id', 'obats.nama_obat')
            ->selectRaw('COUNT(penggunaan_obats.id) as times_used')
            ->selectRaw('SUM(penggunaan_obats.jumlah) as total_quantity')
            ->groupBy('obats.id', 'obats.nama_obat')
            ->orderBy('times_used', 'desc')
            ->limit(10)
            ->get();

        // Monthly trend (last 6 months)
        $monthlyTrend = SantriSakit::select(
            DB::raw("DATE_FORMAT(tgl_masuk, '%Y-%m') as month"),
            DB::raw('COUNT(*) as count')
        )
            ->where('tgl_masuk', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'summary' => [
                    'total_sakit' => $totalSakit,
                    'unique_santri_sakit' => $uniqueSantriSakit,
                    'currently_sick' => $currentlySick,
                    'by_tingkat' => $byTingkat,
                ],
                'top_santri' => $topSantri,
                'top_obat' => $topObat,
                'monthly_trend' => $monthlyTrend,
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

        // Monthly Sickness Trend (Last 6 Months)
        $monthlyTrend = SantriSakit::select(
            DB::raw("DATE_FORMAT(tgl_masuk, '%Y-%m') as month"),
            DB::raw('count(*) as count')
        )
            ->where('tgl_masuk', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'top_diagnoses' => $topDiagnoses,
                'monthly_trend' => $monthlyTrend
            ]
        ]);
    }
}
