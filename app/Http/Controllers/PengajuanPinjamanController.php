<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Anggota;
use App\Models\ApiWhatsapp;
use App\Models\WhatsApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PengajuanPinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userEmail = Auth::user()->email;
        $user = Auth::user();

        $anggota = Anggota::where('no_anggota', $user->email)->firstOrFail();

        // Mendapatkan semua data pinjaman dari database, termasuk data anggota dan angsuran terkait
        $pinjamans = Pinjaman::with(['anggota', 'angsuran'])
            ->whereHas('anggota', function ($query) use ($userEmail) {
                $query->where('no_anggota', $userEmail);
            })
            ->get();

        // Mengembalikan view index dengan data pinjaman
        return view('pages.pengajuanpinjaman.index', compact('pinjamans', 'anggota'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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

        // Ambil data anggota berdasarkan email pengguna yang sedang login
        $user = Auth::user();
        $anggotas = Anggota::where('no_anggota', $user->email)->get();

        if (!$anggotas) {
            // Handle the case where no Anggota record is found
            return redirect()
                ->back()
                ->withErrors(['msg' => 'Data anggota tidak ditemukan.']);
        }

        // Pass to view
        return view('pages.pengajuanpinjaman.create', compact('no_pinjaman', 'anggotas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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
            'status' => 'nullable|string', // Jangan validasi status di sini karena akan diatur di kode
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

        // Tetapkan status sebagai 'pending'
        $validatedData['status'] = 'pending';

        // Membuat data pinjaman baru
        $pinjaman = Pinjaman::create($validatedData);

        // Ambil data anggota berdasarkan no_anggota
        $anggota = Anggota::where('no_anggota', $request->no_anggota)->first();

        $apiWhatsapp = ApiWhatsapp::where('status', 'aktif')->first();
        if (!$apiWhatsapp) {
            return redirect()->back()->with('error', 'API WhatsApp tidak tersedia.');
        }

        $apiKey = $apiWhatsapp->key;
        $apiauthorization = $apiWhatsapp->authorization;
        $apiLink = $apiWhatsapp->links;

        // Pastikan anggota ditemukan sebelum melanjutkan
        if ($anggota) {
            $whatsappNumbers = WhatsApp::where('position', 'Pinjaman')->pluck('phone');
            $errorMessages = []; // Array untuk menyimpan pesan kesalahan

            // Kirim pesan melalui API WhatsApp untuk setiap nomor
            foreach ($whatsappNumbers as $number) {
                $response = Http::withHeaders([
                    'Authorization' => $apiauthorization,
                ])->post($apiLink, [
                    'key' => $apiKey,
                    'phone' => $number,
                    'message' => "📢 Pemberitahuan: Seseorang telah melakukan pengajuan pinjaman! 📢\n\n" . "Nama: {$anggota->nama}\n" . "No Anggota: {$anggota->no_anggota}\n" . "No HP: {$anggota->no_hp}\n\n" . "Untuk detail lebih lanjut, silakan kunjungi: https://app.mitrahusadamandiri.my.id\n" . 'Terima kasih atas perhatian Anda!',
                    'isGroup' => false,
                    'secure' => false,
                ]);

                if (!$response->successful()) {
                    // Menyimpan pesan kesalahan dalam array
                    $errorMessages[] = 'Gagal mengirim pesan ke nomor: ' . $number;
                }
            }

            // Jika ada pesan kesalahan, tampilkan
            if (!empty($errorMessages)) {
                return redirect()->back()->with('error', implode(', ', $errorMessages));
            }
        } else {
            // Jika anggota tidak ditemukan, Anda bisa mengirimkan pesan kesalahan atau melakukan log
            return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
        }

        // Redirect ke halaman index pinjaman dengan pesan sukses
        return redirect()->route('pengajuanpinjaman.index')->with('success', 'Pinjaman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Ambil data pinjaman berdasarkan ID
        $pinjaman = Pinjaman::findOrFail($id);

        // Ambil data anggota untuk dropdown
        $anggotas = Anggota::all();

        return view('pages.pengajuanpinjaman.edit', compact('pinjaman', 'anggotas'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'no_pinjaman' => 'required',
            'no_anggota' => 'required',
            'tgl_pinjaman' => 'required|date',
            'nominal' => 'required|string',
            'tenor' => 'required|integer|min:1',
            'bayar_perbulan' => 'required|string',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_pinjaman',
            'biaya_admin' => 'nullable|string',
            'alasan_pinjam' => 'required|string|max:255',
        ]);

        // Konversi nilai nominal, bayar_perbulan, dan biaya_admin dari format string ke format numerik
        $nominal = $this->convertToNumber($request->input('nominal'));
        $bayar_perbulan = $this->convertToNumber($request->input('bayar_perbulan'));
        $biaya_admin = $this->convertToNumber($request->input('biaya_admin'));

        // Update data pinjaman
        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->update([
            'no_anggota' => $request->input('no_anggota'),
            'tgl_pinjaman' => $request->input('tgl_pinjaman'),
            'nominal' => $nominal,
            'tenor' => $request->input('tenor'),
            'bayar_perbulan' => $bayar_perbulan,
            'tgl_selesai' => $request->input('tgl_selesai'),
            'biaya_admin' => $biaya_admin,
            'alasan_pinjam' => $request->input('alasan_pinjam'),
        ]);

        // Redirect ke halaman index pinjaman dengan pesan sukses
        return redirect()->route('pengajuanpinjaman.index')->with('success', 'Pinjaman berhasil diperbarui.');
    }

    /**
     * Convert a string with currency format to a numeric format.
     *
     * @param string $value
     * @return float
     */
    protected function convertToNumber($value)
    {
        // Hapus karakter non-numerik kecuali koma dan titik
        $value = preg_replace('/[^\d,]/', '', $value);

        // Ganti koma dengan titik untuk konversi desimal jika diperlukan
        $value = str_replace(',', '.', $value);

        // Konversi ke float dan bulatkan ke angka bulat
        return (float) $value;
    }

    public function destroy($id)
    {
        // Ambil data pinjaman berdasarkan ID
        $pinjaman = Pinjaman::findOrFail($id);

        // Periksa apakah status pinjaman adalah 'pending'
        if ($pinjaman->status !== 'pending') {
            return redirect()->route('pengajuanpinjaman.index')->with('error', 'Pinjaman hanya bisa dihapus jika statusnya adalah pending.');
        }

        // Hapus data pinjaman
        $pinjaman->delete();

        // Redirect ke halaman index pinjaman dengan pesan sukses
        return redirect()->route('pengajuanpinjaman.index')->with('success', 'Pinjaman berhasil dihapus.');
    }
}