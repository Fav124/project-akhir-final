<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Obat;
use App\Models\Santri;
use App\Models\SakitSantri;
use App\Models\Kelas;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create Admins
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'is_admin' => true,
                'active' => true
            ]
        );

        User::firstOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'Petugas Kesehatan',
                'password' => bcrypt('password'),
                'role' => 'user',
                'is_admin' => false,
                'active' => true
            ]
        );

        // 2. Create Jurusan (6 jurusan)
        if (Jurusan::count() == 0) {
            Jurusan::factory(6)->create();
        }

        // 3. Create Kelas
        if (Kelas::count() == 0) {
            $jurusans = Jurusan::all();
            foreach($jurusans as $jurusan) {
                // Manually setting names to avoid unique collision if factory isn't perfect
                Kelas::factory()->create(['nama_kelas' => 'X-' . $jurusan->id . '-1', 'jurusan_id' => $jurusan->id]);
                Kelas::factory()->create(['nama_kelas' => 'XI-' . $jurusan->id . '-1', 'jurusan_id' => $jurusan->id]);
            }
        }
        
        // 4. Create Obats
        if (Obat::count() == 0) {
            Obat::factory(20)->create();
        }

        // 5. Create Santris
        if (Santri::count() == 0) {
            Santri::factory(50)->create();
        }

        // 6. Create Sakit History
        try {
            if (SakitSantri::count() == 0) {
                // Ensure we have users with role user for factory
                if (User::where('role', 'user')->doesntExist()) {
                     User::factory()->create(['role' => 'user']);
                }
                SakitSantri::factory(30)->create();
            }
        } catch (\Exception $e) {
            $this->command->warn("SakitSantri seeding failed: " . $e->getMessage());
        }
    }
}
