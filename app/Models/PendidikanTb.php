<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendidikanTb extends Model
{
    protected $table = 'pendidikan_tb';

    protected $fillable = ['pegawai_id', 'jenjang', 'institusi', 'program_studi', 'tahun_lulus'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'pegawai_id');
    }
}
