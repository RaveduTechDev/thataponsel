<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_barang' => $this->faker->unique()->word,
            'nama_barang' => $this->faker->word,
            'merk' => $this->faker->word,
            'tipe' => $this->faker->word,
            'memori' => $this->faker->word,
            'warna' => $this->faker->word,
            'satuan' => $this->faker->randomElement(['unit', 'fullset']),
            'kategori' => $this->faker->word,
            'grade' => $this->faker->word,
            'keterangan' => $this->faker->word,
        ];
    }
}
