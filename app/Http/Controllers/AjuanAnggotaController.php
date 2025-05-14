<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\WhatsApp;
use App\Models\ApiWhatsapp;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AjuanAnggotaController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_anggota)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'nip_nipb_nrptt' => 'nullable|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer',
            'nik' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'status_kepegawaian' => 'required|string|in:PNS,BLUD,PTT,PPK,Lainnya',
            'status_pernikahan' => 'required|string|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'simpanan_pokok' => 'required|numeric',
            'waktu_pembayaran' => 'required|in:1,2,4',
            'simpanan_wajib' => 'required|numeric',
            'upload_ktp' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'upload_foto_diri' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Temukan anggota berdasarkan no_anggota
        $anggota = Anggota::where('no_anggota', $no_anggota)->firstOrFail();

        // Perbarui data anggota
        $anggota->update([
            'tanggal' => now(),
            'nip_nipb_nrptt' => $validated['nip_nipb_nrptt'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'umur' => $validated['umur'],
            'nik' => $validated['nik'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'unit_kerja' => $validated['unit_kerja'],
            'status_kepegawaian' => $validated['status_kepegawaian'],
            'status_pernikahan' => $validated['status_pernikahan'],
            'simpanan_pokok' => $validated['simpanan_pokok'],
            'waktu_pembayaran' => $validated['waktu_pembayaran'],
            'simpanan_wajib' => $validated['simpanan_wajib'],
            'status' => 'proses', // Status di-update di sini
        ]);

        // Proses upload file jika ada
        if ($request->hasFile('upload_ktp')) {
            $file = $request->file('upload_ktp');
            $path = $file->store('uploads/ktp', 'public');
            $anggota->upload_ktp = $path;
        }

        if ($request->hasFile('upload_foto_diri')) {
            $file = $request->file('upload_foto_diri');
            $path = $file->store('uploads/foto_diri', 'public');
            $anggota->upload_foto_diri = $path;
        }

        // Simpan anggota setelah update file
        $anggota->save();

        // Ambil `key` dan `links` dari model ApiWhatsapp
        $apiWhatsapp = ApiWhatsapp::where('status', 'aktif')->first();
        if (!$apiWhatsapp) {
            return redirect()->back()->with('error', 'API WhatsApp tidak tersedia.');
        }

        $apiKey = $apiWhatsapp->key;
        $apiauthorization = $apiWhatsapp->authorization;
        $apiLink = $apiWhatsapp->links;

        // Kirim pesan ke anggota melalui API WhatsApp baru
        $response = Http::withHeaders([
            'Authorization' => $apiauthorization,
        ])->post($apiLink, [
            'key' => $apiKey,
            'phone' => $anggota->no_hp,
            'message' => '🎉 Selamat! Pengajuan Anda berhasil! 🎉\n\n' . 'Kami akan segera memproses pengajuan Anda. Mohon tunggu konfirmasi selanjutnya. Terima kasih telah bersedia bergabung di Koperasi Mitra Husada Mandiri ! 😊',
            'isGroup' => false,
            'secure' => false,
        ]);

        // Kirim pesan kepada nomor WhatsApp admin tambahan
        $whatsappNumbers = WhatsApp::where('position', 'Pinjaman')->pluck('phone');

        foreach ($whatsappNumbers as $number) {
            $response = Http::withHeaders([
                'Authorization' => $apiauthorization,
            ])->post($apiLink, [
                'key' => $apiKey,
                'phone' => $number,
                'message' => "📢 Pemberitahuan: Seseorang telah melakukan pengajuan menjadi anggota koperasi! 📢\n\n" . "Nama: {$anggota->nama}\n" . "No Anggota: {$anggota->no_anggota}\n" . "No HP: {$anggota->no_hp}\n\n" . "Silakan cek detail lebih lanjut di sistem dan lakukan langkah-langkah yang diperlukan melalui tautan berikut: https://app.mitrahusadamandiri.my.id\n\n" . 'Terima kasih atas perhatian dan kerjasamanya!',
                'isGroup' => false,
                'secure' => false,
            ]);

            if (!$response->successful()) {
                // Log error jika gagal mengirim pesan ke admin
                Log::error('Gagal mengirim pesan ke nomor admin: ' . $number);
            }
        }

        // Redirect dengan pesan sukses
        return redirect()->to(url('/peranggota/home'))->with('success', 'Data anggota berhasil diperbarui.');
    }
}