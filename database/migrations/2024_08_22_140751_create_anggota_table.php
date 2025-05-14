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
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->string('no_anggota')->unique();
            $table->string('nama');
            $table->string('nip_nipb_nrptt')->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('umur');
            $table->string('nik')->unique();
            $table->text('alamat');
            $table->string('unit_kerja');
            $table->string('status_kepegawaian');
            $table->string('status_pernikahan');
            $table->decimal('simpanan_pokok', 15, 2)->default(200000);
            $table->decimal('simpanan_wajib', 15, 2)->nullable();
            $table->string('no_hp');
            $table->string('upload_ktp')->nullable();
            $table->string('upload_foto_diri')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
