<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MerekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data merek, diurutkan berdasarkan id
        $mereks = Merek::orderBy('id')->get();
        return view('pages.merek.index', compact('mereks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat merek baru
        return view('pages.merek.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'nama' => 'required|string|max:255',
            'slug_merek' => 'required|string|max:255|unique:merek',
            'status' => 'required', // Sesuaikan status dengan pilihan yang ada
        ]);

        // Generate slug from the merek name
        $slug_name = Str::slug($request->nama);

        // Check if the generated slug is unique, and append a number if it is not
        $original_slug = $slug_name;
        $counter = 1;
        while (Merek::where('slug_merek', $slug_name)->exists()) {
            $slug_name = $original_slug . '-' . $counter;
            $counter++;
        }

        // Membuat entri merek baru
        Merek::create([
            'nama' => $request->nama,
            'slug_merek' => $slug_name,
            'status' => $request->status,
        ]);

        return redirect()->route('merek.index')->with('success', 'Merek berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $merek = Merek::findOrFail($id);
        return view('pages.merek.show', compact('merek'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $merek = Merek::findOrFail($id);
        return response()->json($merek);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $merek = Merek::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'slug_merek' => 'required|string|max:255|unique:nama,slug_merek,' . $merek->id,
            'status' => 'required|in:1,0',
        ]);

        $merek->update([
            'nama' => $request->nama,
            'slug_merek' => $request->slug_merek,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Merek berhasil diperbarui!']);
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Merek $merek)
    {
        $request->validate([
            'status' => 'required|in:1,0',
        ]);

        $merek->update([
            'status' => $request->status,
        ]);

        return redirect()->route('merek.index')->with('success', 'Status merek berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $merek = Merek::findOrFail($id);
        $merek->delete(); // Jika ingin menandai sebagai non-aktif, ubah dengan updateStatus

        return redirect()->route('merek.index')->with('success', 'Merek berhasil dihapus');
    }
}
