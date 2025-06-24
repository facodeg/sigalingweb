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
        Schema::table('s_t_r_s', function (Blueprint $table) {
            $table->string('file')->nullable();
        });

        Schema::table('s_i_p_s', function (Blueprint $table) {
            $table->string('file')->nullable();
        });
    }
};
