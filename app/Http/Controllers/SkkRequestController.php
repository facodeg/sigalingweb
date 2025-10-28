<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SkkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\SuratNumberGenerator;
use Barryvdh\DomPDF\Facade\Pdf;

class SkkRequestController extends Controller
{
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
        $surat = SkkRequest::with('karyawan')->findOrFail($id); // relasi opsional
        return view('pages.cetaksurat.surat_keterangan_kerja', compact('surat'));
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
