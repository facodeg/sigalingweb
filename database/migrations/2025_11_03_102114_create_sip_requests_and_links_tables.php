<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ---- Tabel utama: data pengajuan SIP ----
        Schema::create('sip_requests', function (Blueprint $table) {
            $table->string('id', 24)->primary(); // format: SIPREQ-YYYYMMDD-####

            $table->string('karyawan_nip', 30)->nullable();
            $table->string('nama', 120);
            $table->string('profesi', 80);
            $table->string('tempat_lahir', 80)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nik', 32)->nullable();
            $table->string('no_str', 64)->nullable();
            $table->date('str_berlaku_sampai')->nullable();
            $table->text('alamat_rumah')->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->string('lulusan', 120)->nullable();
            $table->string('tahun_lulus', 4)->nullable();

            $table->string('status', 20)->default('DRAFT'); // DRAFT / PENGAJUAN / TERVERIFIKASI
            $table->text('file_permohonan_signed')->nullable();

            $table->timestamps();
        });

        // ---- Tabel link dinamis untuk WA ----
        Schema::create('sip_links', function (Blueprint $table) {
            $table->id();
            $table->string('sip_id', 24);
            $table->string('token', 64)->unique();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('used')->default(false);
            $table->timestamps();

            $table->foreign('sip_id')
                  ->references('id')
                  ->on('sip_requests')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sip_links');
        Schema::dropIfExists('sip_requests');
    }
};
