<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stok_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id'); // Relasi ke tabel barang
            $table->integer('jumlah_perubahan'); // Perubahan stok (bisa positif atau negatif)
            $table->enum('tipe', ['pembelian', 'penjualan', 'penyesuaian']); // Tipe transaksi
            $table->date('tanggal_perubahan'); // Tanggal perubahan stok
            $table->unsignedBigInteger('transaksi_id')->nullable(); // Relasi opsional ke tabel transaksi (pembelian/penjualan)
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_log');
    }
};