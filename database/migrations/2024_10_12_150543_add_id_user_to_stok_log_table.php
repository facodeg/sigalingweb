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
        Schema::table('stok_log', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->after('transaksi_id')->nullable(); // Tambahkan kolom id_user
        });
    }

    public function down()
    {
        Schema::table('stok_log', function (Blueprint $table) {
            $table->dropColumn('id_user'); // Hapus kolom id_user saat rollback
        });
    }
};