<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Str;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Storage;

class StrController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'nomor' => 'required|string',
            'tgl_terbit' => 'required|date',
            'tgl_expired' => 'nullable|date|after_or_equal:tgl_terbit',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_url' => 'nullable|url',
        ]);

        $data = $request->only(['karyawan_id', 'nomor', 'tgl_terbit', 'tgl_expired']);

        $data['tgl_expired'] = $request->filled('tgl_expired') ? $request->tgl_expired : '2060-12-31';

        // Upload file jika ada
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('uploads/str', 'public');
        } elseif ($request->filled('file_url')) {
            $data['file'] = $request->file_url; // gunakan URL jika tidak upload file
        }

        Str::create($data);

        return back()->with('success', 'Data STR berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor' => 'required|string',
            'tgl_terbit' => 'required|date',
            'tgl_expired' => 'nullable|date|after_or_equal:tgl_terbit',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_url' => 'nullable|url',
        ]);

        $str = Str::findOrFail($id);

        $data = $request->only(['nomor', 'tgl_terbit', 'tgl_expired']);
        $data['tgl_expired'] = $request->filled('tgl_expired') ? $request->tgl_expired : '2060-12-31';

        // Jika file baru diupload, hapus yang lama
        if ($request->hasFile('file')) {
            if ($str->file && !filter_var($str->file, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($str->file)) {
                Storage::disk('public')->delete($str->file);
            }
            $data['file'] = $request->file('file')->store('uploads/str', 'public');
        } elseif ($request->filled('file_url')) {
            if ($str->file && !filter_var($str->file, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($str->file)) {
                Storage::disk('public')->delete($str->file);
            }
            $data['file'] = $request->file_url;
        }

        $str->update($data);

        return redirect()->back()->with('success', 'Data STR berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $str = Str::findOrFail($id);

        if ($str->file && !filter_var($str->file, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($str->file)) {
            Storage::disk('public')->delete($str->file);
        }

        $str->delete();

        return back()->with('success', 'Data STR berhasil dihapus.');
    }
}
