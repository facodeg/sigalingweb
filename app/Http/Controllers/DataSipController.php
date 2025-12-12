<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SIP;

class DataSipController extends Controller
{
    public function index(Request $request)
    {
        $query = SIP::with('karyawan');

        // Filter pencarian (opsional)
        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('nomor', 'like', "%{$q}%")->orWhereHas('karyawan', function ($sub) use ($q) {
                    $sub->where('nama', 'like', "%{$q}%")
                        ->orWhere('jabatan_terakhir', 'like', "%{$q}%")
                        ->orWhere('ruangan', 'like', "%{$q}%");
                });
            });
        }

        // Ambil semua data tanpa paginate
        $data = $query->orderByDesc('tgl_terbit')->get();

        return view('pages.datasip.index', compact('data'));
    }
}
