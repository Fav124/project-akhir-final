<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanFactory extends Factory
{
    public function definition()
    {
        $jurusans = [
            ['nama' => 'Ilmu Pengetahuan Alam', 'kode' => 'IPA'],
            ['nama' => 'Ilmu Pengetahuan Sosial', 'kode' => 'IPS'],
            ['nama' => 'Bahasa dan Budaya', 'kode' => 'BAHASA'],
            ['nama' => 'Ilmu Agama Islam', 'kode' => 'AGAMA'],
        ];

        $data = $this->faker->unique()->randomElement($jurusans);

        return [
            'nama_jurusan' => $data['nama'],
            'kode_jurusan' => $data['kode'],
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
