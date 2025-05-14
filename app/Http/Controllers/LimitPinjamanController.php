<?php

namespace App\Http\Controllers;

use App\Models\LimitPinjaman;
use App\Models\User;
use Illuminate\Http\Request;

class LimitPinjamanController extends Controller
{
    public function index()
    {
        $limitPinjaman = LimitPinjaman::all();
        return view('pages.koperasi.admin.limitpinjaman.index', compact('limitPinjaman'));
    }

    public function create()
    {
        $users = User::all();
        return view('pages.koperasi.admin.limitpinjaman.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'limit' => 'required|numeric',
            'status' => 'required|string',
        ]);

        LimitPinjaman::create($request->all());

        return redirect()->route('limitpinjaman.index')->with('success', 'Limit Pinjaman berhasil ditambahkan.');
    }

    public function show($id)
    {
        $limitPinjaman = LimitPinjaman::findOrFail($id);
        return view('pages.koperasi.admin.limitpinjaman.show', compact('limitPinjaman'));
    }

    public function edit($id)
    {
        $limitPinjaman = LimitPinjaman::findOrFail($id);
        $users = User::all(); // Ambil semua pengguna

        return view('pages.koperasi.admin.limitpinjaman.edit', compact('limitPinjaman', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'limit' => 'required|numeric',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $limitPinjaman = LimitPinjaman::findOrFail($id);
        $limitPinjaman->update($request->all());

        return redirect()->route('limitpinjaman.index')->with('success', 'Limit Pinjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $limitPinjaman = LimitPinjaman::findOrFail($id);
        $limitPinjaman->delete();

        return redirect()->route('limitpinjaman.index')->with('success', 'Limit Pinjaman berhasil dihapus.');
    }
}