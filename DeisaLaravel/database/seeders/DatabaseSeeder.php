<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\Obat;
use App\Models\Diagnosis;
use App\Models\SantriSakit;
use App\Models\WaliSantri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin & Petugas
        User::updateOrCreate(
            ['email' => 'admin@deisa.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active'
            ]
        );

        User::updateOrCreate(
            ['email' => 'petugas@deisa.com'],
            [
                'name' => 'Petugas UKS',
                'password' => Hash::make('password'),
                'role' => 'petugas',
                'status' => 'active'
            ]
        );

        // // Master Data
        // $dataJurusans = [
        //     ['nama_jurusan' => 'Ilmu Pengetahuan Alam', 'kode_jurusan' => 'IPA'],
        //     ['nama_jurusan' => 'Ilmu Pengetahuan Sosial', 'kode_jurusan' => 'IPS'],
        //     ['nama_jurusan' => 'Bahasa dan Budaya', 'kode_jurusan' => 'BAHASA'],
        //     ['nama_jurusan' => 'Ilmu Agama Islam', 'kode_jurusan' => 'AGAMA'],
        // ];

        // foreach ($dataJurusans as $dj) {
        //     $jurusan = Jurusan::firstOrCreate(['kode_jurusan' => $dj['kode_jurusan']], $dj);
        //     Kelas::firstOrCreate(
        //         ['nama_kelas' => '10A', 'jurusan_id' => $jurusan->id],
        //         ['tahun_ajaran' => '2023/2024']
        //     );
        //     Kelas::firstOrCreate(
        //         ['nama_kelas' => '11A', 'jurusan_id' => $jurusan->id],
        //         ['tahun_ajaran' => '2023/2024']
        //     );
        // }

        // Diagnosis::factory(10)->create();
        // Obat::factory(20)->create();

        // // Santri & Records
        // Santri::factory(30)->create()->each(function ($santri) {
        //     // Wali
        //     WaliSantri::create([
        //         'santri_id' => $santri->id,
        //         'nama_wali' => 'Bpk/Ibu ' . explode(' ', $santri->nama_lengkap)[0],
        //         'hubungan' => 'Orang Tua',
        //         'no_hp' => '08' . rand(111111111, 999999999),
        //         'no_telp_wali' => '08' . rand(111111111, 999999999),
        //         'alamat' => $santri->alamat
        //     ]);

        //     // Ensure some records for dashboard
        //     SantriSakit::factory(rand(1, 2))->create([
        //         'santri_id' => $santri->id
        //     ]);
        // });
    }
}
