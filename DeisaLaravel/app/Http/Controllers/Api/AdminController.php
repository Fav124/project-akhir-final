<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RegistrationRequest;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * List all pending registration requests.
     */
    public function getPendingRegistrations()
    {
        $requests = RegistrationRequest::where('status', 'pending')->get();
        return response()->json(['data' => $requests]);
    }

    /**
     * Approve a registration request and create a user.
     */
    public function approveRegistration($id)
    {
        $regRequest = RegistrationRequest::findOrFail($id);

        if ($regRequest->status !== 'pending') {
            return response()->json(['message' => 'Request is already processed.'], 400);
        }

        $user = User::create([
            'name' => $regRequest->name,
            'email' => $regRequest->email,
            'password' => $regRequest->password, // Already hashed
            'role' => 'petugas', // Default role
            'status' => 'active',
        ]);

        $regRequest->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'User approved and created successfully.',
            'data' => $user
        ]);
    }

    /**
     * Reject a registration request.
     */
    public function rejectRegistration($id)
    {
        $regRequest = RegistrationRequest::findOrFail($id);
        $regRequest->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Request rejected.'
        ]);
    }

    /**
     * List all users.
     */
    public function getUsers()
    {
        $users = User::all();
        return response()->json(['data' => $users]);
    }

    /**
     * Delete a user.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'Cannot delete yourself.'], 400);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    /**
     * Toggle admin role for a user.
     */
    public function toggleAdmin($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'Cannot change your own role.'], 400);
        }

        $user->role = $user->role === 'admin' ? 'petugas' : 'admin';
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User role updated to ' . $user->role,
            'data' => $user
        ]);
    }
}
