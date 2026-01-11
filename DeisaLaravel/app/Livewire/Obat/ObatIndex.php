<?php

namespace App\Livewire\Obat;

use Livewire\Component;
use App\Models\Obat;
use Livewire\WithPagination;

class ObatIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $stockFilter = ''; // 'low', 'normal'

    protected $queryString = [
        'search' => ['except' => ''],
        'stockFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStockFilter()
    {
        $this->resetPage();
    }

    public function deleteObat($id)
    {
        $obat = Obat::find($id);
        if ($obat) {
            $obat->delete();
            session()->flash('success', 'Obat berhasil dihapus.');
        }
    }

    public function render()
    {
        $obats = Obat::query()
            ->when($this->search, function($query) {
                $query->where('nama_obat', 'like', '%' . $this->search . '%');
            })
            ->when($this->stockFilter === 'low', function($query) {
                $query->whereColumn('stok', '<=', 'stok_minimum');
            })
            ->when($this->stockFilter === 'normal', function($query) {
                $query->whereColumn('stok', '>', 'stok_minimum');
            })
            ->latest()
            ->paginate(12);

        return view('livewire.obat.obat-index', [
            'obats' => $obats
        ])->layout('layouts.app-tailwind')->with([
            'page_title' => 'Inventaris Obat',
            'page_subtitle' => 'Manajemen Stok & Distribusi'
        ]);
    }
}
