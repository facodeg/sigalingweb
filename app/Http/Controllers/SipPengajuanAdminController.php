<?php

namespace App\Http\Controllers;

use App\Models\SipRequest;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\SIP;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Services\SuratNumberGenerator;

class SipPengajuanAdminController extends Controller
{
    public function sendWa(Request $request, SIP $sip)
    {
        try {
            $karyawan = $sip->karyawan;
            if (!$karyawan) {
                return response()->json(['ok' => false, 'message' => 'Data karyawan tidak ditemukan.'], 404);
            }

            // Ambil NIP di karyawan -> cari user by email = NIP
            $nip = $karyawan->nip_nrp_nipppk_nipb ?? null;
            if (!$nip) {
                return response()->json(['ok' => false, 'message' => 'Kolom NIP karyawan tidak tersedia.'], 422);
            }

            $user = User::where('email', $nip)->first();
            if (!$user) {
                return response()->json(['ok' => false, 'message' => 'User tidak ditemukan untuk NIP tsb.'], 422);
            }
            if (!$user->phone) {
                return response()->json(['ok' => false, 'message' => 'Nomor WA (phone) pada user kosong.'], 422);
            }

            // ===== Normalisasi nomor -> 62xxxxxxxxxx@c.us =====
            $digits = preg_replace('/\D+/', '', $user->phone ?? '');
            if ($digits === '') {
                return response()->json(['ok' => false, 'message' => 'Nomor WA tidak valid.'], 422);
            }
            if (str_starts_with($digits, '00')) {
                // 0062... -> jadikan 62...
                $digits = ltrim($digits, '0');
            }
            if (str_starts_with($digits, '62')) {
                // sudah benar
            } elseif (str_starts_with($digits, '0')) {
                // 08xxxx -> 62xxxxx (buang 0 depan)
                $digits = '62' . substr($digits, 1);
            } elseif (str_starts_with($digits, '8')) {
                // 8xxxx -> 62xxxxx
                $digits = '62' . $digits;
            } else {
                // fallback: kalau +62 sudah dibuang + oleh preg_replace di atas, biasanya sudah 62...
            }
            $chatId = $digits . '@c.us';

            // ===== Hitung sisa hari & isi pesan =====
            $today = Carbon::today('Asia/Jakarta');
            $exp = $sip->tgl_expired ? Carbon::parse($sip->tgl_expired) : null;
            $sisa = $exp ? max(0, $today->diffInDays($exp, false)) : null;
            $expStr = $exp ? $exp->locale('id_ID')->translatedFormat('d F Y') : '-';
            $sisaStr = is_null($sisa) ? '—' : $sisa . ' hari';

            $text = "*Pengingat Masa Berlaku SIP*\n" . "Nama: *{$karyawan->nama}*\n" . "Jabatan: {$karyawan->jabatan_terakhir}\n" . "Ruangan: {$karyawan->ruangan}\n" . "Nomor SIP: *{$sip->nomor}*\n" . "Tgl Expired: *{$expStr}*\n" . "Sisa Waktu: *{$sisaStr}*\n\n" . "Mohon menyiapkan berkas untuk pengurusan perpanjangan SIP.\n" . 'Terima kasih 🙏';

            // ===== Kirim ke API WA =====
            $http = Http::retry(2, 500)->timeout(20);
            if (config('services.wa.skip_ssl_verify', false)) {
                $http = $http->withOptions(['verify' => false]);
            }

            $resp = $http->post('https://wahasigaling.sigaling.my.id/api/sendText', [
                'chatId' => $chatId,
                'text' => $text,
                'session' => 'default',
            ]);

            // Log dan teruskan detail saat gagal
            if (!$resp->ok()) {
                Log::warning('WA send failed', [
                    'status' => $resp->status(),
                    'body' => $resp->body(),
                    'sip_id' => $sip->id,
                    'chatId' => $chatId,
                ]);
                return response()->json(
                    [
                        'ok' => false,
                        'message' => 'Gagal mengirim pesan ke WhatsApp.',
                        'status' => $resp->status(),
                        'resp' => $resp->json() ?: $resp->body(),
                    ],
                    500,
                );
            }

            // Kalau API balas 200 tapi ada field error-nya sendiri
            $json = $resp->json();
            if (is_array($json) && isset($json['success']) && $json['success'] === false) {
                Log::warning('WA API logical failure', ['resp' => $json, 'chatId' => $chatId]);
                return response()->json(['ok' => false, 'message' => $json['message'] ?? 'Gagal mengirim pesan.'], 500);
            }

            return response()->json(['ok' => true, 'message' => 'Pesan terkirim.']);
        } catch (\Throwable $e) {
            Log::error('WA send exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'sip_id' => $sip->id ?? null,
            ]);
            return response()->json(
                [
                    'ok' => false,
                    'message' => 'Terjadi kesalahan saat mengirim pesan.',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Tampilkan daftar semua permintaan SIP.
     */
    public function index(Request $request)
    {
        $query = SipRequest::query();

        if ($request->filled('q')) {
            $q = (string) $request->get('q');
            $query->where(function ($qb) use ($q) {
                $qb->where('id', 'like', "%{$q}%")
                    ->orWhere('karyawan_nip', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%");
            });
        }

        // default paginate 12, jaga query string
        $requests = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        // opsional: karyawan Perawat/Bidan tanpa SIP (dipakai jika view butuh)
        $karyawanNoSip = Karyawan::query()
            ->where(function ($w) {
                $w->where('jabatan_terakhir', 'like', '%perawat%')->orWhere('jabatan_terakhir', 'like', '%bidan%');
            })
            ->whereDoesntHave('sipRequests') // pastikan relasi sipRequests() ada di model Karyawan
            ->orderBy('nama')
            ->get();

        return view('pages.pengajuansip.index', compact('requests', 'karyawanNoSip'));
    }

    /**
     * Tampilkan detail satu permintaan SIP.
     */

    /**
     * Form tambah permintaan SIP manual.
     */
    public function create()
    {
        return view('pages.pengajuansip.create');
    }

    /**
     * Simpan data baru dari form manual.
     */

    /**
     * Hapus data SIP.
     */

    protected $generator;

    public function __construct(SuratNumberGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function generateNomorSurat(string $id)
    {
        try {
            // muat record
            $sip = SipRequest::findOrFail($id);

            // optional: jika sudah ada nomor, Anda bisa mencegah overwrite atau tetap men-generate
            if (!empty($sip->no_surat)) {
                // jika ingin mencegah overwrite, uncomment:
                // return redirect()->back()->with('error', 'Nomor surat sudah ada: ' . $sip->no_surat);
            }

            // panggil service pembuat nomor surat (sesuaikan argumen sesuai implementasi service Anda)
            $result = $this->generator->createSurat($sip->nama, 'kepegawaian');

            if (empty($result) || empty($result['no_surat'])) {
                Log::warning('Generator returned empty result', ['sip_id' => $sip->id, 'result' => $result]);
                return redirect()->back()->with('error', 'Gagal membuat nomor surat (response kosong).');
            }

            // simpan hasil ke kolom no_surat — gunakan transaksi untuk aman
            DB::transaction(function () use ($sip, $result) {
                $sip->no_surat = $result['no_surat'];
                $sip->save();
            });

            return redirect()
                ->back()
                ->with('success', 'Nomor surat berhasil dibuat: ' . $result['no_surat']);
        } catch (\Throwable $e) {
            Log::error('Gagal generate nomor surat SIP: ' . $e->getMessage(), [
                'sip_id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Gagal membuat nomor surat. Silakan cek log.');
        }
    }

    public function uploadSigned(Request $request, $id)
    {
        $sip = SipRequest::findOrFail($id);

        $request->validate([
            'file_signed' => 'required|file|mimes:pdf|max:5120',
        ]);

        try {
            $file = $request->file('file_signed');
            $filename = 'sip_signed_' . $sip->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/sip_signed', $filename);

            // hapus lama jika ada
            if (!empty($sip->file_permohonan_signed)) {
                \Storage::delete('public/' . ltrim($sip->file_permohonan_signed, '/'));
            }

            $sip->file_permohonan_signed = 'sip_signed/' . $filename;
            $sip->save();

            return response()->json(['ok' => true, 'message' => 'File berhasil diupload', 'path' => $sip->file_permohonan_signed]);
        } catch (\Throwable $e) {
            \Log::error('UploadSigned error: ' . $e->getMessage());
            return response()->json(['ok' => false, 'message' => 'Gagal menyimpan file'], 500);
        }
    }

    public function sendSipSignedToWa(Request $request, SipRequest $sip)
{
    try {
        // ===== 1. Pastikan file signed tersedia =====
        if (!$sip->file_permohonan_signed) {
            return response()->json([
                'ok'      => false,
                'message' => 'File berkas pendukung SIP (signed) belum tersedia.'
            ], 422);
        }

        // ===== 2. Ambil nomor WA dari tabel sip_request =====
        if (!$sip->no_hp) {
            return response()->json([
                'ok'      => false,
                'message' => 'Nomor WA tidak tersedia di permohonan SIP.'
            ], 422);
        }

        // ===== 3. Normalisasi nomor =====
        $digits = preg_replace('/\D+/', '', $sip->no_hp);

        if ($digits === '') {
            return response()->json([
                'ok'      => false,
                'message' => 'Format nomor WA tidak valid.'
            ], 422);
        }

        // Konversi 08xxxx → 628xxxx
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62' . $digits;
        }

        $chatId = $digits . '@c.us';

        // ===== 4. URL file signed =====
        $urlSigned = asset('storage/' . ltrim($sip->file_permohonan_signed, '/'));

        // ===== 5. Pesan WhatsApp =====
        $nama = $sip->nama ?? "Pegawai";

        $text = "*Berkas Pendukung SIP*\n\n"
            . "Halo *{$nama}*,\n"
            . "Berkas pendukung pembuatan Surat Izin Praktik (SIP) Anda telah *selesai diproses*.\n\n"
            . "*Silakan unduh berkas di link berikut:*\n"
            . "{$urlSigned}\n\n"
            . "Terima kasih.\nRSUD Leuwiliang 🙏";

        // ===== 6. Kirim WA API =====
        $http = Http::retry(2, 500)->timeout(20);

        if (config('services.wa.skip_ssl_verify', false)) {
            $http = $http->withOptions(['verify' => false]);
        }

        $resp = $http->post('https://wahasigaling.sigaling.my.id/api/sendText', [
            'chatId'  => $chatId,
            'text'    => $text,
            'session' => 'default',
        ]);

        if (!$resp->ok()) {
            return response()->json([
                'ok'      => false,
                'message' => 'Gagal mengirim pesan WA.',
                'resp'    => $resp->body()
            ], 500);
        }

        return response()->json([
            'ok'      => true,
            'message' => 'Pesan WA berisi link file SIP Signed berhasil dikirim.'
        ]);

    } catch (\Throwable $e) {
        return response()->json([
            'ok'      => false,
            'message' => 'Terjadi kesalahan saat mengirim WA.',
            'error'   => $e->getMessage(),
        ], 500);
    }
}



}