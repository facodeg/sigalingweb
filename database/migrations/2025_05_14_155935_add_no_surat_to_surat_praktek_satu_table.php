<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('surat_praktek_satu', function (Blueprint $table) {
            $table->string('no_surat')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('surat_praktek_satu', function (Blueprint $table) {
            $table->dropColumn('no_surat');
        });
    }
};