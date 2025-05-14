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
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->string('no_pinjaman'); 
            $table->string('no_anggota'); // Nomor anggota, bisa juga diubah ke tipe data sesuai kebutuhan
            $table->date('tgl_pinjaman'); // Tanggal pinjaman
            $table->decimal('nominal', 15, 2); // Nominal pinjaman
            $table->integer('tenor'); // Tenor dalam bulan
            $table->decimal('bayar_perbulan', 15, 2); // Bayaran per bulan
            $table->date('tgl_selesai'); // Tanggal selesai pinjaman
            $table->decimal('biaya_admin', 15, 2); // Biaya administrasi
            $table->string('alasan_pinjam'); // Alasan peminjaman
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
