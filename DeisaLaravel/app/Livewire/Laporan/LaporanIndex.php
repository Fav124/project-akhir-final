<?php

namespace App\Livewire\Laporan;

use Livewire\Component;

use App\Models\Santri;
use App\Models\SantriSakit;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;

class LaporanIndex extends Component
{
    public $summary = [];
    public $topDiagnoses = [];
    public $monthlyTrend = [];

    public function mount()
    {
        $this->summary = [
            'total_santri' => Santri::count(),
            'total_sakit' => SantriSakit::where('status', 'Sakit')->count(),
            'total_sembuh' => SantriSakit::where('status', 'Sembuh')->count(),
            'low_stock_obat' => Obat::whereColumn('stok', '<=', 'stok_minimum')->count(),
        ];

        $this->topDiagnoses = DB::table('santri_sakit_diagnoses')
            ->join('diagnoses', 'santri_sakit_diagnoses.diagnosis_id', '=', 'diagnoses.id')
            ->select('diagnoses.nama_diagnosis', DB::raw('count(*) as count'))
            ->groupBy('diagnoses.id', 'diagnoses.nama_diagnosis')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()->toArray();

        $this->monthlyTrend = SantriSakit::select(
                DB::raw("DATE_FORMAT(tgl_masuk, '%Y-%m') as month"),
                DB::raw('count(*) as count')
            )
            ->where('tgl_masuk', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()->toArray();
    }

    public function render()
    {
        return view('livewire.laporan.laporan-index')
            ->layout('layouts.app-tailwind')
            ->with([
                'page_title' => 'Analytics Hub',
                'page_subtitle' => 'Data Visualisasi Kesehatan'
            ]);
    }
}
