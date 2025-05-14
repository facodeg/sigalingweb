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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembelian')->unique();
            $table->date('tanggal_pembelian');
            $table->foreignId('id_pemasok')->constrained('pemasok')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_barang')->constrained('barang')->onDelete('cascade');
            $table->integer('jumlah_barang');
            $table->decimal('harga_barang', 15, 2);
            $table->decimal('harga_jual', 15, 2);
            $table->decimal('pajak_barang', 15, 2);
            $table->decimal('total_harga', 15, 2);
            $table->decimal('pajak', 15, 2);
            $table->enum('status', ['pending', 'completed', 'canceled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
