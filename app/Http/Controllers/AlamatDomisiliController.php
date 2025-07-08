<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlamatDomisili;
use App\Models\Province;

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

        AlamatDomisili::create([
            'karyawan_id' => $request->karyawan_id,
            'province_code' => $request->province_code,
            'city_code' => $request->city_code,
            'district_code' => $request->district_code,
            'village_code' => $request->village_code,
            'alamat_lengkap' => $request->alamat_lengkap,
            'keterangan' => 'Domisili',
        ]);

        if ($request->is_ktp_juga == '0') {
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

        return redirect()->back()->with('success', 'Alamat Domisili dan KTP berhasil disimpan.');
    }

    public function edit($id)
    {
        $alamat = AlamatDomisili::findOrFail($id);
        $provinsiList = Province::orderBy('name')->get();
        return view('pages.peranggota.edit-alamat', compact('alamat', 'provinsiList'));
    }

    public function update(Request $request, $id)
    {
        $alamat = AlamatDomisili::findOrFail($id);

        $request->validate([
            'province_code' => 'required',
            'city_code' => 'required',
            'district_code' => 'required',
            'village_code' => 'required',
            'alamat_lengkap' => 'required|string',
        ]);

        $alamat->update([
            'province_code' => $request->province_code,
            'city_code' => $request->city_code,
            'district_code' => $request->district_code,
            'village_code' => $request->village_code,
            'alamat_lengkap' => $request->alamat_lengkap,
        ]);

        return redirect()->back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $alamat = AlamatDomisili::findOrFail($id);
        $alamat->delete();
        return redirect()->back()->with('success', 'Alamat berhasil dihapus.');
    }
}
