<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkkRequest extends Model
{
    use HasFactory;

    protected $table = 'skk_requests';
    // PK string, bukan auto increment
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'karyawan_nip', 'nama', 'request_type', 'keperluan', 'status','nomor_surat'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke tabel karyawans
     * SkkRequest milik satu Karyawan
     */
    public function karyawan()
    {
        // local key: karyawan_nip (di skk_requests)
        // owner key: nip_nrp_nipppk_nipb (di karyawans) — sesuai strukturmu
        return $this->belongsTo(\App\Models\Karyawan::class, 'karyawan_nip', 'nip_nrp_nipppk_nipb')->withDefault([
            'jabatan_terakhir' => null,
            'ruangan' => null,
            'tmt_kerja_di_rsud' => null,
        ]);
    }

    /**
     * Akses cepat jabatan terakhir dari tabel karyawans
     */
    public function getJabatanTerakhirAttribute()
    {
        return $this->karyawan->jabatan_terakhir ?? '-';
    }
}
