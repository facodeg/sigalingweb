<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;

    protected $table = 'pendidikan';
    protected $primaryKey = 'id_pendidikan';

    protected $fillable = [
        'nama',
        'nip',
        'jk',
        'jp',
        'pendidikan',
        'jb',
        'jabatan',
        'status_pg',
        'nama_sekolah',
        'Tahun',
    ];

    // Jika tidak menggunakan timestamps (created_at dan updated_at), uncomment baris berikut:
    // public $timestamps = false;
}