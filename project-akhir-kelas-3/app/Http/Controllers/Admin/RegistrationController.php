<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function index()
    {
        $requests = RegistrationRequest::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.registrations.index', compact('requests'));
    }

    public function approve($id)
    {
        $request = RegistrationRequest::findOrFail($id);

        // Check if email already exists in users
        if (User::where('email', $request->email)->exists()) {
            $request->delete();
            return redirect()->back()->with('error', 'User dengan email ini sudah ada.');
        }

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Password already hashed or null
            'google_id' => $request->google_id,
            'avatar' => $request->avatar,
            'role' => 'user', // Default role
            'is_admin' => false,
            'active' => true // Virtual flag
        ]);

        if (!$user->password && !$user->google_id) {
             // Fallback if somehow both are null, though validation prevents this
             $user->password = Hash::make(Str::random(16));
             $user->save();
        }

        $request->status = 'approved';
        $request->save();
        
        // Optionally delete the request after approval
        $request->delete();

        return redirect()->back()->with('success', 'User berhasil disetujui.');
    }

    public function reject($id)
    {
        $request = RegistrationRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();
        $request->delete(); // Soft delete or hard delete depending on requirement

        return redirect()->back()->with('success', 'User ditolak.');
    }
}
