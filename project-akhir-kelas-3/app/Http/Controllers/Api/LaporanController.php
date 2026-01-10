<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SakitSantri;
use App\Models\Santri;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Get summary report
     * 
     * GET /api/laporan/summary
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function summary(Request $request)
    {
        // Date range
        $from = $request->get('from', Carbon::now()->startOfMonth()->toDateString());
        $to = $request->get('to', Carbon::now()->endOfMonth()->toDateString());

        // Total sakit dalam periode
        $totalSakit = SakitSantri::whereBetween('tanggal_mulai_sakit', [$from, $to])->count();

        // Unique santri yang sakit
        $uniqueSantriSakit = SakitSantri::whereBetween('tanggal_mulai_sakit', [$from, $to])
            ->distinct('santri_id')
            ->count('santri_id');

        // Currently sick (active)
        $currentlySick = SakitSantri::where('status', 'sakit')->count();

        // Top 5 santri paling sering sakit
        $topSantri = DB::table('sakit_santris')
            ->join('santris', 'sakit_santris.santri_id', '=', 'santris.id')
            ->leftJoin('kelas', 'santris.kelas_id', '=', 'kelas.id')
            ->select(
                'santris.id',
                'santris.nis',
                'santris.nama_lengkap',
                'santris.foto',
                'kelas.nama_kelas',
                DB::raw('COUNT(*) as sakit_count')
            )
            ->whereBetween('sakit_santris.tanggal_mulai_sakit', [$from, $to])
            ->groupBy('santris.id', 'santris.nis', 'santris.nama_lengkap', 'santris.foto', 'kelas.nama_kelas')
            ->orderByDesc('sakit_count')
            ->limit(5)
            ->get();

        // Top 10 obat paling sering dipakai
        $topObat = DB::table('sakit_santri_obat')
            ->join('obats', 'sakit_santri_obat.obat_id', '=', 'obats.id')
            ->join('sakit_santris', 'sakit_santri_obat.sakit_santri_id', '=', 'sakit_santris.id')
            ->select(
                'obats.id',
                'obats.nama_obat',
                'obats.satuan',
                DB::raw('COUNT(*) as times_used'),
                DB::raw('SUM(sakit_santri_obat.jumlah) as total_quantity')
            )
            ->whereBetween('sakit_santris.tanggal_mulai_sakit', [$from, $to])
            ->groupBy('obats.id', 'obats.nama_obat', 'obats.satuan')
            ->orderByDesc('times_used')
            ->limit(10)
            ->get();

        // Breakdown by tingkat kondisi
        $byTingkat = SakitSantri::whereBetween('tanggal_mulai_sakit', [$from, $to])
            ->select('tingkat_kondisi', DB::raw('COUNT(*) as count'))
            ->groupBy('tingkat_kondisi')
            ->get()
            ->pluck('count', 'tingkat_kondisi');

        // Obat alerts
        $expiringObats = Obat::expiringSoon(30)->count();
        $lowStockObats = Obat::lowStock()->count();
        $expiredObats = Obat::expired()->count();

        return response()->json([
            'success' => true,
            'data' => [
                'period' => [
                    'from' => $from,
                    'to' => $to
                ],
                'summary' => [
                    'total_sakit' => $totalSakit,
                    'unique_santri_sakit' => $uniqueSantriSakit,
                    'currently_sick' => $currentlySick,
                    'by_tingkat' => [
                        'ringan' => $byTingkat['ringan'] ?? 0,
                        'sedang' => $byTingkat['sedang'] ?? 0,
                        'berat' => $byTingkat['berat'] ?? 0
                    ]
                ],
                'top_santri' => $topSantri,
                'top_obat' => $topObat,
                'obat_alerts' => [
                    'expiring_soon' => $expiringObats,
                    'low_stock' => $lowStockObats,
                    'expired' => $expiredObats
                ]
            ]
        ]);
    }

    /**
     * Get detailed report data for export
     * 
     * GET /api/laporan/detail
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request)
    {
        $from = $request->get('from', Carbon::now()->startOfMonth()->toDateString());
        $to = $request->get('to', Carbon::now()->endOfMonth()->toDateString());

        $records = SakitSantri::with(['santri.kelas', 'obats', 'petugas'])
            ->whereBetween('tanggal_mulai_sakit', [$from, $to])
            ->orderBy('tanggal_mulai_sakit', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $records
        ]);
    }

    /**
     * Get monthly statistics
     * 
     * GET /api/laporan/monthly
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function monthly(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);

        $monthlyStats = DB::table('sakit_santris')
            ->select(
                DB::raw('MONTH(tanggal_mulai_sakit) as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(DISTINCT santri_id) as unique_santri')
            )
            ->whereYear('tanggal_mulai_sakit', $year)
            ->groupBy(DB::raw('MONTH(tanggal_mulai_sakit)'))
            ->orderBy('month')
            ->get();

        // Fill in missing months
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = $monthlyStats->firstWhere('month', $i);
            $result[] = [
                'month' => $i,
                'month_name' => Carbon::create()->month($i)->format('F'),
                'total' => $found ? $found->total : 0,
                'unique_santri' => $found ? $found->unique_santri : 0
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'year' => $year,
                'statistics' => $result
            ]
        ]);
    }

    /**
     * Download report (placeholder - returns data for client-side generation)
     * 
     * GET /api/laporan/download
     * @param Request $request
     * @return mixed
     */
    public function download(Request $request)
    {
        $format = $request->get('format', 'json');
        $from = $request->get('from', Carbon::now()->startOfMonth()->toDateString());
        $to = $request->get('to', Carbon::now()->endOfMonth()->toDateString());

        // Get summary data
        $summaryResponse = $this->summary($request);
        $summaryData = json_decode($summaryResponse->getContent(), true);

        // Get detail data
        $records = SakitSantri::with(['santri.kelas', 'obats', 'petugas'])
            ->whereBetween('tanggal_mulai_sakit', [$from, $to])
            ->orderBy('tanggal_mulai_sakit', 'desc')
            ->get();

        if ($format === 'json') {
            return response()->json([
                'success' => true,
                'data' => [
                    'summary' => $summaryData['data'],
                    'records' => $records
                ]
            ]);
        }

        // For PDF/Excel, return JSON data that can be used by frontend or web controller
        return response()->json([
            'success' => true,
            'message' => 'Use web endpoint /laporan/report/pdf for PDF download',
            'data' => [
                'summary' => $summaryData['data'],
                'records' => $records
            ]
        ]);
    }
}
