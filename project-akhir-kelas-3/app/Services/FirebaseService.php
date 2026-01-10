<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Auth;

class FirebaseService
{
    protected $auth;
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('firebase.credentials'))
            ->withDatabaseUri(config('firebase.database_url'));

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }

    public function getAuth(): Auth
    {
        return $this->auth;
    }

    public function getDatabase(): Database
    {
        return $this->database;
    }

    /**
     * Verify Firebase ID Token
     */
    public function verifyIdToken($idToken)
    {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            return $verifiedIdToken->claims()->get('sub'); // Returns UID
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Sync user to Firebase Database
     */
    public function syncUser($user)
    {
        $this->database->getReference('users/' . $user->id)
            ->set([
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role ?? 'user',
                'created_at' => $user->created_at->toIso8601String(),
            ]);
    }
}
