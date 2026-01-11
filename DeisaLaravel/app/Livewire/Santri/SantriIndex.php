<?php

namespace App\Livewire\Santri;

use Livewire\Component;
use App\Models\Santri;
use Livewire\WithPagination;

class SantriIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

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

    public function deleteSantri($id)
    {
        $santri = Santri::find($id);
        if ($santri) {
            $santri->delete();
            session()->flash('success', 'Santri berhasil dihapus.');
        }
    }

    public function render()
    {
        $santris = Santri::with(['kelas', 'jurusan'])
            ->when($this->search, function($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                      ->orWhere('nis', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function($query) {
                $query->where('status_kesehatan', $this->status);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.santri.santri-index', [
            'santris' => $santris
        ])->layout('layouts.app-tailwind')->with([
            'page_title' => 'Manajemen Santri',
            'page_subtitle' => 'Database Santri Terpusat'
        ]);
    }
}
