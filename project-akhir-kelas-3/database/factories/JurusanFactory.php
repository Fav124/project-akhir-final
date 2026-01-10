<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->unique()->randomElement([
                'Teknik Informatika', 
                'Sistem Informasi', 
                'Manajemen Bisnis', 
                'Keuangan Syariah', 
                'Pendidikan Agama Islam', 
                'Hukum Keluarga Islam'
            ]),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
