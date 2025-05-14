<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';

    // protected $fillable = ['no_pinjaman', 'no_anggota', 'tgl_pinjaman', 'nominal', 'tenor', 'bayar_perbulan', 'tgl_selesai', 'biaya_admin', 'alasan_pinjam', 'status'];
    protected $guarded = [];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'no_anggota', 'no_anggota');
    }

    public function angsuran()
    {
        return $this->hasMany(Angsuran::class, 'no_pinjaman', 'no_pinjaman');
    }
}