<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('smart_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_alternatif')->nullable(); // misal: A1, A2
            $table->string('nama');
            $table->string('kategori_nama')->nullable(); // Coffee, Tea, Mocktail, Chocolate, Makanan, Snack
            $table->double('kategori')->default(1); // Skala Likert C1 (Benefit)
            $table->double('harga_asli')->nullable(); // Rp asli, misal 32000
            $table->double('harga')->default(1); // Skala Likert C2 (Cost)
            $table->integer('penjualan_asli')->nullable(); // Qty asli, misal 518
            $table->double('penjualan')->default(1); // Skala Likert C3 (Benefit)
            $table->string('penyajian_asli')->nullable(); // Menit asli, misal "6 Menit"
            $table->double('estimasi')->default(1); // Skala Likert C4 / Waktu Penyajian (Benefit)
            $table->double('laba_penjualan')->nullable(); // misal 16576000
            $table->string('tahun', 10)->default('2025');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('smart_penjualan');
    }
};

