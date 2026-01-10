<?php

namespace Database\Factories;

use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_kelas' => $this->faker->unique()->regexify('[X|XI|XII]{1,3}-[A-Z]{2,3}-[1-3]'), // Example: XI-RPL-1
            'jurusan_id' => Jurusan::inRandomOrder()->first()->id ?? Jurusan::factory(),
        ];
    }
}
