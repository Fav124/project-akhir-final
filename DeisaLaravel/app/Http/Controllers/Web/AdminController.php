<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function registrations()
    {
        $requests = RegistrationRequest::where('status', 'pending')->paginate(15);
        return view('admin.registrations', compact('requests'));
    }

    public function approve($id)
    {
        $reg = RegistrationRequest::findOrFail($id);
        
        DB::transaction(function () use ($reg) {
            User::create([
                'name' => $reg->name,
                'email' => $reg->email,
                'password' => $reg->password,
                'role' => 'petugas'
            ]);
            $reg->update(['status' => 'approved']);
        });

        return back()->with('success', 'User berhasil disetujui.');
    }

    public function reject($id)
    {
        $reg = RegistrationRequest::findOrFail($id);
        $reg->update(['status' => 'rejected']);
        return back()->with('success', 'User berhasil ditolak.');
    }

    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus diri sendiri.');
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
