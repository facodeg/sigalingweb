<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatDomisili extends Model
{
    protected $table = 'alamat_domisili';

    protected $fillable = ['karyawan_id', 'province_code', 'city_code', 'district_code', 'village_code', 'alamat_lengkap', 'keterangan'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function province()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Province::class, 'province_code', 'code');
    }

    public function city()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\City::class, 'city_code', 'code');
    }

    public function district()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\District::class, 'district_code', 'code');
    }

    public function village()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Village::class, 'village_code', 'code');
    }
}
