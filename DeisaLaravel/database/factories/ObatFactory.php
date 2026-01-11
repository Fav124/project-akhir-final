<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ObatFactory extends Factory
{
    public function definition()
    {
        return [
            'nama_obat' => $this->faker->randomElement(['Paracetamol', 'Amoxicillin', 'Antacid', 'Bodrex', 'Mixagrip', 'CTM', 'Betadine']),
            'kode_obat' => $this->faker->unique()->numerify('OBT-####'),
            'kategori' => $this->faker->randomElement(['Tablet', 'Sirup', 'Salep', 'Kapsul']),
            'deskripsi' => $this->faker->sentence(),
            'stok' => $this->faker->numberBetween(5, 100),
            'stok_minimum' => 10,
            'satuan' => $this->faker->randomElement(['Strip', 'Botol', 'Tube', 'Pcs']),
            'harga_satuan' => $this->faker->numberBetween(1000, 50000),
            'tanggal_kadaluarsa' => $this->faker->dateTimeBetween('+1 year', '+3 years'),
        ];
    }
}
