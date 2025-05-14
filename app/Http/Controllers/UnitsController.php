<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data unit, diurutkan berdasarkan id
        $units = Unit::orderBy('id')->get();
        return view('pages.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat unit baru
        return view('pages.units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'status' => 'required|integer|in:0,1', // Sesuaikan status dengan pilihan yang ada
        ]);

        // Generate slug from the unit name
        $slug_name = Str::slug($request->name);

        // Check if the generated slug is unique, and append a number if it is not
        $original_slug = $slug_name;
        $counter = 1;
        while (Unit::where('slug_name', $slug_name)->exists()) {
            $slug_name = $original_slug . '-' . $counter;
            $counter++;
        }

        // Membuat entri unit baru
        Unit::create([
            'name' => $request->name,
            'slug_name' => $slug_name,
            'details' => $request->details,
            'status' => $request->status,
        ]);

        return redirect()->route('units.index')->with('success', 'Unit berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unit = Unit::findOrFail($id);
        return view('pages.units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Menampilkan form edit unit
    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return response()->json($unit);
    }

    // Memperbarui unit
    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->update($request->all());
        return response()->json(['message' => 'Unit berhasil diperbarui!']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Menghapus entri unit yang ditemukan
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('units.index')->with('success', 'Data unit berhasil dihapus');
    }
}
