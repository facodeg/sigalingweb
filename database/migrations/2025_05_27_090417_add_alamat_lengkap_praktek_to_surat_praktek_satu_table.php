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
        Schema::table('surat_praktek_satu', function (Blueprint $table) {
            $table->string('alamat_lengkap_praktek')->nullable();
        });
    }

    public function down()
    {
        Schema::table('surat_praktek_satu', function (Blueprint $table) {
            $table->dropColumn('alamat_lengkap_praktek');
        });
    }
};