<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::with('user')->get();
        return view('pages.pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        $users = User::all();
        return view('pages.pegawai.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|unique:pegawais',

            'alamat' => 'required',
            'jabatan' => 'required',
            'tanggal_lahir' => 'required|date',
            'pendidikan' => 'required',
        ]);

        Pegawai::create($request->all());
        return redirect()->route('pegawais.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit(Pegawai $pegawai)
    {
        $users = User::all();
        return view('pages.pegawai.edit', compact('pegawai', 'users'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|unique:pegawais,nip,' . $pegawai->id,

            'alamat' => 'required',
            'jabatan' => 'required',
            'tanggal_lahir' => 'required|date',
            'pendidikan' => 'required',
        ]);

        $pegawai->update($request->all());
        return redirect()->route('pegawais.index')->with('success', 'Data pegawai berhasil diupdate.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawais.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}
