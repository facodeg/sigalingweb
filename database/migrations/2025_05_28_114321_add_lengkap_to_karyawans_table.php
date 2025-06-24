<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->string('jenjang_pendidikan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->text('alamat_ktp')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('agama')->nullable();
            $table->string('ruangan')->nullable();
            $table->enum('status_nakes', ['NAKES', 'NON'])->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropColumn(['jenjang_pendidikan', 'pendidikan', 'alamat_ktp', 'desa', 'kecamatan', 'kabupaten', 'agama', 'ruangan', 'status_nakes']);
        });
    }
};