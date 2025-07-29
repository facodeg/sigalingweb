<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spkrkk extends Model
{
    use HasFactory;

    protected $table = 'spkrkk';

    protected $fillable = ['karyawan_id', 'ruang_klinis', 'kualifikasi', 'masa_berlaku_dari', 'masa_berlaku_sampai', 'file_paths', 'nomor_surat'];

    protected $casts = [
        'file_paths' => 'array',
        'masa_berlaku_dari' => 'date',
        'masa_berlaku_sampai' => 'date',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
