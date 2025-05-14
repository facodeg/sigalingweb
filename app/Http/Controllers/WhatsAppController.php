<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\WhatsApp;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $whatsapps = WhatsApp::all(); // Mengambil semua data dari tabel whatsapp
        return view('pages.koperasi.admin.whatsapp.index', compact('whatsapps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $anggota = Anggota::all();
        return view('pages.koperasi.admin.whatsapp.create', compact('anggota'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'position' => 'required|string|max:255',
        ]);

        // Simpan data ke database
        WhatsApp::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'position' => $request->position,
        ]);

        return redirect()->route('whatsapp.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WhatsApp  $whatsapp
     * @return \Illuminate\Http\Response
     */
    public function edit(WhatsApp $whatsapp)
    {
        // Pastikan ada data tambahan jika diperlukan di view, misalnya anggota yang terkait.
        $anggota = Anggota::all(); // Contoh jika ada tabel Anggota yang terkait dengan nama
        return view('pages.koperasi.admin.whatsapp.edit', compact('whatsapp', 'anggota'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WhatsApp  $whatsapp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WhatsApp $whatsapp)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'position' => 'required|string|max:255',
        ]);

        // Update data
        $whatsapp->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'position' => $request->position,
        ]);

        return redirect()->route('whatsapp.index')->with('success', 'Data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WhatsApp  $whatsapp
     * @return \Illuminate\Http\Response
     */
    public function destroy(WhatsApp $whatsapp)
    {
        // Hapus data
        $whatsapp->delete();

        return redirect()->route('whatsapp.index')->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Auto-generate sample data.
     *
     * @return \Illuminate\Http\Response
     */
}