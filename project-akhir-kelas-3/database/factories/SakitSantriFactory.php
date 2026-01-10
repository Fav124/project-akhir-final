<?php

namespace Database\Factories;

use App\Models\Santri;
use App\Models\User;
use App\Models\Obat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class SakitSantriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-3 months', 'now');
        $statusRandom = $this->faker->randomElement(['sakit', 'sembuh', 'sehat']);

        $endDate = in_array($statusRandom, ['sembuh', 'sehat'])
            ? $this->faker->dateTimeBetween($startDate, Carbon::parse($startDate)->addDays(rand(1, 14)))
            : null;

        return [
            'santri_id' => Santri::inRandomOrder()->first()->id ?? Santri::factory(),
            'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id ?? User::factory(),
            'kelas_text' => 'Kelas ' . rand(10, 12),
            'tanggal_mulai_sakit' => $startDate,
            'tanggal_selesai_sakit' => $endDate,
            'diagnosis' => $this->faker->sentence(3),
            'gejala' => $this->faker->sentence(),
            'tindakan' => $this->faker->sentence(),
            'resep_obat' => $this->faker->words(3, true),
            'suhu_tubuh' => $this->faker->randomFloat(1, 36, 40),
            'status' => $statusRandom,
            'tingkat_kondisi' => $this->faker->randomElement(['ringan', 'sedang', 'berat']),
            'catatan' => $this->faker->sentence(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function ($sakit) {
            // Attach 1-3 random obats
            $obats = Obat::inRandomOrder()->limit(rand(1, 3))->get();
            foreach ($obats as $obat) {
                $sakit->obats()->attach($obat->id, [
                    'jumlah' => rand(1, 3),
                    'dosis' => '3x1',
                    'tujuan' => 'Penyembuhan',
                    'keterangan' => 'Diminum sesudah makan'
                ]);
            }
        });
    }
}
