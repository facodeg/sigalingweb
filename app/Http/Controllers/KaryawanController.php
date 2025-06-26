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

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function show(Karyawan $karyawan)
    {
        return view('pages.karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        return view('pages.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi sederhana (bisa kamu tambahkan aturan lebih detail)
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip_nrp_nipppk_nipb' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'nik' => 'nullable|string|max:20',
            'jk' => 'required|in:L,P',
            // Tambahkan validasi lainnya jika diperlukan
        ]);

        // Cari data karyawan berdasarkan ID
        $karyawan = Karyawan::findOrFail($id);

        // Update data karyawan
        $karyawan->update([
            'nama' => $request->nama,
            'nip_nrp_nipppk_nipb' => $request->nip_nrp_nipppk_nipb,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'nik' => $request->nik,
            'jk' => $request->jk,
            'status_kepegawaian' => $request->status_kepegawaian,
            'jabatan_terakhir' => $request->jabatan_terakhir,
            'tmt_jabatan' => $request->tmt_jabatan,
            'tmt_kerja_di_rsud' => $request->tmt_kerja_di_rsud,
            'lama_kerja_tahun' => $request->lama_kerja_tahun,
            'lama_kerja_bulan' => $request->lama_kerja_bulan,
            'gol' => $request->gol,
            'pangkat_gol' => $request->pangkat_gol,
            'tmt_gol' => $request->tmt_gol,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'jenjang_pendidikan' => $request->jenjang_pendidikan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'alamat_ktp' => $request->alamat_ktp,
            'desa' => $request->desa,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'agama' => $request->agama,
            'npwp' => $request->npwp,
            'ruangan' => $request->ruangan,
            'status' => $request->status,
            'status_nakes' => $request->status_nakes,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus.');
    }

    public function rincian($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('pages.karyawan.rincian', compact('karyawan'));
    }
}
