<?php

namespace App\Http\Controllers;

use App\Models\Pendidikan;
use Illuminate\Http\Request;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendidikan = Pendidikan::all();
        return view('pages.pendidikan.index', compact('pendidikan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.pendidikan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:pendidikan,nip',
            'jk' => 'required|in:L,P',
            'jp' => 'required|string',
            'pendidikan' => 'required|string',
            'jb' => 'required|string',
            'jabatan' => 'required|string',
            'status_pg' => 'required|string',
            'nama_sekolah' => 'required|string',
            'Tahun' => 'required|digits:4|integer',
        ]);

        Pendidikan::create($request->all());

        return redirect()->route('pendidikan.index')->with('success', 'Data pendidikan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Pendidikan::findOrFail($id);
        return view('pages.pendidikan.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Pendidikan::findOrFail($id);
        return view('pages.pendidikan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Pendidikan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:pendidikan,nip,' . $id . ',id_pendidikan',
            'jk' => 'required|in:L,P',
            'jp' => 'required|string',
            'pendidikan' => 'required|string',
            'jb' => 'required|string',
            'jabatan' => 'required|string',
            'status_pg' => 'required|string',
            'nama_sekolah' => 'required|string',
            'Tahun' => 'required|digits:4|integer',
        ]);

        $data->update($request->all());

        return redirect()->route('pendidikan.index')->with('success', 'Data pendidikan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pendidikan::destroy($id);
        return redirect()->route('pendidikan.index')->with('success', 'Data pendidikan berhasil dihapus.');
    }
}