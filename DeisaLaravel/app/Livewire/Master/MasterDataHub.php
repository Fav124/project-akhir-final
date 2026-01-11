<?php

namespace App\Livewire\Master;

use Livewire\Component;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Diagnosis;
use Livewire\WithPagination;

class MasterDataHub extends Component
{
    use WithPagination;

    public $activeTab = 'kelas'; // 'kelas', 'jurusan', 'diagnosis'
    public $search = '';

    protected $queryString = [
        'activeTab' => ['except' => 'kelas'],
        'search' => ['except' => ''],
    ];

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->search = '';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteKelas($id)
    {
        Kelas::find($id)?->delete();
        session()->flash('success', 'Kelas berhasil dihapus.');
    }

    public function deleteJurusan($id)
    {
        Jurusan::find($id)?->delete();
        session()->flash('success', 'Jurusan berhasil dihapus.');
    }

    public function deleteDiagnosis($id)
    {
        Diagnosis::find($id)?->delete();
        session()->flash('success', 'Diagnosis berhasil dihapus.');
    }

    public function render()
    {
        $data = [];

        if ($this->activeTab === 'kelas') {
            $data = Kelas::where('nama_kelas', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10);
        } elseif ($this->activeTab === 'jurusan') {
            $data = Jurusan::where('nama_jurusan', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10);
        } else {
            $data = Diagnosis::where('nama_diagnosis', 'like', '%' . $this->search . '%')
                ->orWhere('kategori', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10);
        }

        return view('livewire.master.master-data-hub', [
            'items' => $data
        ])->layout('layouts.app-tailwind')->with([
            'page_title' => 'Master Data Hub',
            'page_subtitle' => 'Konfigurasi Sistem Utama'
        ]);
    }
}
