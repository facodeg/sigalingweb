<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSisaPinjamanToAngsuranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('angsuran', function (Blueprint $table) {
            $table->decimal('sisa_pinjaman', 15, 2)->nullable()->after('angsuranke');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('angsuran', function (Blueprint $table) {
            $table->dropColumn('sisa_pinjaman');
        });
    }
}
