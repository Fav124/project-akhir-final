<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@pesantren.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_admin' => true,
            'active' => true,
        ]);

        // Optional: Create a test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@pesantren.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_admin' => false,
            'active' => true,
        ]);
    }
}
