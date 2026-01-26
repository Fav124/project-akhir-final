<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->status !== 'active') {
                Auth::logout();
                $message = $user->status === 'pending'
                    ? 'Akun Anda sedang menunggu persetujuan admin.'
                    : 'Akun Anda telah dinonaktifkan.';

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 403);
                }
                return back()->with('error', $message);
            }

            $redirectUrl = $user->role === 'admin' ? route('admin.dashboard') : route('user.dashboard');

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful! Redirecting...',
                    'redirect' => $redirectUrl
                ]);
            }

            return redirect()->intended($redirectUrl);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials do not match our records.',
                'errors' => ['email' => ['The provided credentials do not match our records.']]
            ], 422);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
