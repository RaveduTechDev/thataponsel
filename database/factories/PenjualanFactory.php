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
            'stock_id' => \App\Models\Stock::factory(),
            'pelanggan_id' => \App\Models\Pelanggan::factory(),
            'toko_cabang_id' => \App\Models\TokoCabang::factory(),
            'user_id' => \App\Models\User::factory(),
            'qty' => $this->faker->numberBetween(1, 100),
            'subtotal' => $this->faker->randomFloat(2, 100, 10000000),
            'diskon' => $this->faker->numberBetween(0, 100),
            'total_bayar' => $this->faker->randomFloat(2, 100, 10000000),
            'metode_pembayaran' => $this->faker->randomElement(['tunai', 'transfer', 'qris', 'e-wallet']),
            'tanggal_transaksi' => $this->faker->date(),
            'status' => $this->faker->randomElement(['proses', 'selesai']),
        ];
    }
}
