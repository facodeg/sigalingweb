<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\ApiWhatsapp;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KonfirmasiAnggotaController extends Controller
{
    public function index()
    {
        $pinjaman = Pinjaman::where('status', 'pending')->get();

        $totalajuanpinjaman = $pinjaman->count();

        $anggotas = Anggota::where('status', 'proses')->get();

        // Menghitung jumlah anggota yang diproses
        $totalProses = $anggotas->count();

        // Mengirimkan data ke view beserta total anggota
        return view('pages.konfirmasi.index', compact('anggotas', 'totalProses', 'totalajuanpinjaman'));
    }

    public function updateStatus(Request $request, Anggota $anggota)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|string|in:aktif,batal,tidak',
        ]);

        // Ambil `key` dan `links` dari model ApiWhatsapp
        $apiWhatsapp = ApiWhatsapp::where('status', 'aktif')->first();
        if (!$apiWhatsapp) {
            return redirect()->back()->with('error', 'API WhatsApp tidak tersedia.');
        }

        $apiKey = $apiWhatsapp->key;
        $apiauthorization = $apiWhatsapp->authorization;
        $apiLink = $apiWhatsapp->links;

        // Mengirimkan pesan menggunakan API WhatsApp baru
        $response = Http::withHeaders([
            'Authorization' => $apiauthorization, // Authorization diambil dari model ApiWhatsapp
        ])->post($apiLink, [
            'key' => $apiKey,
            'phone' => $anggota->no_hp, // Nomor telepon pengguna
            'message' => "🎉 Selamat! Anda telah berhasil terdaftar sebagai anggota koperasi! 🎉\n\n" . "📋 Nama: {$anggota->nama}\n" . "🆔 No Anggota: {$anggota->no_anggota}\n\n" . "🔗 Untuk informasi lebih lanjut, kunjungi: [Koperasi Mitra Husada Mandiri](https://app.mitrahusadamandiri.my.id)\n" . 'Terima kasih telah bergabung! 😊',
            'isGroup' => false,
            'secure' => false,
        ]);

        // Periksa apakah permintaan ke API berhasil
        if ($response->successful()) {
            // Perbarui status anggota
            $anggota->status = $request->input('status');
            $anggota->save();

            // Redirect dengan pesan sukses
            return redirect()->route('konfirmasi.index')->with('success', 'Status anggota berhasil diperbarui dan pesan berhasil dikirim.');
        } else {
            // Redirect dengan pesan error jika pengiriman pesan gagal
            $anggota->status = $request->input('status');
            $anggota->save();
            return redirect()->route('anggotas.index')->with('error', 'Status anggota berhasil diperbarui');
        }
    }
}