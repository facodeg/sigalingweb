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
        Schema::table('stok_log', function (Blueprint $table) {
            $table->decimal('harga_barang', 10, 2)->nullable()->after('jumlah_perubahan');
            $table->integer('stok_sebelumnya')->nullable()->after('harga_barang');
            $table->integer('stok_sesudah')->nullable()->after('stok_sebelumnya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_log', function (Blueprint $table) {
            $table->dropColumn(['harga_barang', 'stok_sebelumnya', 'stok_sesudah']);
        });
    }
};