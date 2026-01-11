<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SantriFactory extends Factory
{
    public function definition()
    {
        $fullName = $this->faker->name();
        return [
            'nis' => $this->faker->unique()->numerify('##########'),
            'nama_lengkap' => $fullName,
            'nama' => explode(' ', $fullName)[0],
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'kelas_id' => Kelas::inRandomOrder()->first()?->id ?? Kelas::factory(),
            'jurusan_id' => function (array $attributes) {
                return Kelas::find($attributes['kelas_id'])?->jurusan_id ?? Jurusan::inRandomOrder()->first()?->id ?? Jurusan::factory();
            },
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-15 years'),
            'alamat' => $this->faker->address(),
            'golongan_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'status_kesehatan' => 'Sehat',
        ];
    }
}
