<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penjualan>
 */
class PenjualanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice' => $this->faker->unique()->numerify('INV-#####'),
            'barang_id' => \App\Models\Barang::factory(),
            'pelanggan_id' => \App\Models\Pelanggan::factory(),
            'toko_cabang_id' => \App\Models\TokoCabang::factory(),
            'agent_id' => \App\Models\Agent::factory(),
            'subtotal' => $this->faker->randomNumber(),
            'diskon' => $this->faker->numberBetween(0, 100),
            'total_bayar' => $this->faker->randomNumber(),
            'tanggal_transaksi' => $this->faker->date(),
            'status' => $this->faker->randomElement(['proses', 'selesai', 'batal']),
        ];
    }
}
