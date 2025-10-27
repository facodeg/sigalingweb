<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuratNumberGenerator
{
    protected $connectionName = 'external'; // koneksi ke DB eksternal
    protected $table = 'tb_surat_pg';
    protected $baseNomor = '400.7.22.1';
    protected $suffix = 'RSUDL';

    /**
     * Buat surat otomatis berdasarkan data terbaru di DB eksternal.
     */
    public function createSurat(string $nama, string $divisi = 'kepegawaian')
    {
        $today = Carbon::today();
        $tahun = $today->year;

        return DB::connection($this->connectionName)->transaction(function () use ($tahun, $today, $nama, $divisi) {
            // Ambil nosurata terbesar di tahun berjalan
            $maxNo = DB::connection($this->connectionName)->table($this->table)->whereYear('TGL_SURAT', $tahun)->lockForUpdate()->max('nosurata');

            $nextNo = ($maxNo ?? 0) + 1;

            // Ambil KODE_SURAT terakhir (primary key)
            $maxKode = DB::connection($this->connectionName)->table($this->table)->lockForUpdate()->max('KODE_SURAT');

            $nextKode = ($maxKode ?? 0) + 1;

            // Buat format nomor surat
            $nomor = $this->baseNomor;
            $noSurat = "{$nomor}/{$nextNo}-{$this->suffix}";

            // Insert record baru ke database eksternal
            DB::connection($this->connectionName)
                ->table($this->table)
                ->insert([
                    'KODE_SURAT' => $nextKode,
                    'NOMOR' => $nomor,
                    'NO_SURAT' => $noSurat,
                    'TGL_SURAT' => $today->toDateString(),
                    'TGL_BUAT' => $today->toDateString(),
                    'PERIHAL' => 'Surat Keterangan',
                    'KETERANGAN' => $nama,
                    'DIVISI' => $divisi,
                    'NO' => null,
                    'nosu' => null,
                    'nosurata' => $nextNo,
                ]);

            return [
                'kode_surat' => $nextKode,
                'no_surat' => $noSurat,
                'nosurata' => $nextNo,
                'tahun' => $tahun,
            ];
        });
    }
}