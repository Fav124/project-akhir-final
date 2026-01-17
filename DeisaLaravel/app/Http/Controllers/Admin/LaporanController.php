<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SantriSakit;
use App\Models\PenggunaanObat;
use App\Models\Obat;
use App\Models\Kelas;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->start_date) : Carbon::now()->subDays(30);
        $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        // KPI
        $totalKunjungan = SantriSakit::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalObat = PenggunaanObat::whereBetween('created_at', [$startDate, $endDate])->sum('jumlah');
        $avgSakit = 2.5; // Dummy or calculated

        // Trend Data
        $days = [];
        $trendData = [];
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            $days[] = $date->format('d/m');
            $trendData[] = SantriSakit::whereDate('created_at', $date)->count();
        }

        // Class Distribution
        $classes = Kelas::all();
        $classLabels = [];
        $classData = [];
        foreach ($classes as $class) {
            $count = SantriSakit::whereHas('santri', function ($q) use ($class) {
                $q->where('kelas_id', $class->id);
            })->whereBetween('created_at', [$startDate, $endDate])->count();

            if ($count > 0) {
                $classLabels[] = $class->nama_kelas;
                $classData[] = $count;
            }
        }

        // Top Medicine
        $topObats = PenggunaanObat::with('obat')
            ->selectRaw('obat_id, sum(jumlah) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('obat_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $medicineLabels = $topObats->pluck('obat.nama_obat')->toArray();
        $medicineData = $topObats->pluck('total')->toArray();

        // Top 5 Santri with most sickness
        $topSantris = SantriSakit::with('santri')
            ->selectRaw('santri_id, count(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('santri_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.laporan.index', compact(
            'totalKunjungan',
            'totalObat',
            'avgSakit',
            'days',
            'trendData',
            'classLabels',
            'classData',
            'medicineLabels',
            'medicineData',
            'topSantris',
            'startDate',
            'endDate'
        ));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->start_date) : Carbon::now()->subDays(30);
        $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        $records = SantriSakit::with(['santri', 'santri.kelas', 'obats'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        $data = [
            'title' => 'Laporan Kesehatan Santri',
            'date_range' => $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y'),
            'records' => $records,
            'summary' => [
                'total_kunjungan' => $records->count(),
                'total_obat' => PenggunaanObat::whereBetween('created_at', [$startDate, $endDate])->sum('jumlah')
            ]
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf', $data);
        return $pdf->download('laporan-kesehatan-' . now()->format('Y-m-d') . '.pdf');
    }
}
