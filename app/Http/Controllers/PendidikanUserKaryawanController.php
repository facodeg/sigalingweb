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
}
