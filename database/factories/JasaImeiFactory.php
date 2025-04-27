<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JasaImei>
 */
class JasaImeiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pelanggan_id' => \App\Models\Pelanggan::factory(),
            'tipe' => $this->faker->word,
            'imei' => $this->faker->unique()->word,
            'biaya' => $this->faker->randomFloat(2, 10000, 100000),
            'modal' => $this->faker->randomFloat(2, 10000, 100000),
            'profit' => $this->faker->randomFloat(2, 10000, 100000),
            'status' => $this->faker->randomElement(['proses', 'selesai']),
            'supplier' => $this->faker->word,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
