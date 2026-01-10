<?php

namespace Database\Factories;

use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class SantriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nis' => $this->faker->unique()->numerify('#####'),
            'nama_lengkap' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['laki-laki', 'perempuan']),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            // 'alamat' => $this->faker->address(), // Removed as column doesn't exist
            'status' => 'aktif',
            'foto' => null,
            'jurusan_id' => Jurusan::inRandomOrder()->first()->id ?? Jurusan::factory(),
            'kelas_id' => Kelas::inRandomOrder()->first()->id ?? Kelas::factory(),
            'asal_daerah' => $this->faker->city(),
            'status_kesehatan' => 'sehat',
            'nama_ayah' => $this->faker->name('male'),
            'nama_ibu' => $this->faker->name('female'),
            'nama_wali' => $this->faker->name(),
            'pekerjaan_wali' => $this->faker->jobTitle(),
            'phone_wali' => $this->faker->phoneNumber(),
            'alamat_wali' => $this->faker->address(),
        ];
    }
}
