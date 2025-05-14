<?php

namespace App\Http\Controllers;

use App\Models\SuratPraktekSatu;
use Illuminate\Http\Request;

class SuratPraktekSatuController extends Controller
{
    public function index()
    {
        $data = SuratPraktekSatu::all();
        return view('pages.surat_praktek_satu.index', compact('data'));
    }

    public function create()
    {
        return view('pages.surat_praktek_satu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'penanda_tangan_nama' => 'required|string|max:255',
            'praktikan_nama' => 'required|string|max:255',
            'jam_efektif_mingguan' => 'nullable|numeric',
            'tanggal_dikeluarkan' => 'nullable|date',
        ]);

        SuratPraktekSatu::create($validated + $request->only(['penanda_tangan_nip', 'penanda_tangan_pangkat', 'penanda_tangan_jabatan', 'alamat_praktek', 'profesi', 'hari_praktek', 'shift_pagi', 'shift_sore', 'shift_malam', 'tempat_dikeluarkan']));

        return redirect()->route('surat_praktek_satu.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show(SuratPraktekSatu $surat)
    {
        return view('pages.surat_praktek_satu.show', compact('surat'));
    }

    public function edit(SuratPraktekSatu $surat)
    {
        return view('pages.surat_praktek_satu.edit', compact('surat'));
    }

    public function update(Request $request, SuratPraktekSatu $surat)
    {
        $validated = $request->validate([
            'penanda_tangan_nama' => 'required|string|max:255',
            'praktikan_nama' => 'required|string|max:255',
            'jam_efektif_mingguan' => 'nullable|numeric',
            'tanggal_dikeluarkan' => 'nullable|date',
        ]);

        $surat->update($validated + $request->only(['penanda_tangan_nip', 'penanda_tangan_pangkat', 'penanda_tangan_jabatan', 'alamat_praktek', 'profesi', 'hari_praktek', 'shift_pagi', 'shift_sore', 'shift_malam', 'tempat_dikeluarkan']));

        return redirect()->route('surat_praktek_satu.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(SuratPraktekSatu $surat)
    {
        $surat->delete();
        return redirect()->route('surat_praktek_satu.index')->with('success', 'Data berhasil dihapus.');
    }
}