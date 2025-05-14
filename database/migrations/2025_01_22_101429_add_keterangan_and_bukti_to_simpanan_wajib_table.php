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
        Schema::table('simpanan_wajib', function (Blueprint $table) {
            $table->string('keterangan')->nullable(); // Tambahkan kolom keterangan
            $table->string('bukti')->nullable(); // Tambahkan kolom bukti
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('simpanan_wajib', function (Blueprint $table) {
            $table->dropColumn(['keterangan', 'bukti']); // Hapus kolom saat rollback
        });
    }
};