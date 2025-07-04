<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendidikanTb;

class PendidikanTbController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required',
            'jenjang' => 'required|string|max:100',
            'institusi' => 'required|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'tahun_lulus' => 'required|integer',
        ]);


        
        PendidikanTb::create($request->all());

        return redirect()->back()->with('success', 'Data Pendidikan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $pendidikan = PendidikanTb::findOrFail($id);

        $request->validate([
            'jenjang' => 'required|string|max:100',
            'institusi' => 'required|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'tahun_lulus' => 'required|integer',
        ]);

        $pendidikan->update($request->all());

        return redirect()->back()->with('success', 'Data Pendidikan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pendidikan = PendidikanTb::findOrFail($id);
        $pendidikan->delete();

        return redirect()->back()->with('success', 'Data Pendidikan berhasil dihapus');
    }
}