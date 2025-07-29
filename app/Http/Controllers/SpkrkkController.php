<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Spkrkk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

class SpkrkkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'ruang_klinis' => 'required|string|max:255',
            'kualifikasi' => 'required|string|max:255',
            'masa_berlaku_dari' => 'required|date',
            'masa_berlaku_sampai' => 'required|date|after_or_equal:masa_berlaku_dari',
            'nomor_surat' => 'required|string|max:255',
            'file_names' => 'required|array',
            'file_names.*' => 'required|string|max:255',
            'files' => 'required|array',
            'files.*' => 'file|mimes:pdf|max:2048', // ✅ hanya PDF
        ]);

        $fileLinks = [];

        foreach ($request->file('files') as $index => $file) {
            if (!$file->isValid()) {
                continue;
            }

            $filename = Str::slug($request->file_names[$index]) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('spkrkk', $filename, 'public');
            $fileLinks[] = asset('storage/' . $path);
        }

        Spkrkk::create([
            'karyawan_id' => $request->karyawan_id,
            'ruang_klinis' => $request->ruang_klinis,
            'kualifikasi' => $request->kualifikasi,
            'masa_berlaku_dari' => $request->masa_berlaku_dari,
            'masa_berlaku_sampai' => $request->masa_berlaku_sampai,
            'nomor_surat' => $request->nomor_surat,
            'file_paths' => $fileLinks,
        ]);

        return redirect()->back()->with('success', 'Data SPKRKK berhasil disimpan.');
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $spkrkk = Spkrkk::findOrFail($id);

    $request->validate([
        'ruang_klinis' => 'required|string|max:255',
        'kualifikasi' => 'required|string|max:255',
        'masa_berlaku_dari' => 'required|date',
        'masa_berlaku_sampai' => 'required|date|after_or_equal:masa_berlaku_dari',
        'nomor_surat' => 'required|string|max:255',
        'file_names' => 'nullable|array',
        'file_names.*' => 'nullable|string|max:255',
        'files' => 'nullable|array',
        'files.*' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    $fileLinks = [];

    // Cek apakah user mengupload file baru
    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $index => $file) {
            if (!$file) continue;

            $filename = Str::slug($request->file_names[$index] ?? 'dokumen') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('spkrkk', $filename, 'public');
            $fileLinks[] = asset('storage/' . $path);
        }
    } else {
        // Jika tidak upload baru, tetap pakai file lama
        $fileLinks = $spkrkk->file_paths;
    }

    // Update record
    $spkrkk->update([
        'ruang_klinis' => $request->ruang_klinis,
        'kualifikasi' => $request->kualifikasi,
        'masa_berlaku_dari' => $request->masa_berlaku_dari,
        'masa_berlaku_sampai' => $request->masa_berlaku_sampai,
        'nomor_surat' => $request->nomor_surat,
        'file_paths' => $fileLinks,
    ]);

    return redirect()->back()->with('success', 'Data SPKRKK berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}