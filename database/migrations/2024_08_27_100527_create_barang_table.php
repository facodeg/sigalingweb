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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('Kode_produk')->unique();
            $table->string('Nama');
            $table->foreignId('id_kategori')->constrained('kategori')->onDelete('cascade');
            $table->foreignId('id_pemasok')->constrained('pemasok')->onDelete('cascade');
            $table->foreignId('id_merek')->constrained('merek')->onDelete('cascade');
            $table->foreignId('id_units')->constrained('units')->onDelete('cascade');
            $table->decimal('Harga', 15, 2);
            $table->integer('Jml_Peringatan');
            $table->text('Deskripsi')->nullable();
            $table->enum('Status', ['1', '0'])->default('1');
            $table->string('Gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
