<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Barang;
use App\Models\JasaImei;
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
        $this->call(RolePermissionSeeder::class);

        User::factory()->create([
            'name' => 'Ravedu Technology',
            'username' => 'ravtech',
            'email' => 'developer@test.com',
        ])->assignRole('super_admin');

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
        ])->assignRole('admin');

        User::factory()->create([
            'name' => 'Agent',
            'email' => 'agent@test.com',
        ])->assignRole('agent');

        Barang::factory(1)->create();
        TokoCabang::factory(1)->create();
        Stock::factory(1)->create();
        Pelanggan::factory(1)->create();
        Agent::factory(1)->create();
        Penjualan::factory(1)->create();
        JasaImei::factory(3)->create();
    }
}
