<?php

namespace App\Http\Controllers;

use App\Models\SipLink;
use App\Models\SipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SipPengajuanController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $status = $request->get('status');
        $from = $request->get('from'); // YYYY-MM-DD
        $to = $request->get('to'); // YYYY-MM-DD

        $rows = SipRequest::query()
            ->when($q !== '', function ($qry) use ($q) {
                $qry->where(function ($w) use ($q) {
                    $w->where('id', 'like', "%{$q}%")
                        ->orWhere('karyawan_nip', 'like', "%{$q}%")
                        ->orWhere('nama', 'like', "%{$q}%");
                });
            })
            ->when($status, fn($qry) => $qry->where('status', $status))
            ->when($from, function ($qry) use ($from) {
                $qry->whereDate('created_at', '>=', $from);
            })
            ->when($to, function ($qry) use ($to) {
                $qry->whereDate('created_at', '<=', $to);
            })
            ->latest('created_at')
            ->paginate(12);

        return view('pages.pengajuansip.index', compact('rows'));
    }

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
    // public function submitForm(Request $req, string $token)
    // {
    //     $row = SipLink::where('token', hash('sha256', $token))->firstOrFail();
    //     abort_if($row->used, 410, 'Link sudah digunakan');
    //     abort_if($row->expires_at && now('Asia/Jakarta')->gt($row->expires_at), 410, 'Link kedaluwarsa');

    //     $data = $req->validate([
    //         'profesi' => 'required|string|max:80',
    //         'tempat_lahir' => 'required|string|max:80',
    //         'tanggal_lahir' => 'required|date',
    //         'nik' => 'required|string|max:32',
    //         'no_str' => 'required|string|max:64',
    //         'str_berlaku_sampai' => 'required|date',
    //         'alamat_rumah' => 'required|string',
    //         'no_hp' => 'required|string|max:30',
    //         'lulusan' => 'required|string|max:120',
    //         'tahun_lulus' => 'required|string|size:4',
    //     ]);

    //     DB::transaction(function () use ($row, $data) {
    //         $sip = SipRequest::lockForUpdate()->findOrFail($row->sip_id);
    //         $sip->fill($data);
    //         $sip->status = 'PENGAJUAN';
    //         $sip->save();

    //         $row->used = true; // kunci link (sekali pakai)
    //         $row->save();
    //     });

    //     return view('pages.sip.success', [
    //         'sip' => SipRequest::find($row->sip_id),
    //     ]);
    // }

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

        // Ambil ulang data SIP
        $sip = SipRequest::findOrFail($row->sip_id);

        // Bangun URL cetak
        $baseUrl = rtrim(config('app.url', 'http://app.sigaling.my.id'), '/');
        $pdfUrl = $baseUrl . '/pengajuansip/' . $sip->id . '/cetak-pdf';
        $keabsahanUrl = $baseUrl . '/pengajuansip/' . $sip->id . '/cetak-keabsahan';

        // ============================
        // 🔍 NORMALISASI NOMOR WHATSAPP
        // ============================

        $raw = $sip->no_hp ?? ($data['no_hp'] ?? null);
        if (!empty($raw)) {
            // Hapus karakter selain angka
            $clean = preg_replace('/\D+/', '', $raw); // contoh: "0812-345-678" → "0812345678"

            // Jika diawali "08" → ubah jadi "628"
            if (preg_match('/^0[8]/', $clean)) {
                $clean = '62' . substr($clean, 1);
            }

            // Jika diawali "8" → ubah jadi "62"
            if (preg_match('/^8/', $clean)) {
                $clean = '62' . $clean;
            }

            // Jika sudah @c.us, tetap dipakai apa adanya
            $chatId = preg_match('/@c\.us$/', $raw) ? $raw : $clean . '@c.us';

            // ============================
            // 📝 SUSUN PESAN WA
            // ============================

            $text = "Pengajuan SIP Anda sudah kami terima ✅\n\n";
            $text .= "Silakan unduh berkas pendukung pembuatan SIP melalui tautan berikut:\n";
            $text .= "📄 Surat permohonan SIP (PDF): {$pdfUrl}\n";
            $text .= "🔍 Surat keterangan keabsahan: {$keabsahanUrl}\n\n";
            $text .= 'Mohon dicetak, ditandatangani, dan dilengkapi sesuai ketentuan yang berlaku di RSUD Leuwiliang.';

            // ============================
            // 📤 KIRIM PESAN WA
            // ============================
            try {
                $resp = Http::timeout(20)->post('https://wahasigaling.sigaling.my.id/api/sendText', [
                    'chatId' => $chatId,
                    'text' => $text,
                    'session' => 'default',
                ]);

                if (!$resp->ok()) {
                    Log::warning('Gagal mengirim WA SIP (submitForm): ' . $resp->body());
                }
            } catch (\Throwable $waEx) {
                Log::error('Exception kirim WA SIP (submitForm): ' . $waEx->getMessage());
            }
        }

        return view('pages.sip.success', [
            'sip' => $sip,
        ]);
    }

    public function cetakPdf($id)
    {
        $sip = SipRequest::with('karyawan')->findOrFail($id);

        $logoKiriPath = public_path('assets/images/logo-kiri.png');
        $logoKananPath = public_path('assets/images/logo-kanan.png');

        $logoKiri = file_exists($logoKiriPath) ? base64_encode(file_get_contents($logoKiriPath)) : null;
        $logoKanan = file_exists($logoKananPath) ? base64_encode(file_get_contents($logoKananPath)) : null;

        $fileSigned = null;
        if (!empty($sip->file_permohonan_signed) && file_exists(storage_path('app/public/' . $sip->file_permohonan_signed))) {
            $fileSigned = base64_encode(file_get_contents(storage_path('app/public/' . $sip->file_permohonan_signed)));
        }

        try {
            $pdf = Pdf::loadView('pages.pengajuansip.surat_keterangan_praktik', [
                'sip' => $sip,
                'logoKiri' => $logoKiri,
                'logoKanan' => $logoKanan,
                'fileSigned' => $fileSigned,
            ])
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                ]);
        } catch (\Exception $e) {
            // log dan fallback pesan singkat
            \Log::error('PDF generation failed for SIP ' . $id . ': ' . $e->getMessage());
            abort(500, 'Gagal membuat PDF. Periksa log server.');
        }

        $safeName = Str::slug($sip->nama ?? 'surat', '_');
        $filename = "Surat_Keterangan_Praktik_{$safeName}.pdf";

        // jika ingin buka di browser: return $pdf->stream($filename);
        return $pdf->download($filename);
    }

    public function cetakKeabsahan(string $id)
    {
        $sip = SipRequest::with('karyawan')->findOrFail($id);

        // Siapkan logo (base64) — aman untuk DOMPDF
        $logoKiriPath = public_path('assets/images/logo-kiri.png');
        $logoKananPath = public_path('assets/images/logo-kanan.png');

        $logoKiri = file_exists($logoKiriPath) ? base64_encode(file_get_contents($logoKiriPath)) : null;
        $logoKanan = file_exists($logoKananPath) ? base64_encode(file_get_contents($logoKananPath)) : null;

        // Tanda tangan/pemohon (opsional) — diasumsikan file berada di storage/app/public/
        $fileSigned = null;
        if (!empty($sip->file_permohonan_signed) && file_exists(storage_path('app/public/' . $sip->file_permohonan_signed))) {
            $fileSigned = base64_encode(file_get_contents(storage_path('app/public/' . $sip->file_permohonan_signed)));
        }

        try {
            $pdf = Pdf::loadView('pages.pengajuansip.surat_keabsahan_data', [
                'sip' => $sip,
                'logoKiri' => $logoKiri,
                'logoKanan' => $logoKanan,
                'fileSigned' => $fileSigned,
            ])
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                ]);
        } catch (\Throwable $e) {
            Log::error('PDF generation (keabsahan) failed for SIP ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat PDF keabsahan. Periksa log server.');
        }

        $safeName = Str::slug($sip->nama ?? ($sip->id ?? 'keabsahan'), '_');
        $filename = "Surat_Pernyataan_Keabsahan_{$safeName}.pdf";

        return $pdf->download($filename);
    }

    public function cetakPraktek(string $id)
    {
        $start = microtime(true);
        $sip = SipRequest::with('karyawan')->findOrFail($id);

        // siapkan logo (base64) - pakai file kecil/terkompres agar cepat
        $logoKiriPath = public_path('assets/images/logo-kiri.png');
        $logoKananPath = public_path('assets/images/logo-kanan.png');

        $logoKiri = null;
        $logoKanan = null;

        try {
            if (file_exists($logoKiriPath)) {
                $logoKiri = base64_encode(file_get_contents($logoKiriPath));
            }
            if (file_exists($logoKananPath)) {
                $logoKanan = base64_encode(file_get_contents($logoKananPath));
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to read logo: ' . $e->getMessage());
        }

        $afterAssets = microtime(true);
        Log::info('cetakPraktek: asset prepare took: ' . round($afterAssets - $start, 3) . 's');

        // ttd (signed file) - prefer storage/app/public/...
        $fileSigned = null;
        try {
            if (!empty($sip->file_permohonan_signed)) {
                $signedPath = storage_path('app/public/' . $sip->file_permohonan_signed);
                if (file_exists($signedPath)) {
                    $fileSigned = base64_encode(file_get_contents($signedPath));
                }
            }

            // fallback: jika tidak ada, coba public assets
            if (empty($fileSigned)) {
                $localTtd = public_path('assets/images/ttd-vitrie.jpg');
                if (file_exists($localTtd)) {
                    $fileSigned = base64_encode(file_get_contents($localTtd));
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to read ttd: ' . $e->getMessage());
        }

        $afterTtd = microtime(true);
        Log::info('cetakPraktek: ttd prepare took: ' . round($afterTtd - $afterAssets, 3) . 's');

        // generate view -> PDF
        $viewData = [
            'sip' => $sip,
            'logoKiri' => $logoKiri,
            'logoKanan' => $logoKanan,
            'fileSigned' => $fileSigned,
        ];

        // buat folder sementara untuk menyimpan pdf
        $tmpDir = storage_path('app/public/pdfs');
        if (!file_exists($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        $safeName = Str::slug($sip->nama ?? ($sip->id ?? 'surat'), '_');
        $tmpFile = $tmpDir . "/Surat_Praktek_{$safeName}_" . time() . '.pdf';

        try {
            $pdf = Pdf::loadView('pages.pengajuansip.surat_keterangan_praktek', $viewData)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => false, // kita pakai base64 sehingga remote tidak perlu
                ]);

            // render output dan simpan file sementara (memaksa DOMPDF selesai render)
            file_put_contents($tmpFile, $pdf->output());
        } catch (\Throwable $e) {
            Log::error('PDF generation failed for SIP ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat PDF. Periksa log server.');
        }

        $afterRender = microtime(true);
        Log::info('cetakPraktek: render and save took: ' . round($afterRender - $afterTtd, 3) . 's');
        Log::info('cetakPraktek: total took: ' . round($afterRender - $start, 3) . 's');

        // kembalikan file dengan header Content-Length (download manager jadi tahu ukuran)
        return response()->download($tmpFile)->deleteFileAfterSend(true);
    }
}