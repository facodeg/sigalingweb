<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('surat_praktek_satu', function (Blueprint $table) {
            $table->string('tmt')->nullable()->after('nip');
            $table->string('maksud')->nullable()->after('tmt');
        });
    }

    public function down(): void
    {
        Schema::table('surat_praktek_satu', function (Blueprint $table) {
            $table->dropColumn(['tmt', 'maksud']);
        });
    }
};