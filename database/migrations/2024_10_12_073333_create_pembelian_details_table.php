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
        Schema::create('pembelian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->constrained('pembelian')->onDelete('cascade'); // Foreign key ke tabel pembelian
            $table->foreignId('id_barang')->constrained('barang')->onDelete('cascade'); // Foreign key ke tabel barang
            $table->integer('jumlah_barang'); // Jumlah barang yang dibeli
            $table->decimal('harga_barang', 15, 2); // Harga barang per unit
            $table->decimal('harga_jual', 15, 2); // Harga jual per unit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_details');
    }
};