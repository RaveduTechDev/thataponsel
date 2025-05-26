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

        // owner
        User::factory()->create([
            'name' => 'Owner',
            'username' => 'owner',
            'email' => 'owner@test.com',
        ])->assignRole('owner');

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@test.com',
        ])->assignRole('admin');

        User::factory()->create([
            'name' => 'Agent',
            'username' => 'agent',
            'email' => 'agent@test.com',
        ])->assignRole('agen');

        Barang::factory()->create([
            'kode_barang' => 'BRG-001',
            'nama_barang' => 'Barang Test',
            'merk' => 'Merk Test',
            'tipe' => 'Tipe Test',
            'memori' => 'Memori Test',
            'warna' => 'Warna Test',
            'satuan' => 'unit',
            'kategori' => 'Kategori Test',
            'grade' => 'Grade A',
            'keterangan' => 'Keterangan Test',
        ]);
        TokoCabang::factory()->create([
            'nama_toko_cabang' => 'Toko Cabang 1',
            'penanggung_jawab_toko' => 'Penanggung Jawab Toko 1',
            'alamat_toko' => 'Jl. Raya No. 1',
        ]);

        Stock::factory()->create([
            'barang_id' => 1,
            'imei_1' => '123456789012345',
            'imei_2' => '123456789012346',
            'jumlah_stok' => 10,
            'modal' => 10000000,
            'harga_jual' => 20000000,
            'invoice' => 'INV-230316-0001',
            'supplier' => 'Supplier Test',
            'no_kontak_supplier' => '+6281234567890',
            'tanggal' => now(),
            'garansi' => 'ya',
        ]);

        Pelanggan::factory()->create([
            'nama_pelanggan' => 'Ravedu Test Pelanggan',
            'nomor_wa' => '+6281234567890',
        ]);

        Penjualan::factory()->create([
            'invoice' => 'INV-230316-0001',
            'stock_id' => 1,
            'pelanggan_id' => 1,
            'toko_cabang_id' => 1,
            'user_id' => 4,
            'subtotal' => 20000000,
            'diskon' => 0,
            'qty' => 1,
            'total_bayar' => 20000000,
            'tanggal_transaksi' => now(),
            'metode_pembayaran' => 'tunai',
            'status' => 'selesai',
        ]);

        JasaImei::factory()->create([
            'pelanggan_id' => 1,
            'tipe' => 'Jasa Test',
            'imei' => '123456789012345',
            'biaya' => 1000000,
            'modal' => 500000,
            'profit' => 500000,
            'status' => 'proses',
            'supplier' => 'Supplier Test',
            'user_id' => 4,
        ]);
    }
}
