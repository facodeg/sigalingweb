<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ApiWhatsapp;
use App\Models\WhatsApp;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // app/Http/Controllers/PinjamanController.php

    public function index()
    {
        // Mendapatkan semua data pinjaman dari database, termasuk data anggota dan angsuran terkait
        $pinjamans = Pinjaman::with(['anggota', 'angsuran'])->get();

        $pinjaman = Pinjaman::where('status', 'pending')->get();
        $totalajuanpinjaman = $pinjaman->count();

        // Mengembalikan view index dengan data pinjaman
        return view('pages.pinjaman.index', compact('pinjamans', 'totalajuanpinjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $today = \Carbon\Carbon::now();
        $prefix = 'PJ-';
        $yearMonth = $today->format('Ymd');

        // Ambil nomor terakhir
        $latestPinjaman = Pinjaman::latest('created_at')->first();
        $lastNumber = $latestPinjaman ? $latestPinjaman->no_pinjaman : $prefix . $yearMonth . '-0000';

        // Generate new number
        $lastNumber = substr($lastNumber, -4);
        $nextNumber = str_pad((int) $lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $no_pinjaman = $prefix . $yearMonth . '-' . $nextNumber;

        // Pass to view
        return view('pages.pinjaman.create', compact('no_pinjaman'))->with('anggotas', Anggota::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'no_pinjaman' => 'required',
            'no_anggota' => 'required',
            'tgl_pinjaman' => 'required|date',
            'nominal' => 'required|string', // Validasi awal sebagai string
            'tenor' => 'required|integer|min:1',
            'bayar_perbulan' => 'required|string', // Validasi awal sebagai string
            'tgl_selesai' => 'required|date|after_or_equal:tgl_pinjaman',
            'biaya_admin' => 'nullable|string', // Validasi awal sebagai string
            'alasan_pinjam' => 'required|string|max:255',
            'status' => 'required|string|in:pending,disetujui,ditolak,proses',
        ]);

        // Konversi nilai nominal, bayar_perbulan, dan biaya_admin dari format string ke format numerik
        $nominal = $this->convertToNumber($request->input('nominal'));
        $bayar_perbulan = $this->convertToNumber($request->input('bayar_perbulan'));
        $biaya_admin = $this->convertToNumber($request->input('biaya_admin'));

        // Update input request dengan nilai yang telah dikonversi
        $validatedData = $request->all();
        $validatedData['nominal'] = $nominal;
        $validatedData['bayar_perbulan'] = $bayar_perbulan;
        $validatedData['biaya_admin'] = $biaya_admin;

        // Membuat data pinjaman baru
        Pinjaman::create($validatedData);

        // Redirect ke halaman index pinjaman dengan pesan sukses
        return redirect()->route('pinjaman.index')->with('success', 'Pinjaman berhasil ditambahkan.');
    }

    // Fungsi untuk mengonversi string dengan format uang ke format angka
    protected function convertToNumber($value)
    {
        // Hapus karakter non-numerik kecuali koma dan titik
        $value = preg_replace('/[^\d,]/', '', $value);

        // Ganti koma dengan titik untuk konversi desimal jika diperlukan
        $value = str_replace(',', '.', $value);

        // Konversi ke float dan bulatkan ke angka bulat
        return (float) $value;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mendapatkan pinjaman berdasarkan ID
        $pinjaman = Pinjaman::findOrFail($id);

        // Mengembalikan view show dengan data pinjaman
        return view('pages.pinjaman.show', compact('pinjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Mendapatkan pinjaman dan data anggota untuk form edit
        // Mendapatkan pinjaman dan data anggota untuk form edit
        $pinjaman = Pinjaman::findOrFail($id);
        $anggotas = Anggota::all();

        // Memformat data nominal
        $pinjaman->nominal = $this->formatToRupiah($pinjaman->nominal);
        $pinjaman->bayar_perbulan = $this->formatToRupiah($pinjaman->bayar_perbulan);
        $pinjaman->biaya_admin = $this->formatToRupiah($pinjaman->biaya_admin);

        // Mengembalikan view edit dengan data pinjaman dan anggota
        return view('pages.pinjaman.edit', compact('pinjaman', 'anggotas'));
    }

    /**
     * Format nilai decimal ke Rupiah.
     *
     * @param float $value
     * @return string
     */
    protected function formatToRupiah($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'no_pinjaman' => 'required',
            'no_anggota' => 'required',
            'tgl_pinjaman' => 'required|date',
            'nominal' => 'required|string', // Validasi awal sebagai string
            'tenor' => 'required|integer|min:1',
            'bayar_perbulan' => 'required|string', // Validasi awal sebagai string
            'tgl_selesai' => 'required|date|after_or_equal:tgl_pinjaman',
            'biaya_admin' => 'nullable|string', // Validasi awal sebagai string
            'alasan_pinjam' => 'required|string|max:255',
            'status' => 'required|string|in:pending,disetujui,ditolak,proses',
        ]);

        // Mengupdate data pinjaman
        $pinjaman = Pinjaman::findOrFail($id);

        // Mengambil input dari request dan memformat nominal, bayar_perbulan, dan biaya_admin
        $data = $request->all();
        $data['nominal'] = $this->formatToDecimal($data['nominal']);
        $data['bayar_perbulan'] = $this->formatToDecimal($data['bayar_perbulan']);
        $data['biaya_admin'] = $this->formatToDecimal($data['biaya_admin']);

        // Mengupdate data pinjaman
        $pinjaman->update($data);

        // Redirect ke halaman index pinjaman dengan pesan sukses
        return redirect()->route('pinjaman.index')->with('success', 'Pinjaman berhasil diperbarui.');
    }

    /**
     * Format nilai Rupiah ke decimal.
     *
     * @param string $value
     * @return float
     */
    protected function formatToDecimal($value)
    {
        // Menghapus prefix 'Rp. ' dan mengganti titik dengan kosong, lalu mengonversi ke float
        return floatval(str_replace(['Rp. ', '.'], ['', ''], $value));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Menghapus pinjaman berdasarkan ID
        $pinjaman = Pinjaman::findOrFail($id);
        // Cek jika pinjaman memiliki angsuran terkait
        if ($pinjaman->angsuran()->count() > 0) {
            return redirect()->route('pinjaman.index')->with('error', 'Pinjaman tidak dapat dihapus karena masih memiliki angsuran terkait.');
        }
        $pinjaman->delete();

        // Redirect ke halaman index pinjaman dengan pesan sukses
        return redirect()->route('pinjaman.index')->with('success', 'Pinjaman berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $pinjaman = Pinjaman::findOrFail($id);

        // Validasi status pinjaman
        $request->validate([
            'status' => 'required|string|in:pending,disetujui,ditolak,proses',
        ]);

        // Ubah status pinjaman
        $pinjaman->status = $request->status;
        $pinjaman->save();

        // Ambil data anggota yang terkait dengan pinjaman ini
        $anggota = Anggota::where('no_anggota', $pinjaman->no_anggota)->firstOrFail();

        // Ambil API WhatsApp yang aktif
        $apiWhatsapp = ApiWhatsapp::where('status', 'aktif')->first();

        // Ambil kontak WhatsApp untuk posisi 'Pinjaman'
        $whatsappContact = WhatsApp::where('position', 'Pinjaman')->first();

        if (!$apiWhatsapp) {
            return redirect()->back()->with('error', 'API WhatsApp tidak tersedia.');
        }

        // Ambil data API WhatsApp
        $apiKey = $apiWhatsapp->key;
        $apiauthorization = $apiWhatsapp->authorization;
        $apiLink = $apiWhatsapp->links;

        // Mengirimkan pesan menggunakan API WhatsApp
        $response = Http::withHeaders([
            'Authorization' => $apiauthorization, // Authorization diambil dari model ApiWhatsapp
        ])->post($apiLink, [
            'key' => $apiKey,
            'phone' => $anggota->no_hp, // Nomor telepon anggota yang bersangkutan
            'message' => "🎉 Anggota Koperasi: **{$anggota->nama}**\n" . "🆔 No Anggota: **{$anggota->no_anggota}**\n\n" . "📄 Selamat! Pengajuan pinjaman Anda telah berstatus: **{$request->status}**.\n\n" . "📞 Jika ada pertanyaan, silakan hubungi **{$whatsappContact->name}** di nomor: **{$whatsappContact->phone}**.\n\n" . '🔗 Untuk informasi lebih lanjut, kunjungi: [Koperasi Mitra Husada Mandiri](https://app.mitrahusadamandiri.my.id)',
            'secure' => false,
        ]);

        // Cek apakah pengiriman pesan berhasil
        if ($response->successful()) {
            return response()->json(['message' => 'Status berhasil diubah dan pesan WhatsApp terkirim']);
        } else {
            return response()->json(['message' => 'Status berhasil diubah, tetapi pengiriman pesan WhatsApp gagal'], 500);
        }
    }
}