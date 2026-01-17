<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::with('profile')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,petugas,user',
        ]);

        try {
            $user = \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'status' => 'active',
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'CREATE',
                'module' => 'User',
                'detail' => "Menambahkan user baru: {$user->name} sebagai {$user->role}",
                'ip_address' => $request->ip()
            ]);

            $user->profile()->create();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'User berhasil ditambahkan', 'reload' => true]);
            }
            return redirect()->back()->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menambahkan user: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,petugas,user',
            'password' => 'nullable|string|min:8',
        ]);

        try {
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($validated['password']);
            }

            $user->update($data);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'UPDATE',
                'module' => 'User',
                'detail' => "Memperbarui data user: {$user->name}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'User berhasil diperbarui', 'reload' => true]);
            }
            return redirect()->back()->with('success', 'User berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal memperbarui user: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $user = \App\Models\User::findOrFail($id);
            if ($id == auth()->id()) {
                throw new \Exception("Anda tidak dapat menghapus akun Anda sendiri.");
            }
            $userName = $user->name;
            $user->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'DELETE',
                'module' => 'User',
                'detail' => "Menghapus user: {$userName}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'User berhasil dihapus', 'reload' => true]);
            }
            return redirect()->back()->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menghapus user: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
    public function approve(Request $request, $id)
    {
        try {
            $user = \App\Models\User::findOrFail($id);
            $user->update(['status' => 'active']);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'APPROVE',
                'module' => 'User',
                'detail' => "Menyetujui pendaftaran user: {$user->name}",
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'User berhasil disetujui', 'reload' => true]);
            }
            return redirect()->back()->with('success', 'User berhasil disetujui');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menyetujui user: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menyetujui user: ' . $e->getMessage());
        }
    }
}
