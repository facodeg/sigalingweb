<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';

    // Hanya isi kolom yang bisa diisi user (exclude: id, created_at, updated_at)
    protected $fillable = ['nama', 'nip_nrp_nipppk_nipb', 'status_kepegawaian', 'tempat_lahir', 'tgl_lahir', 'umur_tahun', 'umur_bulan', 'jk', 'npwp', 'nik', 'status', 'jabatan_terakhir', 'tmt_jabatan', 'tmt_kerja_di_rsud', 'lama_kerja_tahun', 'lama_kerja_bulan', 'gol', 'pangkat_gol', 'tmt_gol', 'no_sk', 'tgl_sk', 'keterangan', 'jenjang_pendidikan', 'pendidikan_terakhir', 'alamat_ktp', 'desa', 'kecamatan', 'kabupaten', 'agama', 'ruangan', 'status_nakes'];

    // Laravel otomatis kelola created_at dan updated_at
    public $timestamps = true;

    public function str()
    {
        return $this->hasMany(Str::class);
    }

    public function sip()
    {
        return $this->hasMany(Sip::class);
    }
}
