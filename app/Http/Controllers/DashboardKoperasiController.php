<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendidikan;
use Illuminate\Support\Facades\DB;

class DashboardKoperasiController extends Controller
{
    public function index()
    {
        $pendidikan = Pendidikan::all();
        // Total data pendidikan
        $totalPegawai = Pendidikan::count();

        // Jumlah pendidikan terisi & tidak terisi berdasarkan nama_sekolah
        $jumlahPendidikanTerisi = Pendidikan::whereNotNull('nama_sekolah')->where('nama_sekolah', '!=', '')->count();

        $jumlahPendidikanKosong = Pendidikan::whereNull('nama_sekolah')->orWhere('nama_sekolah', '')->count();

        // Rekap tahun pendidikan
        $tahunPendidikan = Pendidikan::select('Tahun', DB::raw('COUNT(*) as jumlah'))->whereNotNull('Tahun')->where('Tahun', '!=', '')->groupBy('Tahun')->orderByDesc('jumlah')->pluck('jumlah', 'Tahun')->toArray();

        // Rekap sekolah terbanyak
        $sekolahTerbanyak = Pendidikan::select('nama_sekolah', DB::raw('COUNT(*) as jumlah'))->whereNotNull('nama_sekolah')->where('nama_sekolah', '!=', '')->groupBy('nama_sekolah')->orderByDesc('jumlah')->pluck('jumlah', 'nama_sekolah')->toArray();

        // Rekap per nama tingkat pendidikan
        $pendidikanPerTingkat = Pendidikan::select('pendidikan', DB::raw('COUNT(*) as jumlah'))->whereNotNull('pendidikan')->where('pendidikan', '!=', '')->groupBy('pendidikan')->orderByDesc('jumlah')->pluck('jumlah', 'pendidikan')->toArray();

        $statusPG = Pendidikan::select('status_pg', DB::raw('COUNT(*) as jumlah'))->whereNotNull('status_pg')->where('status_pg', '!=', '')->groupBy('status_pg')->pluck('jumlah', 'status_pg')->toArray();

        return view('pages.dashboard-koperasi', compact('totalPegawai', 'jumlahPendidikanTerisi', 'jumlahPendidikanKosong', 'tahunPendidikan', 'sekolahTerbanyak', 'pendidikanPerTingkat', 'pendidikan', 'statusPG'));
    }
}