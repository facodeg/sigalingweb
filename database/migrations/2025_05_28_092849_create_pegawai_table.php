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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip_nrp_nipppk_nipb')->unique();
            $table->enum('status_kepegawaian', ['PNS', 'PPPK', 'BLUD', 'PTT']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->integer('umur_tahun')->nullable();
            $table->integer('umur_bulan')->nullable();
            $table->enum('jk', ['L', 'P']);
            $table->string('npwp')->nullable();
            $table->string('nik')->nullable();
            $table->string('status')->nullable();
            $table->string('jabatan')->nullable();
            $table->date('tmt_jabatan')->nullable();
            $table->date('tmt_kerja_di_rsud')->nullable(); // khusus PTT
            $table->integer('lama_kerja_tahun')->nullable();
            $table->integer('lama_kerja_bulan')->nullable();
            $table->string('gol')->nullable(); // PNS/PTT
            $table->date('tmt_gol')->nullable();
            $table->string('no_sk')->nullable(); // BLUD/PTT
            $table->date('tgl_sk')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};