<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('profile');
        if (!$user->profile) {
            $user->profile()->create();
            $user->load('profile');
        }

        if ($user->role == 'user') {
            return view('user.profile', compact('user'));
        }

        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|string|min:8|confirmed',
            'theme_color' => 'nullable|string'
        ]);

        // Update User Name
        $user->name = $validated['name'];

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->profile->avatar) {
                Storage::disk('public')->delete($user->profile->avatar);
            }
            $user->profile->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Handle Password Update
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        // Update Profile
        $settings = $user->profile->settings ?? [];
        if ($request->filled('theme_color')) {
            $settings['theme_color'] = $request->theme_color;
        }

        $user->profile->update([
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'bio' => $validated['bio'],
            'settings' => $settings
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Profil berhasil diperbarui', 'reload' => true]);
        }
        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
