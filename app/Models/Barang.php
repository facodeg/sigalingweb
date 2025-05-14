<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = ['Kode_produk', 'Barcode', 'Nama', 'id_kategori', 'id_pemasok', 'id_merek', 'id_units', 'Harga', 'Jml_Peringatan', 'Deskripsi', 'Status', 'Gambar'];

    // Relasi ke tabel kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Relasi ke tabel pemasok
    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'id_pemasok');
    }

    // Relasi ke tabel merek
    public function merek()
    {
        return $this->belongsTo(Merek::class, 'id_merek');
    }

    // Relasi ke tabel satuan
    public function units()
    {
        return $this->belongsTo(Unit::class, 'id_units');
    }
}
