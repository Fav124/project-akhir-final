<?php

namespace App\Livewire\Master;

use Livewire\Component;
use App\Models\Jurusan;
use Livewire\WithPagination;

class JurusanIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteJurusan($id)
    {
        $jurusan = Jurusan::find($id);
        if ($jurusan) {
            $jurusan->delete();
            session()->flash('success', 'Jurusan berhasil dihapus.');
        }
    }

    public function render()
    {
        $jurusans = Jurusan::query()
            ->when($this->search, function($query) {
                $query->where('nama_jurusan', 'like', '%' . $this->search . '%')
                      ->orWhere('kode_jurusan', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.master.jurusan-index', [
            'jurusans' => $jurusans
        ]);
    }
}
