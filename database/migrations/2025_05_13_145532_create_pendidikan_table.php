<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pendidikan', function (Blueprint $table) {
            $table->id('id_pendidikan');
            $table->string('nama');
            $table->string('nip')->unique();
            $table->enum('jk', ['L', 'P']); // Jenis kelamin
            $table->string('jp'); // Jenis Pekerjaan?
            $table->string('pendidikan');
            $table->string('jb'); // Jenis bidang/jabatan?
            $table->string('jabatan');
            $table->string('status_pg'); // Status pegawai?
            $table->string('nama_sekolah');
            $table->year('Tahun'); // Gunakan year jika hanya tahun
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendidikan');
    }
};