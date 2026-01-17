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

        return response()->json([
            'success' => true,
            'data' => [
                'summary' => [
                    'total_sakit' => $totalSakit,
                    'unique_santri_sakit' => $uniqueSantriSakit,
                    'currently_sick' => $currentlySick,
                    'by_tingkat' => $byTingkat,
                ],
                'top_santri' => [], // TODO: Implement if needed
                'top_obat' => [], // TODO: Implement if needed
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
