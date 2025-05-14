<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokLog extends Model
{
    protected $table = 'stok_log';

    protected $fillable = [
        'id_barang',
        'jumlah_perubahan',
        'tipe',
        'tanggal_perubahan',
        'transaksi_id',
        'harga_barang', // Harga barang saat transaksi
        'stok_sebelumnya', // Stok sebelum perubahan
        'stok_sesudah', // Stok setelah perubahan
        'id_user', // Tambahkan id_user ke dalam fillable
    ];
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang'); // Asumsi barang_id adalah foreign key
    }
    public function user()
    {
        // Relasi ke model User
        return $this->belongsTo(User::class, 'id_user');
    }
}