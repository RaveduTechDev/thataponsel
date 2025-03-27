<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'barang_id' => \App\Models\Barang::factory(),
            'imei_1' => fake()->word(),
            'imei_2' => fake()->word(),
            'jumlah_stok' => fake()->randomNumber(),
            'modal' => fake()->randomNumber(),
            'harga_jual' => fake()->randomNumber(),
            'invoice' => fake()->randomNumber(),
            'supplier' => fake()->randomNumber(),
            'no_kontak_supplier' => fake()->word(),
            'tanggal' => fake()->date(),
            'garansi' => fake()->randomElement(['tidak', 'ya']),
        ];
    }
}
