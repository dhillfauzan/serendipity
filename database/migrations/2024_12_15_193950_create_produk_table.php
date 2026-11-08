<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('katagori_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('status');
            $table->string('nama_produk');
            $table->text('detail');
            $table->double('harga');
            $table->integer('stok');
            $table->float('berat');
            $table->string('foto')->nullable(); // Kolom foto nullable
            $table->timestamps();
            $table->foreign('katagori_id')->references('id')->on('katagori');
            $table->foreign('user_id')->references('id')->on('user'); // pastikan 'users' sesuai dengan nama tabel user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
