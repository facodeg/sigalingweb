<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    // protected $fillable = ['no_anggota', 'nama', 'nip_nipb_nrptt', 'tempat_lahir', 'tanggal_lahir', 'umur', 'jk', 'nik', 'alamat', 'unit_kerja', 'status_kepegawaian', 'status_pernikahan', 'simpanan_pokok', 'simpanan_wajib', 'no_hp', 'upload_ktp', 'upload_foto_diri', 'status'];
    protected $guarded = [];

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class, 'no_anggota', 'no_anggota');
    }

    public function simpananwajib()
    {
        return $this->hasMany(SimpananWajib::class, 'no_anggota', 'no_anggota');
    }
}