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
        Schema::create('jasa_imeis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans');
            $table->enum('tipe', ['slow', 'fast']);
            $table->string('imei')->unique();
            $table->decimal('biaya', 30, 0);
            $table->decimal('dp_server', 30, 0);
            $table->decimal('modal', 30, 0);
            $table->decimal('sisa_server', 30, 0);
            $table->decimal('profit', 30, 0);
            $table->string('metode_pembayaran');
            $table->enum('status', ['proses', 'belum_lunas', 'selesai']);
            $table->string('supplier');
            $table->string('no_kontak_supplier')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal');
            $table->longText('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jasa_imeis');
    }
};
