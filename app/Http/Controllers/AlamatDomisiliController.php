<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlamatDomisili;

class AlamatDomisiliController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'province_code' => 'required',
            'city_code' => 'required',
            'district_code' => 'required',
            'village_code' => 'required',
            'alamat_lengkap' => 'required|string',
            'alamat_sama' => 'required|in:0,1',
        ]);

        // Simpan alamat domisili
        AlamatDomisili::create([
            'karyawan_id' => $request->karyawan_id,
            'province_code' => $request->province_code,
            'city_code' => $request->city_code,
            'district_code' => $request->district_code,
            'village_code' => $request->village_code,
            'alamat_lengkap' => $request->alamat_lengkap,
            'keterangan' => 'Domisili',
        ]);

        // Jika alamat sama, salin data untuk KTP juga
        if ($request->alamat_sama == '1') {
            AlamatDomisili::create([
                'karyawan_id' => $request->karyawan_id,
                'province_code' => $request->province_code,
                'city_code' => $request->city_code,
                'district_code' => $request->district_code,
                'village_code' => $request->village_code,
                'alamat_lengkap' => $request->alamat_lengkap,
                'keterangan' => 'KTP',
            ]);
        } else {
            // Kalau tidak sama, ambil data dari form KTP
            $request->validate([
                'province_code_ktp' => 'required',
                'city_code_ktp' => 'required',
                'district_code_ktp' => 'required',
                'village_code_ktp' => 'required',
                'alamat_lengkap_ktp' => 'required|string',
            ]);

            AlamatDomisili::create([
                'karyawan_id' => $request->karyawan_id,
                'province_code' => $request->province_code_ktp,
                'city_code' => $request->city_code_ktp,
                'district_code' => $request->district_code_ktp,
                'village_code' => $request->village_code_ktp,
                'alamat_lengkap' => $request->alamat_lengkap_ktp,
                'keterangan' => 'KTP',
            ]);
        }

        return redirect()->back()->with('success', 'Alamat domisili dan KTP berhasil disimpan.');
    }
}
