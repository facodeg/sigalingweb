<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';

    protected $fillable = ['kode_pembelian', 'tanggal_pembelian', 'id_pemasok', 'id_user', 'id_barang', 'jumlah_barang', 'harga_barang', 'harga_jual', 'pajak_barang', 'total_harga', 'pajak', 'status'];

    // Relasi dengan model Pemasok
    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'id_pemasok');
    }

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi dengan model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    // Relasi ke PembelianDetail
    public function details()
    {
        return $this->hasMany(PembelianDetail::class);
    }
}