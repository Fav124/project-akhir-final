<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPemeriksaan;
use App\Models\Santri;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $laporan = RiwayatPemeriksaan::with('santri')->get();
        return view('laporan.index', compact('laporan'));
    }

    public function create()
    {
        $santri = Santri::all();
        $obat = Obat::all();
        return view('laporan.create', compact('santri', 'obat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal_pemeriksaan' => 'required|date',
            'keluhan' => 'required|string',
            'suhu_tubuh' => 'required|numeric',
            'tindakan' => 'nullable|string',
            'status_kondisi' => 'required|string'
        ]);

        RiwayatPemeriksaan::create($request->only('santri_id', 'tanggal_pemeriksaan', 'keluhan', 'suhu_tubuh', 'tindakan', 'status_kondisi'));

        return redirect()->route('laporan.index')->with('success', 'Laporan pemeriksaan berhasil ditambahkan');
    }

    public function edit(RiwayatPemeriksaan $laporan)
    {
        $santri = Santri::all();
        $obat = Obat::all();
        return view('laporan.edit', compact('laporan', 'santri', 'obat'));
    }

    public function update(Request $request, RiwayatPemeriksaan $laporan)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal_pemeriksaan' => 'required|date',
            'keluhan' => 'required|string',
            'suhu_tubuh' => 'required|numeric',
            'tindakan' => 'nullable|string',
            'status_kondisi' => 'required|string'
        ]);

        $laporan->update($request->only('santri_id', 'tanggal_pemeriksaan', 'keluhan', 'suhu_tubuh', 'tindakan', 'status_kondisi'));

        return redirect()->route('laporan.index')->with('success', 'Laporan pemeriksaan berhasil diperbarui');
    }

    public function destroy(RiwayatPemeriksaan $laporan)
    {
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan pemeriksaan berhasil dihapus');
    }

    /**
     * Report view with filters: period (this_month, this_year, custom) or date range
     */
    public function report(Request $request)
    {
        $period = $request->get('period', 'this_month');
        $start = null;
        $end = null;

        if ($period === 'this_year') {
            $start = Carbon::now()->startOfYear();
            $end = Carbon::now()->endOfYear();
        } elseif ($period === 'this_month') {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
        } elseif ($period === 'custom') {
            $sd = $request->get('start_date');
            $ed = $request->get('end_date');
            if ($sd && $ed) {
                $start = Carbon::parse($sd)->startOfDay();
                $end = Carbon::parse($ed)->endOfDay();
            }
        }

        // Base query for SakitSantri within range
        $sakitQuery = DB::table('sakit_santris');
        if ($start && $end) {
            $sakitQuery->whereBetween('tanggal_mulai_sakit', [$start->toDateString(), $end->toDateString()]);
        }

        // 1) jumlah santri yang sakit (unique santri count)
        $uniqueSantriCount = (clone $sakitQuery)->distinct()->count(DB::raw('santri_id'));

        // 2) top obat yang dipakai (join pivot table sakit_santri_obat)
        $topObats = [];
        $pivotTable = 'sakit_santri_obat';
    if (Schema::hasTable($pivotTable)) {
            $obatQuery = DB::table($pivotTable)
                ->join('obats', 'obats.id', '=', "$pivotTable.obat_id")
                ->join('sakit_santris', 'sakit_santris.id', '=', "$pivotTable.sakit_santri_id")
                ->select('obats.id', 'obats.nama_obat', DB::raw('SUM(' . $pivotTable . '.jumlah) as total_jumlah'))
                ->groupBy('obats.id', 'obats.nama_obat')
                ->orderByDesc('total_jumlah');

            if ($start && $end) {
                $obatQuery->whereBetween('sakit_santris.tanggal_mulai_sakit', [$start->toDateString(), $end->toDateString()]);
            }

            $topObats = $obatQuery->limit(10)->get();
        }

        // 3) santri yang paling sering sakit
        $topSantri = DB::table('sakit_santris')
            ->select('santri_id', DB::raw('COUNT(*) as times_sick'))
            ->groupBy('santri_id')
            ->orderByDesc('times_sick');

        if ($start && $end) {
            $topSantri->whereBetween('tanggal_mulai_sakit', [$start->toDateString(), $end->toDateString()]);
        }

        $topSantri = $topSantri->limit(10)->get();
        // Load names
        $santriIds = $topSantri->pluck('santri_id')->all();
        $santriMap = DB::table('santris')->whereIn('id', $santriIds)->pluck('nama_lengkap', 'id');

        $topSantri = $topSantri->map(function ($r) use ($santriMap) {
            return [
                'santri_id' => $r->santri_id,
                'nama' => $santriMap[$r->santri_id] ?? 'N/A',
                'times_sick' => $r->times_sick
            ];
        });

        return view('laporan.report', compact('uniqueSantriCount', 'topObats', 'topSantri', 'start', 'end', 'period'));
    }

    /**
     * Generate PDF of report (fallback: return same HTML view)
     */
    /**
     * Generate PDF of report
     */
    public function reportPdf(Request $request)
    {
        // Get data using the same logic as report()
        // We can't reuse report() directly because it returns a View or response
        // So we duplicate the data fetching logic for now or extract it.
        // For simplicity and to avoid major refactor risk now, I will duplicate the data fetching logic.
        
        $period = $request->get('period', 'this_month');
        $start = null;
        $end = null;

        if ($period === 'this_year') {
            $start = Carbon::now()->startOfYear();
            $end = Carbon::now()->endOfYear();
        } elseif ($period === 'this_month') {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
        } elseif ($period === 'custom') {
            $sd = $request->get('start_date');
            $ed = $request->get('end_date');
            if ($sd && $ed) {
                $start = Carbon::parse($sd)->startOfDay();
                $end = Carbon::parse($ed)->endOfDay();
            }
        }

        // Defaults if no dates
        if (!$start) $start = Carbon::now()->startOfMonth();
        if (!$end) $end = Carbon::now()->endOfMonth();

        // 1) jumlah santri yang sakit (unique santri count)
        $sakitQuery = DB::table('sakit_santris')
            ->whereBetween('tanggal_mulai_sakit', [$start->toDateString(), $end->toDateString()]);
            
        $uniqueSantriCount = (clone $sakitQuery)->distinct()->count('santri_id');

        // 2) top obat yang dipakai
        $topObats = [];
        $pivotTable = 'sakit_santri_obat';
        if (Schema::hasTable($pivotTable)) {
            $topObats = DB::table($pivotTable)
                ->join('obats', 'obats.id', '=', "$pivotTable.obat_id")
                ->join('sakit_santris', 'sakit_santris.id', '=', "$pivotTable.sakit_santri_id")
                ->select('obats.id', 'obats.nama_obat', DB::raw('SUM(' . $pivotTable . '.jumlah) as total_jumlah'))
                ->whereBetween('sakit_santris.tanggal_mulai_sakit', [$start->toDateString(), $end->toDateString()])
                ->groupBy('obats.id', 'obats.nama_obat')
                ->orderByDesc('total_jumlah')
                ->limit(10)
                ->get();
        }

        // 3) santri yang paling sering sakit
        $topSantri = DB::table('sakit_santris')
            ->select('santri_id', DB::raw('COUNT(*) as times_sick'))
            ->whereBetween('tanggal_mulai_sakit', [$start->toDateString(), $end->toDateString()])
            ->groupBy('santri_id')
            ->orderByDesc('times_sick')
            ->limit(10)
            ->get();

        // Load names & class
        $santriIds = $topSantri->pluck('santri_id')->all();
        $santris = DB::table('santris')
            ->leftJoin('kelas', 'santris.kelas_id', '=', 'kelas.id')
            ->whereIn('santris.id', $santriIds)
            ->select('santris.id', 'santris.nama_lengkap', 'kelas.nama_kelas')
            ->get()
            ->keyBy('id');

        $topSantri = $topSantri->map(function ($r) use ($santris) {
            $s = $santris->get($r->santri_id);
            return [
                'santri_id' => $r->santri_id,
                'nama' => $s ? $s->nama_lengkap : 'N/A',
                'kelas' => $s ? $s->nama_kelas : '-',
                'times_sick' => $r->times_sick
            ];
        });

        $data = compact('uniqueSantriCount', 'topObats', 'topSantri', 'start', 'end', 'period');

        // Render PDF
        if (class_exists('\Barryvdh\DomPDF\Facade')) {
            $pdf = \Barryvdh\DomPDF\Facade::loadView('laporan.pdf', $data);
            return $pdf->stream('laporan-santri-' . now()->format('YmdHis') . '.pdf');
        }

        // fallback if dompdf is not installed, return view
        return view('laporan.pdf', $data);
    }
}
