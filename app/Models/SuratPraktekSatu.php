<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPraktekSatu extends Model
{
    use HasFactory;

    protected $table = 'surat_praktek_satu';

    protected $fillable = ['nama_surat', 'no_surat', 'penanda_tangan_nama', 'penanda_tangan_nip', 'penanda_tangan_pangkat', 'penanda_tangan_jabatan', 'praktikan_nama', 'alamat_praktek', 'profesi', 'hari_praktek', 'jam_efektif_mingguan', 'shift_pagi', 'shift_sore', 'shift_malam', 'tempat_dikeluarkan', 'tanggal_dikeluarkan', 'unit'];
}