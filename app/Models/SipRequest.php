<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipRequest extends Model
{
    use HasFactory;

    protected $table = 'sip_requests';
    protected $primaryKey = 'id';
    public $incrementing = false; // karena ID bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = ['id', 'karyawan_nip', 'nama', 'profesi', 'tempat_lahir', 'tanggal_lahir', 'nik', 'no_str', 'str_berlaku_sampai', 'alamat_rumah', 'no_hp', 'lulusan', 'tahun_lulus', 'status', 'file_permohonan_signed'];

    // Relasi ke tabel sip_links
    public function links()
    {
        return $this->hasMany(SipLink::class, 'sip_id', 'id');
    }

    public function karyawan()
    {
        return $this->belongsTo(\App\Models\Karyawan::class, 'karyawan_nip', 'nip_nrp_nipppk_nipb')->withDefault([
            'nama' => null,
            'jabatan_terakhir' => null,
            'ruangan' => null,
        ]);
    }
}
