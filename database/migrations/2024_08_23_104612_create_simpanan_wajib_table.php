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
        Schema::create('simpanan_wajib', function (Blueprint $table) {
            $table->id();
            $table->string('no_anggota'); // Kolom no_anggota
            $table->date('tgl_simpanan'); // Kolom tanggal simpanan
            $table->decimal('nominal', 15, 2); // Kolom nominal dengan presisi tinggi
            $table->string('status'); // Kolom status baru yang ditambahkan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanan_wajib');
    }
};
