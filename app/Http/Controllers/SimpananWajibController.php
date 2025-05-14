<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\ApiWhatsapp;
use App\Models\SimpananWajib;
use Http;
use Illuminate\Http\Request;

class SimpananWajibController extends Controller
{
    public function index()
    {
        // Mendapatkan tanggal sekarang
        $now = \Carbon\Carbon::now();

        // Mengambil data SimpananWajib dengan filter tanggal dan agregasi
        $simpananWajib = SimpananWajib::with('anggota')
            ->get()
            ->groupBy('no_anggota')
            ->map(function ($items, $noAnggota) use ($now) {
                // Ambil item pertama untuk mendapatkan tanggal dari no_anggota
                $item = $items->first();

                // Menghitung tanggal awal dari no_anggota
                $tanggalRaw = substr($noAnggota, 0, 8); // Ambil 8 karakter pertama
                $tanggalAwal = \Carbon\Carbon::createFromFormat('dmY', '01' . substr($tanggalRaw, 2, 6)); // Ubah menjadi format '01mmyyyy'
                $tanggalAwal01 = \Carbon\Carbon::createFromFormat('dmY', substr($noAnggota, 0, 8));

                // Hitung total nominal dan jumlah simpanan untuk setiap no_anggota dengan status 1
                $totalNominal = $items
                    ->where('status', 1)
                    ->whereBetween('tgl_simpanan', [$tanggalAwal, $now])
                    ->where('no_anggota', $noAnggota)
                    ->sum('nominal');

                $jumlahSimpanan = $items
                    ->where('status', 1)
                    ->whereBetween('tgl_simpanan', [$tanggalAwal, $now])
                    ->where('no_anggota', $noAnggota)
                    ->count();

                // Menghitung tanggal akhir dari simpanan
                $tanggalAkhir = SimpananWajib::where('no_anggota', $noAnggota)->max('tgl_simpanan');
                $tanggalAkhir = \Carbon\Carbon::parse($tanggalAkhir);

                // Menambahkan atribut total_nominal, jumlah_simpanan, dan tgl_tampil pada setiap item
                $item->total_nominal = $totalNominal;
                $item->jumlah_simpanan = $jumlahSimpanan;
                $item->tgl_tampil = $tanggalAwal01->format('d-m-Y') . ' sd ' . $tanggalAkhir->format('d-m-Y');
                $item->tanggal_akhir = $tanggalAkhir; // Menambahkan atribut tanggal_akhir untuk perbandingan

                return $item;
            });

        // Filter simpanan yang belum diupdate berdasarkan tanggal sekarang
        $simpananBelumUpdate = $simpananWajib->filter(function ($item) use ($now) {
            return $item->tanggal_akhir->lessThan($now);
        });

        // Mengirimkan data ke tampilan
        return view('pages.simpanan_wajib.index', compact('simpananWajib', 'simpananBelumUpdate'));
    }

    public function create()
    {
        return view('pages.simpanan_wajib.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_anggota' => 'required',
            'tgl_simpanan' => 'required|date',
            'nominal' => 'required|numeric',
            'status' => 'required|string',
        ]);

        SimpananWajib::create($request->all());
        return redirect()->route('simpanan_wajib.index')->with('success', 'Simpanan Wajib berhasil ditambahkan.');
    }

    public function edit(SimpananWajib $simpananWajib)
    {
        return view('pages.simpanan_wajib.edit', compact('simpananWajib'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_simpanan' => 'required|date',
            'nominal' => 'required|numeric',
            'status' => 'required|in:0,1',
        ]);

        $simpananWajib = SimpananWajib::findOrFail($id);
        $simpananWajib->tgl_simpanan = $request->tgl_simpanan;
        $simpananWajib->nominal = $request->nominal;
        $simpananWajib->status = $request->status;
        $simpananWajib->save();

        return redirect()->back()->with('success', 'Data simpanan berhasil diupdate.');
    }

    public function destroy($no_anggota)
    {
        // Cari data simpanan wajib berdasarkan no_anggota
        $simpananWajib = SimpananWajib::where('no_anggota', $no_anggota)->first();

        // Jika data ditemukan, hapus data tersebut
        if ($simpananWajib) {
            $simpananWajib->delete();
            return redirect()
                ->route('simpanan_wajib.index')
                ->with('success', 'Simpanan Wajib dengan No Anggota ' . $no_anggota . ' berhasil dihapus.');
        }

        // Jika data tidak ditemukan, kembalikan pesan error
        return redirect()
            ->route('simpanan_wajib.index')
            ->with('error', 'Data Simpanan Wajib dengan No Anggota ' . $no_anggota . ' tidak ditemukan.');
    }

    public function updateSimpanan()
    {
        // Ambil semua anggota dengan status 'aktif'
        $anggotaAktif = Anggota::where('status', 'aktif')
            ->whereNull('pembayaran') // Menambahkan kondisi pembayaran = null
            ->get();

        // Buat tanggal sekarang
        $tanggalSekarang = \Carbon\Carbon::now();

        // Loop melalui setiap anggota aktif
        foreach ($anggotaAktif as $anggota) {
            // Ambil no_anggota
            $noAnggota = $anggota->no_anggota;

            // Ambil tanggal dari no_anggota sebagai tanggal awal
            $tanggalAwal = \Carbon\Carbon::createFromFormat('d-m-Y', substr($noAnggota, 0, 2) . '-' . substr($noAnggota, 2, 2) . '-' . substr($noAnggota, 4, 4));

            // Loop dari tanggal awal sampai tanggal sekarang untuk setiap bulan pada tanggal 20
            while ($tanggalAwal->lessThanOrEqualTo($tanggalSekarang)) {
                // Set tanggal simpanan ke tanggal 20 di bulan yang sedang diiterasi
                $tanggalSimpanan = $tanggalAwal->copy()->day(20);

                // Hanya lanjutkan jika tanggal simpanan <= tanggal sekarang
                if ($tanggalSimpanan->greaterThan($tanggalSekarang)) {
                    break; // Berhenti jika tanggal simpanan lebih besar dari tanggal sekarang
                }

                // Cek apakah simpanan sudah ada untuk tanggal tersebut
                $existingSimpanan = SimpananWajib::where('no_anggota', $noAnggota)->whereDate('tgl_simpanan', $tanggalSimpanan)->first();

                // Jika belum ada simpanan pada tanggal tersebut, buat simpanan baru
                if (!$existingSimpanan) {
                    SimpananWajib::create([
                        'no_anggota' => $noAnggota,
                        'tgl_simpanan' => $tanggalSimpanan,
                        'nominal' => 30000,
                        'status' => 1,
                    ]);
                }

                // Tambah 1 bulan untuk iterasi berikutnya
                $tanggalAwal->addMonth();
            }
        }

        return redirect()->back()->with('success', 'Data simpanan berhasil diperbarui untuk semua anggota aktif.');
    }

    public function baru(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_anggota' => 'required|string|max:255',
            'tgl_simpanan' => 'required|date',
            'nominal' => 'required|numeric',
            'status1' => 'required|in:0,1', // Validasi input status1
            'keterangan' => 'nullable|string|max:255',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi file bukti
        ]);

        // Debugging untuk memastikan data diterima dengan benar

        // Menyimpan data Simpanan Wajib
        $simpananWajib = new SimpananWajib();
        $simpananWajib->no_anggota = $request->no_anggota;
        $simpananWajib->tgl_simpanan = $request->tgl_simpanan;
        $simpananWajib->nominal = $request->nominal;
        $simpananWajib->status = $request->status1; // Mapping status1 ke kolom status
        $simpananWajib->keterangan = $request->keterangan;

        // Menyimpan file bukti jika ada
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $path = $file->store('bukti-simpanan', 'public');
            $simpananWajib->bukti = $path;
        }

        // Simpan data ke database
        $simpananWajib->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Simpanan Wajib berhasil ditambahkan.');
    }

    public function kirimPesanSemua()
    {
        $now = \Carbon\Carbon::now();
        $simpananWajib = SimpananWajib::with('anggota')
            ->get()
            ->groupBy('no_anggota')
            ->map(function ($items, $noAnggota) use ($now) {
                $item = $items->first();
                $totalNominal = $items->sum('nominal');
                $jumlahSimpanan = $items->count();

                // Mengambil tanggal awal dan akhir dari simpanan
                $tanggalAwal01 = SimpananWajib::where('no_anggota', $noAnggota)->min('tgl_simpanan');
                $tanggalAkhir = SimpananWajib::where('no_anggota', $noAnggota)->max('tgl_simpanan');

                // Menambahkan atribut
                $item->total_nominal = $totalNominal;
                $item->jumlah_simpanan = $jumlahSimpanan;
                $item->tgl_tampil = \Carbon\Carbon::parse($tanggalAwal01)->format('d-m-Y') . ' sd ' . \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y');

                return $item;
            });

        $apiWhatsapp = ApiWhatsapp::where('status', 'aktif')->first();
        if (!$apiWhatsapp) {
            return redirect()->back()->with('error', 'API WhatsApp tidak tersedia.');
        }

        // Inisialisasi penghitung
        $pesanTerkirim = 0;
        $pesanGagal = 0;

        foreach ($simpananWajib as $simpanan) {
            $anggota = $simpanan->anggota;
            if ($anggota && !empty($anggota->no_hp)) {
                $message = "Halo {$anggota->nama},\n\n" . "Terima kasih telah menjadi bagian dari kami. Berikut adalah rincian simpanan Anda:\n" . "- No Anggota: {$anggota->no_anggota}\n" . '- Total Simpanan: Rp ' . number_format($simpanan->total_nominal, 0, ',', '.') . "\n" . "- Jumlah Simpanan Perbulan : {$simpanan->jumlah_simpanan} Bulan \n" . "- Periode: {$simpanan->tgl_tampil}\n\n" . "Untuk melihat rincian lebih lanjut, silakan kunjungi tautan berikut:\n" . "https://app.mitrahusadamandiri.my.id\n\n" . 'Salam hangat, Mitra Husada Mandiri.';

                try {
                    // Mengirim pesan ke nomor WhatsApp
                    $this->sendWhatsAppMessage($anggota->no_hp, $message, $apiWhatsapp);
                    $pesanTerkirim++; // Pesan berhasil dikirim
                } catch (\Exception $e) {
                    $pesanGagal++; // Pesan gagal dikirim
                }

                // Menambahkan jeda 2 detik sebelum mengirim pesan berikutnya
                sleep(2);
            }
        }

        // Mengirimkan notifikasi jumlah pesan yang berhasil dan gagal
        return redirect()
            ->back()
            ->with('success', "Pesan berhasil dikirim: $pesanTerkirim, Pesan gagal dikirim: $pesanGagal.");
    }

    // Kirim pesan ke anggota tertentu
    public function kirimPesan($no_anggota)
    {
        $simpanan = SimpananWajib::where('no_anggota', $no_anggota)->with('anggota')->first();
        if (!$simpanan) {
            return redirect()->back()->with('error', 'Data simpanan tidak ditemukan.');
        }

        $anggota = $simpanan->anggota;
        if (!$anggota || empty($anggota->no_hp)) {
            return redirect()->back()->with('error', 'Nomor HP anggota tidak tersedia.');
        }

        $apiWhatsapp = ApiWhatsapp::where('status', 'aktif')->first();
        if (!$apiWhatsapp) {
            return redirect()->back()->with('error', 'API WhatsApp tidak tersedia.');
        }

        $message = "Data Simpanan: No Anggota: {$anggota->no_anggota}, Nama: {$anggota->nama}, Total Simpanan: Rp " . number_format($simpanan->total_nominal, 0, ',', '.');
        $this->sendWhatsAppMessage($anggota->no_hp, $message, $apiWhatsapp);

        return redirect()->back()->with('success', 'Pesan telah dikirim ke anggota.');
    }

    // Helper function to send message
    protected function sendWhatsAppMessage($number, $message, $apiWhatsapp)
    {
        Http::withHeaders(['Authorization' => $apiWhatsapp->authorization])->post($apiWhatsapp->links, [
            'key' => $apiWhatsapp->key,
            'phone' => $number,
            'message' => $message,
            'isGroup' => false,
            'secure' => false,
        ]);
    }
}