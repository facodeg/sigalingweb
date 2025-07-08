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
        ]);

        AlamatDomisili::create($request->all());

        return redirect()->back()->with('success', 'Alamat domisili berhasil disimpan.');
    }
}
