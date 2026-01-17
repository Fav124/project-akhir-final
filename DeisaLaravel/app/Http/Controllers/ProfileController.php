<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('profile');
        if (!$user->profile) {
            $user->profile()->create();
            $user->load('profile');
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
        ]);

        $user->update(['name' => $validated['name']]);
        $user->profile->update([
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'bio' => $validated['bio'],
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Profil berhasil diperbarui', 'reload' => true]);
        }
        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
