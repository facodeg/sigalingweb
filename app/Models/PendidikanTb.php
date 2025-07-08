<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendidikanTb extends Model
{
    use HasFactory;

    protected $table = 'pendidikan_tb';

    protected $fillable = ['pegawai_id', 'jenjang', 'institusi', 'program_studi', 'tahun_lulus','keterangan'];

    /**
     * Relasi ke model Karyawan
     * PendidikanTb milik satu Karyawan
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'pegawai_id', 'id');
    }
}
