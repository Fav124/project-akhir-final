<?php

namespace App\Livewire\Master;

use Livewire\Component;
use App\Models\Diagnosis;
use Livewire\WithPagination;

class DiagnosisIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function deleteDiagnosis($id)
    {
        $diagnosis = Diagnosis::find($id);
        if ($diagnosis) {
            $diagnosis->delete();
            session()->flash('success', 'Diagnosis berhasil dihapus.');
        }
    }

    public function render()
    {
        $diagnoses = Diagnosis::query()
            ->when($this->search, function($query) {
                $query->where('nama_diagnosis', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function($query) {
                $query->where('kategori', $this->category);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.master.diagnosis-index', [
            'diagnoses' => $diagnoses
        ]);
    }
}
