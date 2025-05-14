<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Anggota;
use App\Models\ApiWhatsapp;
use App\Models\WhatsApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DaftarController extends Controller
{
    public function showRegistration()
    {
        return view('pages.auth.register'); // Menampilkan form pendaftaran
    }

    public function register(Request $request)
    {
        // Validasi input dari form
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:users,phone',
            'email2' => 'required|string|email|max:255|unique:users,email2',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek apakah email2 sudah ada di database
        $existingUser = User::where('email2', $request->email2)->first();
        if ($existingUser) {
            return redirect()->back()->with('error', 'Email 2 ini sudah digunakan oleh pengguna lain. Silakan gunakan email 2 yang berbeda.');
        }

        $existingUserByPhone = User::where('phone', $request->phone)->first();
        if ($existingUserByPhone) {
            return redirect()->back()->with('error', 'Nomor telepon ini sudah terdaftar. Silakan gunakan nomor telepon yang berbeda.');
        }

        // Format email berdasarkan datetime sekarang
        $now = now();
        $formattedEmail = $now->format('dmY-His');

        // Buat akun baru di User
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $formattedEmail,
            'email2' => $request->email2,
            'password' => Hash::make($request->password),
            'role' => 'anggota', // Otomatis 'anggota'
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Masukkan data ke dalam tabel Anggota
        $anggota = Anggota::create([
            'tanggal' => now(), // Tanggal sekarang
            'no_anggota' => $formattedEmail, // No anggota berdasarkan $formattedEmail
            'nama' => $request->name, // Nama dari form
            'no_hp' => $request->phone, // Nomor HP dari form
            'status' => 'pending', // Status default 'pending'
        ]);

        // Ambil semua nomor WhatsApp dengan posisi 'Pendaftaran'
        $whatsappNumbers = WhatsApp::where('position', 'Pendaftaran')->pluck('phone');

        // Ambil `key` dan `links` dari model ApiWhatsapp
        $apiWhatsapp = ApiWhatsapp::where('status', 'aktif')->first();
        if (!$apiWhatsapp) {
            return redirect()->back()->with('error', 'API WhatsApp tidak tersedia.');
        }

        $apiKey = $apiWhatsapp->key;
        $apiauthorization = $apiWhatsapp->authorization;
        $apiLink = $apiWhatsapp->links;

        // Kirim pesan melalui API WhatsApp untuk setiap nomor
        foreach ($whatsappNumbers as $number) {
            $response = Http::withHeaders([
                'Authorization' => $apiauthorization, // Authorization diambil dari model ApiWhatsapp
            ])->post($apiLink, [
                'key' => $apiKey,
                'phone' => $number,
                'message' => "Pendaftaran baru telah diterima! 🎉\nNama: {$anggota->nama}\nNo Anggota: {$anggota->no_anggota}\nNo HP: {$anggota->no_hp}\n\nLihat detail lebih lanjut di sini: https://app.mitrahusadamandiri.my.id",
                'isGroup' => false,
                'secure' => false,
            ]);

            if (!$response->successful()) {
                // Tambahkan log error jika pesan gagal dikirim
                Log::error('Gagal mengirim pesan WhatsApp ke nomor: ' . $number);
            }
        }

        // Kirim pesan ke pengguna yang baru mendaftar
        $response = Http::withHeaders([
            'Authorization' => $apiauthorization,
        ])->post($apiLink, [
            'key' => $apiKey,
            'phone' => $request->phone, // Nomor telepon pengguna
            'message' => "Selamat datang di Koperasi Mitra Husada Mandiri! 🎉\n\nAkun Anda telah berhasil dibuat. Silakan login dengan No Anggota: $formattedEmail atau dengan menggunakan Email : {$request->email2}.\n\nSetelah berhasil login, Anda akan melihat *Timeline Pengajuan Anggota* untuk memandu Anda melengkapi data dan menyelesaikan proses pengajuan.\n\nKlik link berikut untuk memulai perjalanan Anda bersama kami: https://app.mitrahusadamandiri.my.id/\n\nSelamat bergabung dan semoga sukses! 😊",
            'isGroup' => false,
            'secure' => false,
        ]);

        if ($response->successful()) {
            // Pesan terkirim, lanjutkan proses
            return redirect()->route('login')->with('success', 'Selamat, akun Anda telah berhasil dibuat. Tunggu WhatsApp dari kami berupa nomor anggota yang dapat digunakan untuk login.');
        } else {
            // Jika terjadi masalah saat mengirim pesan
            return redirect()->back()->with('error', 'Akun berhasil dibuat, namun pesan WhatsApp gagal terkirim.');
        }
    }
}