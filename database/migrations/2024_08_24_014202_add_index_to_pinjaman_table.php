<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToPinjamanTable extends Migration
{
    public function up()
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            // Menambahkan index ke kolom no_pinjaman
            $table->index('no_pinjaman');
        });
    }

    public function down()
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            // Menghapus index dari kolom no_pinjaman
            $table->dropIndex(['no_pinjaman']);
        });
    }
}

