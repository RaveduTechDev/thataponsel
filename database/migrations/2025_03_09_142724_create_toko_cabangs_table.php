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
        Schema::create('toko_cabangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko_cabang');
            $table->string('penanggung_jawab_toko');
            $table->string('alamat_toko');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toko_cabangs');
    }
};
