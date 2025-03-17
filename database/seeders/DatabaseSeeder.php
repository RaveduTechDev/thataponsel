<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Stock;
use App\Models\TokoCabang;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        TokoCabang::factory(1)->create();
        Barang::factory(1)->create();
        Stock::factory(1)->create();
        Pelanggan::factory(1)->create();
        Agent::factory(1)->create();
        Penjualan::factory(1)->create();
    }
}
