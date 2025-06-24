<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SIP extends Model
{
    protected $table = 's_i_p_s';

    protected $fillable = ['karyawan_id', 'nomor', 'tgl_terbit', 'tgl_expired', 'file'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
