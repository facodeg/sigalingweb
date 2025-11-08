<?php

namespace App\Http\Controllers;

use App\Models\SipLink;
use App\Models\SipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SipPengajuanController extends Controller
{
    /**
     * Dipanggil dari WA/n8n → buat ID, Token, dan Link (input hanya NIP & Nama).
     */
    public static function issueLinkForWa(array $seed): array
    {
        // Validasi ringan sisi server (kalau dipakai dari API, lakukan Request validate)
        $nip = (string) ($seed['nip'] ?? '');
        $nama = (string) ($seed['nama'] ?? '');

        // Atomic
        [$sip, $plainToken] = DB::transaction(function () use ($nip, $nama) {
            // Generate ID unik
            do {
                $id = 'SIPREQ-' . now('Asia/Jakarta')->format('Ymd') . '-' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            } while (SipRequest::whereKey($id)->exists());

            $sip = SipRequest::create([
                'id' => $id,
                'karyawan_nip' => $nip,
                'nama' => $nama,
                'status' => 'DRAFT',
            ]);

            $plainToken = Str::random(48);

            SipLink::create([
                'sip_id' => $sip->id,
                'token' => hash('sha256', $plainToken),
                'expires_at' => now('Asia/Jakarta')->addDays(7), // konsisten TZ
                'used' => false,
            ]);

            return [$sip, $plainToken];
        });

        return [
            'id' => $sip->id,
            'url' => url('/sip/f/' . $plainToken), // token asli hanya di URL
        ];
    }

    /**
     * Tampilkan form pengisian berdasarkan token
     */
    public function showForm(string $token)
    {
        $row = SipLink::where('token', hash('sha256', $token))->first();
        abort_if(!$row, 404, 'Link tidak ditemukan');
        abort_if($row->used, 410, 'Link sudah digunakan');
        abort_if($row->expires_at && now('Asia/Jakarta')->gt($row->expires_at), 410, 'Link kedaluwarsa');

        $sip = SipRequest::findOrFail($row->sip_id);

        return view('pages.sip.form', [
            'sip' => $sip,
            'token' => $token,
        ]);
    }

    /**
     * Simpan data lengkap dari form dan kunci link (sekali pakai)
     */
    public function submitForm(Request $req, string $token)
    {
        $row = SipLink::where('token', hash('sha256', $token))->firstOrFail();
        abort_if($row->used, 410, 'Link sudah digunakan');
        abort_if($row->expires_at && now('Asia/Jakarta')->gt($row->expires_at), 410, 'Link kedaluwarsa');

        $data = $req->validate([
            'profesi' => 'required|string|max:80',
            'tempat_lahir' => 'required|string|max:80',
            'tanggal_lahir' => 'required|date',
            'nik' => 'required|string|max:32',
            'no_str' => 'required|string|max:64',
            'str_berlaku_sampai' => 'required|date',
            'alamat_rumah' => 'required|string',
            'no_hp' => 'required|string|max:30',
            'lulusan' => 'required|string|max:120',
            'tahun_lulus' => 'required|string|size:4',
        ]);

        DB::transaction(function () use ($row, $data) {
            $sip = SipRequest::lockForUpdate()->findOrFail($row->sip_id);
            $sip->fill($data);
            $sip->status = 'PENGAJUAN';
            $sip->save();

            $row->used = true; // kunci link (sekali pakai)
            $row->save();
        });

        return view('pages.sip.success', [
            'sip' => SipRequest::find($row->sip_id),
        ]);
    }
}