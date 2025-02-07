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
            'kode_barang' => fake()->unique()->word(),
            'nama_barang' => fake()->word(),
            'satuan' => fake()->randomElement(['unit', 'fullset']),
            'kategori' => fake()->word(),
            'grade' => fake()->word(),
            'imei_1' => fake()->word(),
            'imei_2' => fake()->word(),
            'jumlah_stok' => fake()->randomNumber(),
            'modal' => fake()->randomNumber(),
            'harga_jual' => fake()->randomNumber(),
            'invoice' => fake()->randomNumber(),
            'supplier' => fake()->randomNumber(),
            'no_kontak_supplier' => fake()->word(),
            'tanggal' => fake()->date(),
            'keterangan' => fake()->word(),
            'foto' => fake()->word(),
        ];
    }
}
