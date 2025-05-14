<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('limitpinjaman', function (Blueprint $table) {
            $table->id(); // Primary key, auto-increment
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key ke tabel users (null jika status 'semua')
            $table->decimal('limit', 15, 2); // Kolom untuk menyimpan limit pinjaman
            $table->enum('status', ['semua', 'perorangan'])->default('semua'); // Kolom status
            $table->timestamps(); // Kolom created_at dan updated_at

            // Tambahkan foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('limitpinjaman');
    }
};