<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $fillable = ['pembelian_id', 'id_barang', 'jumlah_barang', 'harga_barang', 'harga_jual'];

    // Relasi ke model Pembelian
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    // Relasi ke model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}