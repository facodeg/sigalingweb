<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\SipPengajuanController;

class SipIssueApiController extends Controller
{
    /**
     * Endpoint API untuk menerbitkan Link SIP baru (dipanggil dari n8n/WA).
     * Method: POST /api/sip/issue
     */
    public function issue(Request $request)
    {
        // Validasi input WA
        $validated = $request->validate([
            'karyawan_nip' => 'required|string|max:32',
            'nama' => 'required|string|max:120',
            'no_hp' => 'required|string|max:32', // nomor WA pemohon
        ]);

        try {
            // Gunakan logic dari controller utama
            $result = SipPengajuanController::issueLinkForWa([
                'nip' => $validated['karyawan_nip'],
                'nama' => $validated['nama'],
            ]);

            // Catatan standar link SIP
            $note = 'Link form SIP berhasil diterbitkan. Berlaku 7 hari & hanya bisa digunakan sekali.';

            // Siapkan chatId WA dari no_hp
            $rawNoWa = $validated['no_hp'];
            $chatId = preg_match('/@c\.us$/', $rawNoWa) ? $rawNoWa : preg_replace('/\D+/', '', $rawNoWa) . '@c.us';

            // Susun teks WA dari respon
            $text = "Link Form SIP Anda telah diterbitkan ✅\n\n";
            $text .= "🆔 Kode: {$result['id']}\n";
            $text .= "🔗 {$result['url']}\n\n";
            $text .= "Silakan buka tautan di atas untuk mengisi Formulir SIP Anda sesuai data yang diminta.\n";
            $text .= $note;

            // Kirim pesan WA ke pemohon (non-blocking: error WA tidak menggagalkan API utama)
            try {
                $resp = Http::timeout(20)->post('https://wahasigaling.sigaling.my.id/api/sendText', [
                    'chatId' => $chatId,
                    'text' => $text,
                    'session' => 'default',
                ]);

                if (!$resp->ok()) {
                    Log::warning('Gagal mengirim WA SIP: ' . $resp->body());
                }
            } catch (\Throwable $waEx) {
                Log::error('Exception kirim WA SIP: ' . $waEx->getMessage());
            }

            // Respon ke caller (n8n/WhatsApp bot)
            return response()->json(
                [
                    'ok' => true,
                    'id' => $result['id'],
                    'url' => $result['url'],
                    'note' => $note,
                ],
                201,
            );
        } catch (\Throwable $e) {
            Log::error('Gagal menerbitkan link SIP: ' . $e->getMessage());

            return response()->json(
                [
                    'ok' => false,
                    'error' => 'Gagal membuat link SIP. Silakan coba lagi.',
                    'msg' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}