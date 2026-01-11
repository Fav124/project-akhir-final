<?php

namespace Database\Factories;

use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    public function definition()
    {
        return [
            'nama_kelas' => $this->faker->randomElement(['10', '11', '12']) . $this->faker->randomElement(['A', 'B', 'C']),
            'jurusan_id' => Jurusan::inRandomOrder()->first()?->id ?? Jurusan::factory(),
            'tahun_ajaran' => '2023/2024',
        ];
    }
}
