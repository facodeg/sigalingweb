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
            $table->string('status_surat')->nullable()->after('nama_surat');
        });
    }

    public function down()
    {
        Schema::table('surat_praktek_satu', function (Blueprint $table) {
            $table->dropColumn('status_surat');
        });
    }
};
