<?php

namespace Database\Factories;

use App\Models\Santri;
use Illuminate\Database\Eloquent\Factories\Factory;

class SantriSakitFactory extends Factory
{
    public function definition()
    {
        $status = $this->faker->randomElement(['Sakit', 'Pulang', 'Sembuh']);
        $tglMasuk = $this->faker->dateTimeBetween('-1 month', 'now');
        $tglSembuh = ($status === 'Sembuh') ? $this->faker->dateTimeBetween($tglMasuk, 'now') : null;

        return [
            'santri_id' => Santri::factory(),
            'tgl_masuk' => $tglMasuk,
            'tgl_sembuh' => $tglSembuh,
            'status' => $status,
            'jenis_perawatan' => $this->faker->randomElement(['UKS', 'Rumah Sakit', 'Pulang']),
            'gejala' => $this->faker->sentence(),
            'tindakan' => $this->faker->sentence(),
            'catatan' => $this->faker->optional()->sentence(),
            'tingkat_kondisi' => $this->faker->randomElement(['Ringan', 'Sedang', 'Berat']),
        ];
    }
}
