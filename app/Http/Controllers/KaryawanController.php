<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('pages.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('pages.karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip_nrp_nipppk_nipb' => 'required|string|unique:karyawans',
            'status_kepegawaian' => 'required|in:PNS,PPPK,BLUD,PTT',
            'tempat_lahir' => 'nullable|string|max:100',
            'tgl_lahir' => 'nullable|date',
            'umur_tahun' => 'nullable|integer',
            'umur_bulan' => 'nullable|integer',
            'jk' => 'required|in:L,P',
            'npwp' => 'nullable|string',
            'nik' => 'nullable|string',
            'status' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'tmt_jabatan' => 'nullable|date',
            'tmt_kerja_di_rsud' => 'nullable|date',
            'lama_kerja_tahun' => 'nullable|integer',
            'lama_kerja_bulan' => 'nullable|integer',
            'gol' => 'nullable|string',
            'tmt_gol' => 'nullable|date',
            'no_sk' => 'nullable|string',
            'tgl_sk' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'jenjang_pendidikan' => 'nullable|string|max:100',
            'pendidikan' => 'nullable|string|max:100',
            'alamat_ktp' => 'nullable|string',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50',
            'ruangan' => 'nullable|string|max:100',
            'status_nakes' => 'nullable|in:NAKES,NON',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('pages.karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function show(Karyawan $karyawan)
    {
        return view('pages.karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        return view('pages.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip_nrp_nipppk_nipb' => 'required|string|unique:karyawans,nip_nrp_nipppk_nipb,' . $karyawan->id,
            'status_kepegawaian' => 'required|in:PNS,PPPK,BLUD,PTT',
            'tempat_lahir' => 'nullable|string|max:100',
            'tgl_lahir' => 'nullable|date',
            'umur_tahun' => 'nullable|integer',
            'umur_bulan' => 'nullable|integer',
            'jk' => 'required|in:L,P',
            'npwp' => 'nullable|string',
            'nik' => 'nullable|string',
            'status' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'tmt_jabatan' => 'nullable|date',
            'tmt_kerja_di_rsud' => 'nullable|date',
            'lama_kerja_tahun' => 'nullable|integer',
            'lama_kerja_bulan' => 'nullable|integer',
            'gol' => 'nullable|string',
            'tmt_gol' => 'nullable|date',
            'no_sk' => 'nullable|string',
            'tgl_sk' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'jenjang_pendidikan' => 'nullable|string|max:100',
            'pendidikan' => 'nullable|string|max:100',
            'alamat_ktp' => 'nullable|string',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50',
            'ruangan' => 'nullable|string|max:100',
            'status_nakes' => 'nullable|in:NAKES,NON',
        ]);

        $karyawan->update($request->all());

        return redirect()->route('pages.karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('pages.karyawan.index')->with('success', 'Data karyawan berhasil dihapus.');
    }

    public function rincian($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('pages.karyawan.rincian', compact('karyawan'));
    }
}