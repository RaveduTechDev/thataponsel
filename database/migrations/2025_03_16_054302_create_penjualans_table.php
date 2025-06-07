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
            $table->foreignId('stock_id')->constrained('stocks');
            $table->foreignId('pelanggan_id')->constrained('pelanggans');
            $table->foreignId('toko_cabang_id')->constrained('toko_cabangs');
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('subtotal', 25, 0);
            $table->decimal('diskon', 25, 0);
            $table->integer('qty');
            $table->string('total_bayar');
            $table->date('tanggal_transaksi');
            $table->string('metode_pembayaran');
            $table->enum('status', ['proses', 'selesai']);
            $table->longText('keterangan')->nullable();
            $table->enum('garansi', ['tidak', 'ya']);
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
