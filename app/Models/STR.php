<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class STR extends Model
{
    protected $table = 's_t_r_s';

    protected $fillable = ['karyawan_id', 'nomor', 'tgl_terbit', 'tgl_expired', 'file'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    // Accessor untuk tgl_expired
    public function getTglExpiredFormattedAttribute()
    {
        if (empty($this->tgl_expired)) {
            return 'Seumur Hidup';
        }

        return Carbon::parse($this->tgl_expired)->format('d-m-Y');
    }
}