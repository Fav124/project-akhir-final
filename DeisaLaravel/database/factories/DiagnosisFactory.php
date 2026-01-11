<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DiagnosisFactory extends Factory
{
    public function definition()
    {
        $diagnoses = [
            ['nama' => 'Influenza', 'kategori' => 'Ringan'],
            ['nama' => 'Gastritis', 'kategori' => 'Ringan'],
            ['nama' => 'Demam Berdarah', 'kategori' => 'Berat'],
            ['nama' => 'Typhus', 'kategori' => 'Berat'],
            ['nama' => 'Batuk Pilek', 'kategori' => 'Ringan'],
            ['nama' => 'Sakit Kepala', 'kategori' => 'Ringan'],
            ['nama' => 'Diare', 'kategori' => 'Sedang'],
        ];

        $data = $this->faker->randomElement($diagnoses);

        return [
            'nama_diagnosis' => $data['nama'],
            'kategori' => $data['kategori'],
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
