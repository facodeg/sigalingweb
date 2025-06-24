<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sip;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Storage;

class SipController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'nomor' => 'required|string',
            'tgl_terbit' => 'required|date',
            'tgl_expired' => 'nullable|date|after_or_equal:tgl_terbit',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5048',
            'file_url' => 'nullable|url',
        ]);

        $data = $request->only(['nomor', 'tgl_terbit', 'tgl_expired']);

        $data['tgl_expired'] = $data['tgl_expired'] ?? '2060-12-31';

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('sip_files', 'public');
        } elseif ($request->filled('file_url')) {
            $data['file'] = $request->file_url;
        }

        $karyawan = Karyawan::findOrFail($request->karyawan_id);
        $karyawan->sip()->create($data);

        return back()->with('success', 'Data SIP berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor' => 'required|string',
            'tgl_terbit' => 'required|date',
            'tgl_expired' => 'nullable|date|after_or_equal:tgl_terbit',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5048',
            'file_url' => 'nullable|url',
        ]);

        $sip = Sip::findOrFail($id);
        $sip->nomor = $request->nomor;
        $sip->tgl_terbit = $request->tgl_terbit;
        $sip->tgl_expired = $request->filled('tgl_expired') ? $request->tgl_expired : '2060-12-31';

        // Hapus file lama jika upload baru
        if ($request->hasFile('file')) {
            if ($sip->file && !str_starts_with($sip->file, 'http')) {
                Storage::disk('public')->delete($sip->file);
            }
            $sip->file = $request->file('file')->store('sip_files', 'public');
        } elseif ($request->filled('file_url')) {
            if ($sip->file && !str_starts_with($sip->file, 'http')) {
                Storage::disk('public')->delete($sip->file);
            }
            $sip->file = $request->file_url;
        }

        $sip->save();

        return back()->with('success', 'Data SIP berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sip = Sip::findOrFail($id);

        // Hapus file dari storage jika bukan link
        if ($sip->file && !str_starts_with($sip->file, 'http')) {
            Storage::disk('public')->delete($sip->file);
        }

        $sip->delete();

        return back()->with('success', 'Data SIP berhasil dihapus.');
    }
}