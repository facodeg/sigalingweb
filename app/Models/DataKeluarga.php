<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKeluarga extends Model
{
    use HasFactory;

    protected $table = 'data_keluarga';

    protected $fillable = ['karyawan_id', 'nama', 'hubungan', 'tgl_lahir', 'pekerjaan'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
