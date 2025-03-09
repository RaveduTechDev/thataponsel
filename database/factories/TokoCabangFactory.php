<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TokoCabang>
 */
class TokoCabangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_toko_cabang' => $this->faker->name(),
            'penanggung_jawab_toko' => $this->faker->name(),
            'alamat_toko' => $this->faker->address(),
        ];
    }
}
