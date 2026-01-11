<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RegistrationRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users', // Also should check registration_requests uniqueness in real app
            'password' => 'required|min:6'
        ]);

        // Check if email already in pending requests
        if (RegistrationRequest::where('email', $request->email)->where('status', 'pending')->exists()) {
            return response()->json(['message' => 'Registration request already pending.'], 409);
        }

        RegistrationRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Registration successful. Waiting for admin approval.'], 201);
    }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required', 'password' => 'required']);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => [
                'user' => $user,
                'token' => $token
            ] 
        ]);
    }
    
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
    
    public function user(Request $request) {
        return response()->json(['data' => $request->user()]);
    }
}
