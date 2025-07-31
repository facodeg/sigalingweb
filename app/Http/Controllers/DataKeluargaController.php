<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use Illuminate\Http\Request;

class DataKeluargaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'nama' => 'required|string|max:255',
            'hubungan' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        DataKeluarga::create($request->all());

        return redirect()->back()->with('success', 'Data keluarga berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = DataKeluarga::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'hubungan' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        $data->update($request->all());

        return redirect()->back()->with('success', 'Data keluarga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = DataKeluarga::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data keluarga berhasil dihapus.');
    }
}
