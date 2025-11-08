<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SipPengajuanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        ]);

        try {
            // Gunakan logic dari controller utama
            $result = \App\Http\Controllers\SipPengajuanController::issueLinkForWa([
                'nip' => $validated['karyawan_nip'],
                'nama' => $validated['nama'],
            ]);

            return response()->json(
                [
                    'ok' => true,
                    'id' => $result['id'],
                    'url' => $result['url'],
                    'note' => 'Link form SIP berhasil diterbitkan. Berlaku 7 hari & hanya bisa digunakan sekali.',
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