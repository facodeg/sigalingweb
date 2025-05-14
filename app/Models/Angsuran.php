<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory;

    protected $table = 'angsuran';

    protected $fillable = [
        'no_angsuran',
        'no_pinjaman',
        'tgl_angsuran',
        'nominal',
        'angsuranke',
        'status',
        'sisa_pinjaman',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'no_pinjaman', 'no_pinjaman');
    }
}
