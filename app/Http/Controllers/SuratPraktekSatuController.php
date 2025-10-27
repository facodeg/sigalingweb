<?php

namespace App\Http\Controllers;

use App\Models\SuratPraktekSatu;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Services\SuratNumberGenerator;
use Illuminate\Support\Facades\Log;

class SuratPraktekSatuController extends Controller
{
    public function index()
    {
        $data = SuratPraktekSatu::orderBy('created_at', 'desc')->get();
        return view('pages.surat_praktek_satu.index', compact('data'));
    }

    public function generateNomorSurat(Request $request): JsonResponse
    {
        try {
            $generator = new SuratNumberGenerator();

            // Ambil data nama dari input form
            // Karena nama field adalah praktikan_nama[], maka hasilnya array
            $praktikanNamaList = $request->input('praktikan_nama', []);

            // Jika hanya satu nama, bisa ambil index pertama
            $nama = $praktikanNamaList[0] ?? 'Tanpa Nama';

            // Panggil service generator
            $surat = $generator->createSurat($nama);

            return response()->json([
                'success' => true,
                'no_surat' => $surat['no_surat'],
                'nosurata' => $surat['nosurata'],
                'tahun' => $surat['tahun'],
            ]);
        } catch (\Throwable $e) {
            \Log::error('Gagal generate nomor surat praktek satu: ' . $e->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal generate nomor surat: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function create()
    {
        // Ambil data karyawan dari database
        $dataKaryawan = Karyawan::select('nama', 'nip_nrp_nipppk_nipb as nip', 'jabatan_terakhir as profesi', 'ruangan as unit', 'tmt_kerja_di_rsud as tmt')->get();

        // Siapkan JSON untuk JavaScript
        $dataKaryawanJson = $dataKaryawan
            ->map(function ($k) {
                return [
                    'nama' => $k->nama,
                    'nip' => $k->nip,
                    'profesi' => $k->profesi,
                    'unit' => $k->unit,
                    'tmt' => Carbon::parse($k->tmt)->translatedFormat('d F Y'),
                ];
            })
            ->values()
            ->toJson();

        // Kirim ke view
        return view('pages.surat_praktek_satu.create', [
            'dataKaryawan' => $dataKaryawan,
            'dataKaryawanJson' => $dataKaryawanJson,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_surat' => 'required|string|max:255',
            'no_surat' => 'required|string|max:255',
            'praktikan_nama' => 'required|array',
            'praktikan_nama.*' => 'required|string|max:255',
            'nip' => 'required|array',
            'nip.*' => 'nullable|string|max:255',
            'profesi' => 'required|array',
            'profesi.*' => 'nullable|string|max:255',
            'unit' => 'required|array',
            'unit.*' => 'nullable|string|max:255',
            'alamat_praktek' => 'required|string|max:255',
            'alamat_lengkap_praktek' => 'nullable|string|max:255',
            'hari_praktek' => 'nullable|string|max:255',
            'jam_efektif_mingguan' => 'nullable|numeric',
            'shift_pagi' => 'nullable|string|max:255',
            'shift_sore' => 'nullable|string|max:255',
            'shift_malam' => 'nullable|string|max:255',
            'tempat_dikeluarkan' => 'nullable|string|max:255',
            'tanggal_dikeluarkan' => 'nullable|date',
            'penanda_tangan_nama' => 'required|string|max:255',
            'penanda_tangan_nip' => 'required|string|max:255',
            'penanda_tangan_pangkat' => 'required|string|max:255',
            'penanda_tangan_jabatan' => 'required|string|max:255',
            'tmt' => 'nullable|max:255',
            'maksud' => 'nullable|',
        ]);

        $count = count($request->praktikan_nama);
        for ($i = 0; $i < $count; $i++) {
            \App\Models\SuratPraktekSatu::create([
                'nama_surat' => $request->nama_surat,
                'no_surat' => $request->no_surat,
                'praktikan_nama' => $request->praktikan_nama[$i],
                'nip' => $request->nip[$i] ?? null,
                'profesi' => $request->profesi[$i] ?? null,
                'unit' => $request->unit[$i] ?? null,
                'alamat_praktek' => $request->alamat_praktek,
                'alamat_lengkap_praktek' => $request->alamat_lengkap_praktek,
                'hari_praktek' => $count == 1 ? $request->hari_praktek : null,
                'jam_efektif_mingguan' => $count == 1 ? $request->jam_efektif_mingguan : null,
                'shift_pagi' => $count == 1 ? $request->shift_pagi : null,
                'shift_sore' => $count == 1 ? $request->shift_sore : null,
                'shift_malam' => $count == 1 ? $request->shift_malam : null,
                'tempat_dikeluarkan' => $request->tempat_dikeluarkan,
                'tanggal_dikeluarkan' => $request->tanggal_dikeluarkan,
                'penanda_tangan_nama' => $request->penanda_tangan_nama,
                'penanda_tangan_nip' => $request->penanda_tangan_nip,
                'penanda_tangan_pangkat' => $request->penanda_tangan_pangkat,
                'penanda_tangan_jabatan' => $request->penanda_tangan_jabatan,
                'tmt' => isset($request->tmt[$i]) ? Carbon::parse($request->tmt[$i])->format('Y-m-d') : null,
                'maksud' => $request->maksud,
                'status_surat' => 'proses',
            ]);
        }

        return redirect()->route('surat_praktek_satu.index')->with('success', 'Data surat praktek berhasil disimpan.');
    }

    public function show(SuratPraktekSatu $surat)
    {
        return view('pages.surat_praktek_satu.show', compact('surat'));
    }

    public function edit(string $id)
    {
        $surat = SuratPraktekSatu::findOrFail($id);
        return view('pages.surat_praktek_satu.edit', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'no_surat' => 'required|string|max:255',
            'penanda_tangan_nama' => 'required|string|max:255',
            'praktikan_nama' => 'required|string|max:255',
            'jam_efektif_mingguan' => 'nullable|numeric',
            'tanggal_dikeluarkan' => 'nullable|date',
            'profesi' => 'nullable|string|max:255',
            'tempat_dikeluarkan' => 'nullable|string|max:255',
        ]);

        // Ambil data surat langsung dari database
        $surat = SuratPraktekSatu::findOrFail($id);

        // Update data
        $surat->update([
            'no_surat' => $request->no_surat,
            'penanda_tangan_nama' => $request->penanda_tangan_nama,
            'praktikan_nama' => $request->praktikan_nama,
            'jam_efektif_mingguan' => $request->jam_efektif_mingguan,
            'tanggal_dikeluarkan' => $request->tanggal_dikeluarkan,
            'profesi' => $request->profesi,
            'tempat_dikeluarkan' => $request->tempat_dikeluarkan,
        ]);

        // Ambil data terbaru setelah update (optional tapi membantu debug)
        $updatedSurat = $surat->fresh();

        // Tampilkan hasil debug
        // Redirect jika tidak dd()
        return redirect()->route('surat_praktek_satu.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $surat = SuratPraktekSatu::findOrFail($id);
        $surat->delete();

        return redirect()->route('surat_praktek_satu.index')->with('success', 'Data berhasil dihapus.');
    }

    public function cetak(SuratPraktekSatu $surat)
    {
        return view('pages.surat_praktek_satu.cetak_surat_praktek', compact('surat'));
    }
    public function cetak2($id)
    {
        $surat = SuratPraktekSatu::findOrFail($id);

        // Ambil semua data dengan no_surat sama
        $dataPraktikan = SuratPraktekSatu::where('no_surat', $surat->no_surat)->get();

        return view('pages.surat_praktek_satu.cetak_surat_praktek2', compact('surat', 'dataPraktikan'));
    }

    public function updateStatus(Request $request)
    {
        $surat = \App\Models\SuratPraktekSatu::findOrFail($request->id);
        $surat->status_surat = $request->status;
        $surat->save();

        return response()->json(['message' => 'Status berhasil diperbarui']);
    }

    public function updateTanggal(Request $request)
    {
        $surat = SuratPraktekSatu::find($request->id);
        if (!$surat) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $surat->tanggal_dikeluarkan = $request->tanggal;
        $surat->save();

        return response()->json(['message' => 'Tanggal berhasil diperbarui.']);
    }

    public function cetakIzinAtasan($id)
    {
        $surat = SuratPraktekSatu::findOrFail($id);
        return view('pages.surat_praktek_satu.cetak_surat_izin_atasan', compact('surat'));
    }

    public function cetakHariJam($id)
    {
        $data = SuratPraktekSatu::findOrFail($id);
        return view('surat_praktek_satu.cetak_hari_dan_jam', compact('data'));
    }

    public function cetakKeterangan($id)
    {
        $surat = SuratPraktekSatu::with('karyawan')->findOrFail($id);
        return view('pages.surat_praktek_satu.cetak_surat_keterangan', compact('surat'));
    }
}