<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stok';

    protected $fillable = ['id_barang', 'jumlah_stok'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang'); // Asumsi barang_id adalah foreign key
    }
}