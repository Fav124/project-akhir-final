<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Santri;
use App\Models\Obat;
use App\Models\SantriSakit;
use Livewire\WithPagination;

class RealtimeDashboard extends Component
{
    use WithPagination;

    public $searchSantri = '';
    public $searchObat = '';
    public $filterStatus = 'Sakit';
    public $showModal = false;
    public $modalType = ''; // 'add_sakit', 'add_obat'

    public function updatingSearchSantri() { $this->resetPage(); }
    public function updatingSearchObat() { $this->resetPage(); }

    public function toggleModal($type = '')
    {
        $this->modalType = $type;
        $this->showModal = !$this->showModal;
    }

    public function render()
    {
        $stats = [
            'total_santri' => Santri::count(),
            'santri_sakit' => SantriSakit::where('status', 'Sakit')->count(),
            'total_obat' => Obat::count(),
            'low_stock' => Obat::whereColumn('stok', '<=', 'stok_minimum')->count(),
            'recovery_rate' => $this->calculateRecoveryRate(),
        ];

        $recentSakit = SantriSakit::with('santri')
            ->whereHas('santri', function($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->searchSantri . '%');
            })
            ->when($this->filterStatus, function($q) {
                $q->where('status', $this->filterStatus);
            })
            ->latest()
            ->take(5)
            ->get();

        $criticalObats = Obat::whereColumn('stok', '<=', 'stok_minimum')
            ->where('nama_obat', 'like', '%' . $this->searchObat . '%')
            ->get();

        return view('livewire.dashboard.realtime-dashboard', [
            'stats' => $stats,
            'recentSakit' => $recentSakit,
            'criticalObats' => $criticalObats
        ]);
    }

    private function calculateRecoveryRate()
    {
        $total = SantriSakit::count();
        if ($total == 0) return 100;
        $recovered = SantriSakit::where('status', 'Sembuh')->count();
        return round(($recovered / $total) * 100);
    }
}
