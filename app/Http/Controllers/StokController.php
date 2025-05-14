<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Barang;
use App\Models\StokLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    // Menampilkan daftar semua stok barang
    public function index()
    {
        $stok = Stok::with('barang')->get();
        return view('pages.stok.index', compact('stok'));
    }

    public function history($id_barang)
    {
        // Mengambil riwayat stok berdasarkan id_barang
        $stokLogs = DB::table('stok_log')->where('id_barang', $id_barang)->get();

        // Mengambil data barang
        $barang = DB::table('barang')->select('id', 'nama')->where('id', $id_barang)->first();

        if (!$barang) {
            return redirect()->back()->withErrors('Data barang tidak ditemukan.');
        }

        return view('pages.stok.history', compact('stokLogs', 'barang'));
    }
}
