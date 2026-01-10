<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ObatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $namaObat = $this->faker->randomElement([
            'Paracetamol', 'Amoxicillin', 'Antangin', 'Betadine', 'Promag', 
            'Vitamin C', 'Antibiotik Salep', 'Minyak Kayu Putih', 'Oralit', 
            'Bodrex', 'Panadol', 'Insto', 'Komix', 'Decolgen', 'Enervon-C'
        ]);

        return [
            'nama_obat' => $namaObat . ' ' . $this->faker->numerify('##mg'),
            'deskripsi' => $this->faker->sentence(),
            'stok' => $this->faker->numberBetween(10, 200),
            'satuan' => $this->faker->randomElement(['Tablet', 'Botol', 'Strip', 'Tube', 'Sachet']),
            'stok_minimum' => $this->faker->numberBetween(5, 20),
            'harga_satuan' => $this->faker->numberBetween(1000, 50000),
            'tanggal_kadaluarsa' => $this->faker->dateTimeBetween('now', '+2 years'),
            'foto' => null,
        ];
    }
}
