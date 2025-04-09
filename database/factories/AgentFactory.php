<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_agen' => $this->faker->name,
            'username' => $this->faker->unique()->regexify('[a-zA-Z0-9_]+'),
            'nomor_wa' => $this->faker->phoneNumber,
            'toko_cabang_id' => \App\Models\TokoCabang::factory(),
            'jumlah_transaksi' => $this->faker->randomNumber(5),
        ];
    }
}
