<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('alamat_domisili', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->char('province_code', 2); // kode provinsi
            $table->char('city_code', 4); // kode kabupaten/kota
            $table->char('district_code', 7); // kode kecamatan
            $table->char('village_code', 10); // kode desa/kelurahan
            $table->text('alamat_lengkap')->nullable(); // alamat jalan, RT/RW
            $table->timestamps();

            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat_domisili');
    }
};
