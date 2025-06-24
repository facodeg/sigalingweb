<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';

    protected $fillable = ['nama', 'nip_nrp_nipppk_nipb', 'status_kepegawaian', 'tempat_lahir', 'tgl_lahir', 'umur_tahun', 'umur_bulan', 'jk', 'npwp', 'nik', 'status', 'jabatan_terakhir', 'tmt_jabatan', 'tmt_kerja_di_rsud', 'lama_kerja_tahun', 'lama_kerja_bulan', 'gol', 'tmt_gol', 'no_sk', 'tgl_sk', 'keterangan', 'jenjang_pendidikan', 'pendidikan_terakhir', 'alamat_ktp', 'desa', 'kecamatan', 'kabupaten', 'agama', 'ruangan', 'status_nakes'];

    public function str()
    {
        return $this->hasMany(Str::class);
    }

    public function sip()
    {
        return $this->hasMany(Sip::class);
    }
}