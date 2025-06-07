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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs');
            $table->string('imei_1')->nullable();
            $table->string('imei_2')->nullable();
            $table->integer('jumlah_stok');
            $table->decimal('modal', 25, 0);
            $table->decimal('harga_jual', 25, 0);
            $table->string('invoice')->nullable();
            $table->string('supplier');
            $table->string('no_kontak_supplier')->nullable();
            $table->date('tanggal');
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
        Schema::dropIfExists('stocks');
    }
};
