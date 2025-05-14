<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\ApiWhatsapp;
use Illuminate\Http\Request;

class ApiWhatsappController extends Controller
{
    // Menampilkan semua data WhatsApp
    public function index()
    {
        // Mengambil semua data dari model ApiWhatsapp
        $whatsapps = ApiWhatsapp::all();
        return view('pages.koperasi.admin.apiwhatsapp.index', compact('whatsapps'));
    }

    // Menampilkan form untuk menambahkan data WhatsApp baru
    public function create()
    {
        return view('pages.koperasi.admin.apiwhatsapp.create');
    }

    // Menyimpan data baru ke database
    public function store(Request $request)
    {
        // Validasi data yang diinputkan
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'authorization' => 'required|string',
            'links' => 'nullable|url',
            'status' => 'required',
            'key' => 'required|string',
        ]);

        // Menyimpan data ke database
        ApiWhatsapp::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'authorization' => $request->input('authorization'),
            'links' => $request->input('links'),
            'status' => $request->input('status'),
            'key' => $request->input('key'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('apiwhatsapp.index')->with('success', 'Data WhatsApp API berhasil disimpan.');
    }

    // Menampilkan form untuk mengedit data WhatsApp
    public function edit($id)
    {
        // Mencari data berdasarkan ID
        $apiwhatsapp = ApiWhatsapp::findOrFail($id);

        // Mendapatkan semua anggota
        $anggota = Anggota::all(); // Pastikan model Anggota sudah benar

        // Mengirimkan data ke view
        return view('pages.koperasi.admin.apiwhatsapp.edit', compact('apiwhatsapp', 'anggota'));
    }

    // Mengupdate data di database
    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'links' => 'required|url',
            'authorization' => 'required|string|max:255',
            'status' => 'required|string|in:aktif,non_aktif',
            'key' => 'required|string|max:255', // Validasi status sebagai string
        ]);

        // Mencari data berdasarkan ID dan melakukan update
        $whatsapp = ApiWhatsapp::findOrFail($id);
        $whatsapp->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'links' => $request->input('links'),
            'authorization' => $request->input('authorization'),
            'status' => $request->input('status'),

            'key' => $request->input('key'),
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('apiwhatsapp.index')->with('success', 'Kontak WhatsApp berhasil diperbarui.');
    }

    // Menghapus data dari database
    public function destroy($id)
    {
        // Mencari data berdasarkan ID dan menghapusnya
        $whatsapp = ApiWhatsapp::findOrFail($id);
        $whatsapp->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('apiwhatsapp.index')->with('success', 'Kontak WhatsApp berhasil dihapus.');
    }
}