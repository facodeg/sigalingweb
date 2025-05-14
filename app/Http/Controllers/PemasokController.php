<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PemasokController extends Controller
{
    /**
     * Tampilkan daftar pemasok.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pemasoks = Pemasok::all();
        return view('pages.pemasok.index', compact('pemasoks'));
    }

    /**
     * Simpan pemasok baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'slug_pemasok' => 'required|unique:pemasok,slug_pemasok|max:255',
            'email' => 'required|email|max:255|unique:pemasok,email',
            'nohp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        Pemasok::create([
            'nama' => $request->nama,
            'slug_pemasok' => $request->slug_pemasok ?: Str::slug($request->nama),
            'email' => $request->email,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()->route('pemasok.index')->with('success', 'Pemasok berhasil ditambahkan.');
    }

    /**
     * Tampilkan formulir edit pemasok.
     *
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\View\View
     */
    public function edit(Pemasok $pemasok)
    {
        return response()->json($pemasok);
    }

    /**
     * Perbarui pemasok yang ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Temukan pemasok berdasarkan ID
        $pemasok = Pemasok::findOrFail($id);

        // Validasi data dari request
        $request->validate([
            'nama' => 'required|string|max:255',
            'slug_pemasok' => 'required|string|max:255|unique:pemasok,slug_pemasok,' . $id,
            'email' => 'required|email|max:255|unique:pemasok,email,' . $id,
            'nohp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        // Perbarui data pemasok
        $pemasok->update([
            'nama' => $request->input('nama'),
            'slug_pemasok' => $request->input('slug_pemasok') ?: Str::slug($request->input('nama')),
            'email' => $request->input('email'),
            'nohp' => $request->input('nohp'),
            'alamat' => $request->input('alamat'),
            'status' => $request->input('status'),
        ]);

        // Kembalikan respons JSON
        return response()->json(['message' => 'Pemasok berhasil diperbarui!']);
    }

    /**
     * Hapus pemasok yang ada.
     *
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pemasok $pemasok)
    {
        $pemasok->delete();

        return redirect()->route('pemasok.index')->with('success', 'Pemasok berhasil dihapus.');
    }
}
