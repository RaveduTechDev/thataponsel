<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->foreignId('barang_id')->constrained('barangs');
            $table->foreignId('pelanggan_id')->constrained('pelanggans');
            $table->foreignId('toko_cabang_id')->constrained('toko_cabangs');
            $table->foreignId('agent_id')->constrained('agents');
            $table->decimal('subtotal', 25, 0);
            $table->decimal('diskon', 25, 0);
            $table->string('total_bayar');
            $table->date('tanggal_transaksi');
            $table->enum('status', ['proses', 'selesai', 'batal']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
