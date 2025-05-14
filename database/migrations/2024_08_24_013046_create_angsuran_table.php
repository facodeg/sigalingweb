<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAngsuranTable extends Migration
{
    public function up()
    {
        Schema::create('angsuran', function (Blueprint $table) {
            $table->id();
            $table->string('no_angsuran');
            $table->string('no_pinjaman');
            $table->date('tgl_angsuran');
            $table->decimal('nominal', 12, 2);
            $table->integer('angsuranke');
            $table->enum('status', ['lunas', 'belum']);
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('angsuran');
    }
}
