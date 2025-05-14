<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            //address
            $table->string('address');
            //latitude
            $table->string('latitude');
            //longitude
            $table->string('longitude');
            //radius_km
            $table->integer('radius_km');
            //time_in (format 24 hours)
            $table->time('time_in');
            //time_out (format 24 hours)
            $table->time('time_out');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
