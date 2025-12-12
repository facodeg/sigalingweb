<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SkkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\SuratNumberGenerator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SkkRequestController extends Controller
{
    public function download($id)
    {
        $skk = SkkRequest::findOrFail($id);
        $path = ltrim($skk->file_surat_skk, '/');
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path);
        }
        abort(404);
    }

    public function sendWa($id)
    {
        $skk = SkkRequest::findOrFail($id);

        if (empty($skk->no_wa)) {
            return back()->with('error', 'Nomor WA belum diisi.');
        }
        if (empty($skk->file_surat_skk)) {
            return back()->with('error', 'File surat SKK belum tersedia.');
        }

        // --- Normalisasi chatId WA: 628xxx@c.us
        $chatId = preg_match('/@c\.us$/', $skk->no_wa) ? $skk->no_wa : preg_replace('/\D+/', '', $skk->no_wa) . '@c.us';

        // --- Bangun URL publik untuk file di storage
        // Pastikan file disimpan di disk "public" (storage/app/public/...)
        // dan sudah menjalankan: php artisan storage:link
        $rawPath = ltrim($skk->file_surat_skk, '/');

        // Jika sudah berupa URL penuh (mis. Google Drive), pakai apa adanya
        if (Str::startsWith($rawPath, ['http://', 'https://'])) {
            $downloadUrl = $rawPath;
        } else {
            // Coba akses via disk public
            // Contoh value di DB: "skk/surat_skk/nama_file.pdf"
            if (Storage::disk('public')->exists($rawPath)) {
                $downloadUrl = asset('storage/' . $rawPath);
            } else {
                // Fallback terakhir (opsional): route download privat
                // Pastikan Anda punya route('skk.download', $id) yang mengembalikan response()->download()
                $downloadUrl = route('skk.download', $skk->id);
            }
        }

        // --- Pesan WA yang rapi (pakai \n untuk baris baru)
        $text = "*Surat Keterangan Kerja (SKK) Selesai*\n\n" . "Halo *{$skk->nama}*,\n" . "No. Permohonan: *SKK-{$skk->id}*\n" . "Status: *Selesai diproses*\n\n" . "Silakan unduh surat pada tautan berikut:\n" . "{$downloadUrl}\n\n" . "_Jika tautan tidak bisa diklik, salin dan tempel ke browser Anda._\n" . 'Terima kasih.';

        try {
            $resp = Http::timeout(20)->post('https://wahasigaling.sigaling.my.id/api/sendText', [
                'chatId' => $chatId,
                'text' => $text,
                'session' => 'default',
            ]);

            if ($resp->successful()) {
                return back()->with('success', 'Pesan WhatsApp terkirim dengan tautan unduhan.');
            }

            return back()->with('error', 'Gagal kirim WA: ' . $resp->body());
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal kirim WA: ' . $e->getMessage());
        }
    }

    public function previewSurat($id): StreamedResponse
    {
        $surat = SkkRequest::findOrFail($id);
        abort_unless($surat->file_surat_skk, 404, 'File belum diunggah.');

        $path = $surat->file_surat_skk;
        abort_unless(Storage::disk('public')->exists($path), 404, 'Berkas tidak ditemukan.');

        $stream = Storage::disk('public')->readStream($path);
        $filename = 'Surat_SKK_' . ($surat->nama ?? $surat->id) . '.pdf';

        return response()->stream(
            function () use ($stream) {
                fpassthru($stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ],
        );
    }

    public function uploadSurat(Request $request)
    {
        try {
            $request->validate(
                [
                    'id' => 'required',
                    'file_surat_skk' => 'required|file|mimes:pdf|max:20480',
                ],
                [
                    'id.required' => 'ID tidak ditemukan.',
                    'file_surat_skk.required' => 'File wajib diunggah.',
                    'file_surat_skk.mimes' => 'Format file harus PDF.',
                    'file_surat_skk.max' => 'Ukuran file maksimal 20 MB.',
                ],
            );

            // Ambil data berdasarkan id
            $surat = SkkRequest::findOrFail($request->id);

            // Simpan file ke storage/public/skk/surat_skk/
            $path = $request->file('file_surat_skk')->store('skk/surat_skk', 'public');

            // Hapus file lama jika ada
            if ($surat->file_surat_skk && Storage::disk('public')->exists($surat->file_surat_skk)) {
                Storage::disk('public')->delete($surat->file_surat_skk);
            }

            // Simpan ke database
            $surat->file_surat_skk = $path;
            $surat->save();

            return back()->with('success', '✅ File Surat SKK berhasil diunggah.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal
            return back()
                ->with('error', '⚠️ Upload gagal: ' . $e->getMessage())
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            // Jika error lain (misal gagal simpan, permission, dsb)
            return back()->with('error', '❌ Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    protected $generator;

    public function __construct(SuratNumberGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function generateNomorSurat($id)
    {
        try {
            $req = SkkRequest::findOrFail($id);

            // Panggil service pembuat nomor surat
            $result = $this->generator->createSurat($req->nama, 'kepegawaian');

            // Simpan nomor surat ke tabel SKK lokal
            $req->nomor_surat = $result['no_surat'];
            $req->save();

            return redirect()
                ->back()
                ->with('success', 'Nomor surat berhasil dibuat: ' . $result['no_surat']);
        } catch (\Throwable $e) {
            Log::error('Gagal generate nomor surat SKK: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat nomor surat.');
        }
    }

    public function index()
    {
        $requests = SkkRequest::latest()->get();
        return view('pages.cetaksurat.skk_index', compact('requests'));
    }

    public function cetak($id)
    {
        $surat = SkkRequest::with('karyawan')->findOrFail($id);

        // Logo kiri dan kanan (opsional, bisa disesuaikan)
        $logoKiri = base64_encode(file_get_contents(public_path('assets/images/logo-kiri.png')));
        $logoKanan = base64_encode(file_get_contents(public_path('assets/images/logo-kanan.png')));

        // Generate PDF dari view surat_keterangan_kerja
        $pdf = Pdf::loadView('pages.cetaksurat.surat_keterangan_kerja', compact('surat', 'logoKiri', 'logoKanan'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        // Unduh file PDF dengan nama dinamis
        return $pdf->download('Surat_Keterangan_Kerja_' . ($surat->karyawan->nama ?? 'Pegawai') . '.pdf');
    }

    public function cetakajuan($id)
    {
        $surat = SkkRequest::with('karyawan')->findOrFail($id);

        $logoKiri = base64_encode(file_get_contents(public_path('assets/images/logo-kiri.png')));
        $logoKanan = base64_encode(file_get_contents(public_path('assets/images/logo-kanan.png')));

        $pdf = Pdf::loadView('pages.cetaksurat.surat_keterangan', compact('surat', 'logoKiri', 'logoKanan'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true, // jaga-jaga
            ]);

        return $pdf->download('Permohonan_SKK_' . ($surat->nama ?? 'Pegawai') . '.pdf');
    }

    public function create()
    {
        return view('CetakSurat.skk_create');
    }

    public function destroy($id)
    {
        try {
            $req = SkkRequest::findOrFail($id);
            $req->delete();

            return redirect()->route('skk.index')->with('success', 'Permintaan SKK berhasil dihapus.');
        } catch (\Throwable $e) {
            Log::error('Gagal hapus SKK: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus permintaan SKK.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_nip' => ['required', 'string', 'max:30'],
            'nama' => ['required', 'string', 'max:150'],
            'request_type' => ['nullable', 'string', 'max:50'], // contoh: 'SKK KPR'
            'keperluan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $data = [
                'karyawan_nip' => $validated['karyawan_nip'],
                'nama' => $validated['nama'],
                'request_type' => $validated['request_type'] ?? 'SKK',
                'keperluan' => $validated['keperluan'],
                'status' => 'DRAFT', // default awal
            ];

            // Opsional: catatan dan pesan_input jika kamu kirim dari WA/n8n
            if ($request->filled('catatan')) {
                $data['catatan'] = $request->string('catatan');
            }
            if ($request->filled('pesan_input')) {
                $data['pesan_input'] = $request->string('pesan_input');
            }

            SkkRequest::create($data);
            return redirect()->route('skk.index')->with('success', 'Permintaan SKK berhasil dibuat.');
        } catch (\Throwable $e) {
            Log::error('Gagal simpan SKK: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan permintaan SKK.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate(['status' => ['required', 'in:DRAFT,PENGAJUAN,DISETUJUI,DITOLAK']]);
        try {
            $req = SkkRequest::findOrFail($id);
            $req->status = $validated['status'];
            $req->save();
            return redirect()->route('skk.index')->with('success', 'Status permintaan diperbarui.');
        } catch (\Throwable $e) {
            Log::error('Gagal update status SKK: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui status.');
        }
    }
}
