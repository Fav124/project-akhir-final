<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login user and create token
     * 
     * POST /api/login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:6', // Nullable for Google Sign In
            'google_id' => 'nullable|string',
            'avatar' => 'nullable|string',
            'device_name' => 'nullable|string'
        ]);

        // Check if email already exists in registration_requests
        $existingRequest = \App\Models\RegistrationRequest::where('email', $request->email)->first();
        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan registrasi untuk email ini sedang menunggu persetujuan admin.',
            ], 409);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'google_id' => $request->google_id,
            'avatar' => $request->avatar,
            'device_name' => $request->device_name,
            'status' => 'pending'
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        \App\Models\RegistrationRequest::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil dikirim. Mohon tunggu persetujuan dari admin.',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'device_name' => 'nullable|string'
        ]);

        // Check pending requests
        $pendingRequest = \App\Models\RegistrationRequest::where('email', $request->email)->first();
        if ($pendingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda masih menunggu persetujuan admin.'
            ], 403);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Check if user is active
        // Check if user is active - DISABLED (Column does not exist)
        // if (!$user->active) {
        //     throw ValidationException::withMessages([
        //         'email' => ['Akun Anda tidak aktif. Hubungi administrator.'],
        //     ]);
        // }

        // Create token
        $deviceName = $request->device_name ?? 'android-app';
        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'foto' => $user->foto_url,
                    'phone' => $user->phone
                ],
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ]);
    }

    /**
     * Logout user (revoke token)
     * 
     * POST /api/logout
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * Get current user profile
     * 
     * GET /api/user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'foto' => $user->foto_url,
                'phone' => $user->phone,
                'is_admin' => $user->isAdmin(),
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]
        ]);
    }

    /**
     * Update user profile
     * 
     * PUT /api/user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('users', $filename, 'public');
            $user->foto = $path;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'foto' => $user->foto_url,
                'phone' => $user->phone
            ]
        ]);
    }

    /**
     * Change password
     * 
     * PUT /api/user/password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password saat ini salah.'],
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }
}
