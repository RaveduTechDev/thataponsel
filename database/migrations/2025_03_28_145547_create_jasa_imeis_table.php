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
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->string('tipe');
            $table->string('imei')->unique();
            $table->decimal('biaya', 30, 0);
            $table->decimal('modal', 30, 0);
            $table->decimal('profit', 30, 0);
            $table->enum('status', ['proses', 'selesai']);
            $table->string('supplier');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
