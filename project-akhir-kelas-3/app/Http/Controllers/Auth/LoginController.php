<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    /**
     * Show the application registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:registration_requests'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        \App\Models\RegistrationRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'status' => 'pending'
        ]);

        return back()->with('success', 'Registrasi berhasil dikirim. Mohon tunggu persetujuan dari admin.');
    }

    /**
     * Redirect to Google
     */
    public function redirectToGoogle()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google Callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();
            
            // 1. Check if user already exists in main Users table
            $user = \App\Models\User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // If user exists, just login
                Auth::login($user, true);
                return redirect()->intended('dashboard');
            }
            
            // 2. Check if there is a pending request
            $pending = \App\Models\RegistrationRequest::where('email', $googleUser->getEmail())->first();
            
            if ($pending) {
                return redirect('/login')->withErrors(['email' => 'Akun Anda masih menunggu persetujuan admin.']);
            }
            
            // 3. Create new Registration Request
            \App\Models\RegistrationRequest::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'status' => 'pending'
            ]);
            
            return redirect('/login')->withErrors(['success' => 'Registrasi Google berhasil dikirim. Mohon tunggu persetujuan dari admin.']);

        } catch (\Throwable $e) {
            return redirect('/login')->withErrors(['email' => 'Google Login Failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Log the user out
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

