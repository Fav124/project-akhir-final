<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $request->has('request_admin') ? 'user' : 'user', // Default to user, admin approval for upgrade
                'status' => 'pending',
            ]);

            // If request admin, we could store this in a separate column or just let admin decide
            if ($request->has('request_admin')) {
                $user->update(['role' => 'user']); // Keeps as user, admin will change to admin if approved
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registrasi berhasil. Silakan tunggu persetujuan admin sebelum dapat login.',
                    'redirect' => route('login')
                ]);
            }

            return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan tunggu persetujuan admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal registrasi: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal registrasi: ' . $e->getMessage())->withInput();
        }
    }
}
