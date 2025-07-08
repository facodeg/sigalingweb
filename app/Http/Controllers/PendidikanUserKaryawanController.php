<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendidikanTb;

class PendidikanUserKaryawanController extends Controller
{
    /**
     * Simpan data pendidikan ke tabel pendidikan_tb
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:karyawans,id',
            'jenjang' => 'required|string',
            'institusi' => 'required|string',
            'program_studi' => 'required|string',
            'tahun_lulus' => 'required|numeric|digits:4',
            'keterangan' => 'required|in:Terdata,Tidak Terdata',
        ]);

        PendidikanTb::create($request->all());

        return redirect()->back()->with('success', 'Data pendidikan berhasil disimpan.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenjang' => 'required|string|max:100',
            'institusi' => 'required|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'tahun_lulus' => 'required|integer',
            'keterangan' => 'required',
        ]);

        $pendidikan = PendidikanTb::findOrFail($id);
        $pendidikan->update($request->all());

        return redirect()->back()->with('success', 'Data Pendidikan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pendidikan = PendidikanTb::findOrFail($id);
        $pendidikan->delete();

        return redirect()->back()->with('success', 'Data pendidikan berhasil dihapus');
    }
}
