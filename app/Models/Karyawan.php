<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';

    protected $fillable = ['nama', 'nip_nrp_nipppk_nipb', 'status_kepegawaian', 'tempat_lahir', 'tgl_lahir', 'umur_tahun', 'umur_bulan', 'jk', 'npwp', 'nik', 'status', 'jabatan_terakhir', 'tmt_jabatan', 'tmt_kerja_di_rsud', 'lama_kerja_tahun', 'lama_kerja_bulan', 'gol', 'pangkat_gol', 'tmt_gol', 'no_sk', 'tgl_sk', 'keterangan', 'jenjang_pendidikan', 'pendidikan_terakhir', 'alamat_ktp', 'desa', 'kecamatan', 'kabupaten', 'agama', 'ruangan', 'status_nakes'];

    public $timestamps = true;

    /**
     * Relasi ke STR (Satu ke Banyak)
     */
    public function STR()
    {
        return $this->hasMany(STR::class);
    }

    /**
     * Relasi ke SIP (Satu ke Banyak)
     */
    public function SIP()
    {
        return $this->hasMany(SIP::class);
    }

    /**
     * Relasi ke Pendidikan (Satu ke Banyak)
     */
    public function pendidikan()
    {
        return $this->hasMany(PendidikanTb::class, 'pegawai_id', 'id');
    }

    public function alamat()
    {
        return $this->hasMany(AlamatDomisili::class, 'karyawan_id');
    }

    public function spkrkk()
    {
        return $this->hasMany(Spkrkk::class);
    }
    public function dataKeluarga()
    {
        return $this->hasMany(\App\Models\DataKeluarga::class, 'karyawan_id');
    }

    public function sipRequests()
    {
        return $this->hasMany(\App\Models\SipRequest::class, 'karyawan_nip', 'nip_nrp_nipppk_nipb');
    }
}