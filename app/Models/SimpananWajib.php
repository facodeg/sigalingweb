<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpananWajib extends Model
{
    use HasFactory;

    // Nama tabel yang terkait
    protected $table = 'simpanan_wajib';

    // Kolom yang dapat diisi
    protected $fillable = [
        'no_anggota',
        'tgl_simpanan',
        'nominal',
        'status', // Status pembayaran
        'keterangan', // Keterangan tambahan
        'bukti', // Gambar bukti pembayaran
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'no_anggota', 'no_anggota');
    }
}