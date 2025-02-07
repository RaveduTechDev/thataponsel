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
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->enum('satuan', ['unit', 'fullset']);
            $table->string('kategori');
            $table->string('grade');
            $table->string('imei_1');
            $table->string('imei_2');
            $table->integer('jumlah_stok');
            $table->integer('modal');
            $table->integer('harga_jual');
            $table->integer('invoice');
            $table->integer('supplier');
            $table->string('no_kontak_supplier');
            $table->date('tanggal');
            $table->string('keterangan');
            $table->string('foto');
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
