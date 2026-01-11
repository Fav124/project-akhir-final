<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class RegistrationIndex extends Component
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

    public function approve($id)
    {
        $reg = RegistrationRequest::findOrFail($id);
        
        DB::transaction(function () use ($reg) {
            User::create([
                'name' => $reg->name,
                'email' => $reg->email,
                'password' => $reg->password,
                'role' => 'petugas',
                'status' => 'active'
            ]);
            $reg->update(['status' => 'approved']);
        });

        session()->flash('success', 'User ' . $reg->name . ' berhasil disetujui.');
    }

    public function reject($id)
    {
        $reg = RegistrationRequest::findOrFail($id);
        $reg->update(['status' => 'rejected']);
        session()->flash('success', 'User ' . $reg->name . ' berhasil ditolak.');
    }

    public function render()
    {
        $requests = RegistrationRequest::where('status', 'pending')
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.registration-index', [
            'requests' => $requests
        ]);
    }
}
