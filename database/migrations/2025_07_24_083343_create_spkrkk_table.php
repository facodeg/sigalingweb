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
        Schema::create('spkrkk', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel karyawans (gunakan karyawan_id atau NIP)
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');

            // Kolom khusus SPKRKK
            $table->string('ruang_klinis');
            $table->string('kualifikasi');
            $table->date('masa_berlaku_dari');
            $table->date('masa_berlaku_sampai');

            // Multiple file disimpan sebagai JSON array
            $table->json('file_paths')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spkrkk');
    }
};