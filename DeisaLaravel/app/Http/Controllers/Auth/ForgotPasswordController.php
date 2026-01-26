<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if ($user) {
            return back()->with('success', 'Permintaan reset password telah dicatat. Silakan hubungi Admin untuk instruksi selanjutnya.');
        }

        return back()->withErrors(['email' => 'Email tidak terdaftar dalam sistem.']);
    }
}
