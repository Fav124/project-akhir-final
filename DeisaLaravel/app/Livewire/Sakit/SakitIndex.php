<?php

namespace App\Livewire\Sakit;

use Livewire\Component;
use App\Models\SantriSakit;
use Livewire\WithPagination;

class SakitIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'Sakit';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function markSembuh($id)
    {
        $sakit = SantriSakit::find($id);
        if ($sakit) {
            $sakit->update([
                'status' => 'Sembuh',
                'tgl_sembuh' => now()
            ]);
            $sakit->santri->update(['status_kesehatan' => 'Sehat']);
            session()->flash('success', 'Santri dinyatakan sembuh.');
        }
    }

    public function render()
    {
        $sakits = SantriSakit::with(['santri.kelas', 'santri.jurusan'])
            ->whereHas('santri', function($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                      ->orWhere('nis', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.sakit.sakit-index', [
            'sakits' => $sakits
        ])->layout('layouts.app-tailwind')->with([
            'page_title' => 'Catatan Medis',
            'page_subtitle' => 'Log Kesehatan & Penanganan'
        ]);
    }
}
