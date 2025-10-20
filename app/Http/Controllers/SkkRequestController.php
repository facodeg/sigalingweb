<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SkkRequest;
use Illuminate\Http\Request;

class SkkRequestController extends Controller
{
    public function index()
    {
        $requests = SkkRequest::latest()->get();
        return view('CetakSurat.skk_index', compact('requests'));
    }

    public function cetak($id)
    {
        $surat = SkkRequest::findOrFail($id);
        return view('CetakSurat.surat_keterangan', compact('surat'));
    }
}