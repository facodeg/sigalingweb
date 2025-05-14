<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data kategori, diurutkan berdasarkan id
        $kategori = Kategori::orderBy('id')->get();
        return view('pages.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat kategori baru
        return view('pages.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        // Generate slug from the category name
        $kategori_slug = Str::slug($request->nama_kategori);

        // Check if the generated slug is unique, and append a number if it is not
        $original_slug = $kategori_slug;
        $counter = 1;
        while (Kategori::where('kategori_slug', $kategori_slug)->exists()) {
            $kategori_slug = $original_slug . '-' . $counter;
            $counter++;
        }

        // Membuat entri kategori baru
        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'kategori_slug' => $kategori_slug,
            'status' => $request->status,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('pages.kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('pages.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the existing category entry
        $kategori = Kategori::findOrFail($id);

        // Validate the request data
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        // Generate slug from the category name
        $kategori_slug = Str::slug($request->nama_kategori);

        // Check if the slug needs to be updated
        if ($kategori->kategori_slug !== $kategori_slug) {
            // Ensure the new slug is unique
            $original_slug = $kategori_slug;
            $counter = 1;
            while (
                Kategori::where('kategori_slug', $kategori_slug)
                    ->where('id', '!=', $kategori->id)
                    ->exists()
            ) {
                $kategori_slug = $original_slug . '-' . $counter;
                $counter++;
            }
        } else {
            // If the name hasn't changed, keep the existing slug
            $kategori_slug = $kategori->kategori_slug;
        }

        // Update the category data
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'kategori_slug' => $kategori_slug,
            'status' => $request->status,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Menghapus entri kategori yang ditemukan
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil dihapus');
    }
}
