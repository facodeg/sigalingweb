<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pemasok;
use App\Models\Merek;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        return view('pages.barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Mengambil semua data dari tabel kategori, pemasok, merek, dan satuan
        $kategori = Kategori::all();
        $pemasok = Pemasok::all();
        $merek = Merek::all();
        $satuan = Unit::all();

        // Generate Kode Produk otomatis (contoh: PRD001)
        $lastProduct = Barang::orderBy('id', 'desc')->first();
        $newCode = 'BR' . str_pad($lastProduct ? $lastProduct->id + 1 : 1, 5, '0', STR_PAD_LEFT);

        // Mengirim data ke view 'pages.barang.create'
        return view('pages.barang.create', compact('kategori', 'pemasok', 'merek', 'satuan', 'newCode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Kode_produk' => 'required|unique:barang',
            'Nama' => 'required',
            'id_kategori' => 'required|exists:kategori,id',
            'id_pemasok' => 'required|exists:pemasok,id',
            'id_merek' => 'required|exists:merek,id',
            'id_units' => 'required|exists:units,id',
            'Harga' => 'required|numeric',
            'Jml_Peringatan' => 'required|integer',
            'Status' => 'required|in:1,0',
            'Gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Upload gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('Gambar')) {
            $gambarPath = $request->file('Gambar')->store('images/barang', 'public');
        }

        Barang::create([
            'Kode_produk' => $request->Kode_produk,
            'Nama' => $request->Nama,
            'id_kategori' => $request->id_kategori,
            'id_pemasok' => $request->id_pemasok,
            'id_merek' => $request->id_merek,
            'id_units' => $request->id_units,
            'Harga' => $request->Harga,
            'Jml_Peringatan' => $request->Jml_Peringatan,
            'Deskripsi' => $request->Deskripsi,
            'Status' => $request->Status,
            'Gambar' => $gambarPath,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        return view('pages.barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        // Ambil data kategori, pemasok, merek, dan satuan dari database
        $kategori = Kategori::all();
        $pemasok = Pemasok::all();
        $merek = Merek::all();
        $satuan = Unit::all();

        // Tampilkan halaman edit dengan data barang dan data tambahan lainnya
        return view('pages.barang.edit', compact('barang', 'kategori', 'pemasok', 'merek', 'satuan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'Kode_produk' => 'required|unique:barang,Kode_produk,' . $barang->id,
            'Nama' => 'required',
            'id_kategori' => 'required|exists:kategori,id',
            'id_pemasok' => 'required|exists:pemasok,id',
            'id_merek' => 'required|exists:merek,id',
            'id_units' => 'required|exists:units,id',
            'Harga' => 'required|numeric',
            'Jml_Peringatan' => 'required|integer',
            'Status' => 'required|in:1,0',
            'Gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('Gambar')) {
            if ($barang->Gambar) {
                Storage::delete('public/' . $barang->Gambar);
            }
            $gambarPath = $request->file('Gambar')->store('images/barang', 'public');
            $barang->Gambar = $gambarPath;
        }

        $barang->update([
            'Kode_produk' => $request->Kode_produk,
            'Nama' => $request->Nama,
            'id_kategori' => $request->id_kategori,
            'id_pemasok' => $request->id_pemasok,
            'id_merek' => $request->id_merek,
            'id_units' => $request->id_units,
            'Harga' => $request->Harga,
            'Jml_Peringatan' => $request->Jml_Peringatan,
            'Deskripsi' => $request->Deskripsi,
            'Status' => $request->Status,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        if ($barang->Gambar) {
            Storage::delete('public/' . $barang->Gambar);
        }

        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}
