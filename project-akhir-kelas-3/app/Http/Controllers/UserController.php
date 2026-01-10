<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::orderBy('name');

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%");
            }

            $users = $query->paginate(10);
            return view('users.table', compact('users'))->render();
        }

        $users = User::orderBy('name')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['name', 'email', 'role', 'phone']);
        $data['password'] = Hash::make($request->password);
        $data['is_admin'] = $request->role === 'admin';
        $data['active'] = true;

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = 'user_' . time() . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('users', $filename, 'public');
            $data['foto'] = $path;
        }

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan! 🎉');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'active' => 'boolean'
        ]);

        $data = $request->only(['name', 'email', 'role', 'phone']);
        $data['is_admin'] = $request->role === 'admin';
        $data['active'] = $request->has('active');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            
            $foto = $request->file('foto');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('users', $filename, 'public');
            $data['foto'] = $path;
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui! ✏️');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        // Delete foto
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Toggle user active status
     */
    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'Tidak dapat menonaktifkan akun sendiri'], 422);
        }

        $user->update(['active' => !$user->active]);

        return response()->json([
            'success' => true,
            'active' => $user->active,
            'message' => $user->active ? 'User diaktifkan' : 'User dinonaktifkan'
        ]);
    }
}
