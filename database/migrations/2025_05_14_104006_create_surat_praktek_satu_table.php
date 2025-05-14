<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_praktek_satu', function (Blueprint $table) {
            $table->id();

            // Penandatangan
            $table->string('penanda_tangan_nama');
            $table->string('penanda_tangan_nip')->nullable();
            $table->string('penanda_tangan_pangkat')->nullable();
            $table->string('penanda_tangan_jabatan')->nullable();

            // Data Praktikan
            $table->string('praktikan_nama');
            $table->string('alamat_praktek')->nullable();
            $table->string('profesi')->nullable();

            // Jadwal Praktek
            $table->string('hari_praktek')->default('Senin s.d Minggu');
            $table->decimal('jam_efektif_mingguan', 4, 1)->default(37.5);

            // Shift
            $table->string('shift_pagi')->default('07.30 s.d 14.30 WIB');
            $table->string('shift_sore')->default('14.00 s.d 21.00 WIB');
            $table->string('shift_malam')->default('21.00 s.d 07.30 WIB');

            // Metadata
            $table->string('tempat_dikeluarkan')->default('Leuwiliang');
            $table->date('tanggal_dikeluarkan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_praktek_satu');
    }
};

