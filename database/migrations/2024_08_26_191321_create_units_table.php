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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the unit
            $table->string('slug_name')->unique(); // Slug for the name, must be unique
            $table->text('details')->nullable(); // Details about the unit, can be null
            $table->boolean('status')->default(1); // Status of the unit, default is 1 (active)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
