<?php

namespace App\Livewire\Master;

use Livewire\Component;
use App\Models\Kelas;
use App\Models\Jurusan;
use Livewire\WithPagination;

class KelasIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $jurusanFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'jurusanFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingJurusanFilter()
    {
        $this->resetPage();
    }

    public function deleteKelas($id)
    {
        $kelas = Kelas::find($id);
        if ($kelas) {
            $kelas->delete();
            session()->flash('success', 'Kelas berhasil dihapus.');
        }
    }

    public function render()
    {
        $kelas = Kelas::with('jurusan')
            ->when($this->search, function($query) {
                $query->where('nama_kelas', 'like', '%' . $this->search . '%');
            })
            ->when($this->jurusanFilter, function($query) {
                $query->where('jurusan_id', $this->jurusanFilter);
            })
            ->latest()
            ->paginate(10);

        $jurusans = Jurusan::all();

        return view('livewire.master.kelas-index', [
            'kelas' => $kelas,
            'jurusans' => $jurusans
        ]);
    }
}
