<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Obat;
use App\Models\SakitSantri;
use App\Models\RiwayatPemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Basic counts
        $totalSantri = Santri::count();
        $totalKelas = Kelas::count();
        $totalObat = Obat::count();
        $totalLaporan = RiwayatPemeriksaan::count();

        // Sakit statistics
        $sakitHariIni = SakitSantri::whereDate('tanggal_mulai_sakit', today())->count();
        $santriSedangSakit = SakitSantri::where('status', 'sakit')->count();
        $sakitBulanIni = SakitSantri::whereMonth('tanggal_mulai_sakit', now()->month)
            ->whereYear('tanggal_mulai_sakit', now()->year)
            ->count();

        // Obat alerts
        $obatKadaluarsa = Obat::expiringSoon(30)->count();
        $obatStokRendah = Obat::lowStock()->count();
        $obatExpired = Obat::expired()->count();

        // Top 5 santri paling sering sakit (bulan ini)
        $topSantriSakit = DB::table('sakit_santris')
            ->join('santris', 'sakit_santris.santri_id', '=', 'santris.id')
            ->leftJoin('kelas', 'santris.kelas_id', '=', 'kelas.id')
            ->select(
                'santris.id',
                'santris.nama_lengkap',
                'santris.foto',
                'kelas.nama_kelas',
                DB::raw('COUNT(*) as sakit_count')
            )
            ->whereMonth('sakit_santris.tanggal_mulai_sakit', now()->month)
            ->whereYear('sakit_santris.tanggal_mulai_sakit', now()->year)
            ->groupBy('santris.id', 'santris.nama_lengkap', 'santris.foto', 'kelas.nama_kelas')
            ->orderByDesc('sakit_count')
            ->limit(5)
            ->get();

        // Obat mendekati kadaluarsa (list)
        $obatMendekatiKadaluarsa = Obat::expiringSoon(30)
            ->orderBy('tanggal_kadaluarsa')
            ->limit(5)
            ->get();

        // Obat stok rendah (list)
        $obatStokRendahList = Obat::lowStock()
            ->orderBy('stok')
            ->limit(5)
            ->get();

        // Recent sakit records
        $recentSakit = SakitSantri::with(['santri', 'obats'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Chart Data (Last 7 Days)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('D'); // Mon, Tue, etc.
            $chartData[] = SakitSantri::whereDate('tanggal_mulai_sakit', $date->toDateString())->count();
        }

        return view('dashboard', compact(
            'totalSantri',
            'totalKelas',
            'totalObat',
            'totalLaporan',
            'sakitHariIni',
            'santriSedangSakit',
            'sakitBulanIni',
            'obatKadaluarsa',
            'obatStokRendah',
            'obatExpired',
            'topSantriSakit',
            'obatMendekatiKadaluarsa',
            'obatStokRendahList',
            'recentSakit',
            'chartLabels',
            'chartData'
        ));
    }

    public function coba()
    {
        return view('style.santri.create');
    }
}
