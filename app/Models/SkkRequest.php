<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkkRequest extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai konvensi)
    protected $table = 'skk_requests';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = ['karyawan_nip', 'nama', 'request_type', 'keperluan', 'status'];

    // Jika kamu ingin casting tanggal
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}