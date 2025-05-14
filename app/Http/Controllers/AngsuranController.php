<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Anggota;
use App\Models\Pinjaman;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan semua data angsuran dari database
        $angsurans = Angsuran::with('pinjaman.anggota')->get();

        // Mengembalikan view index dengan data angsuran
        return view('pages.angsuran.index', compact('angsurans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $today = \Carbon\Carbon::now();
        $prefix = 'AG-';
        $yearMonth = $today->format('Ymd');

        // Ambil angsuran terakhir
        $latestAngsuran = Angsuran::latest('created_at')->first();

        // Jika tidak ada angsuran sebelumnya, mulai dari nomor default
        if ($latestAngsuran) {
            $lastNumber = $latestAngsuran->no_angsuran;
        } else {
            $lastNumber = $prefix . $yearMonth . '-0000';
        }

        // Ambil 4 digit terakhir dari nomor angsuran terakhir
        $lastNumber = substr($lastNumber, -4);

        // Generate nomor angsuran berikutnya
        $nextNumber = str_pad((int) $lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $no_angsuran = $prefix . $yearMonth . '-' . $nextNumber;

        // Ambil semua data pinjaman
        $pinjamans = Pinjaman::with('anggota')->get();

        // Inisialisasi array untuk menyimpan angsuran ke untuk setiap pinjaman
        $angsuranKe = [];

        foreach ($pinjamans as $pinjaman) {
            // Hitung jumlah angsuran yang sudah ada untuk no_pinjaman tertentu
            $jumlahAngsuran = Angsuran::where('no_pinjaman', $pinjaman->no_pinjaman)->count();

            // Set nilai angsuran ke berikutnya berdasarkan jumlah angsuran yang ada
            $angsuranKe[$pinjaman->no_pinjaman] = $jumlahAngsuran + 1; // Nilai angsuran ke berikutnya
        }

        // Kirim data ke view
        return view('pages.angsuran.create', compact('no_angsuran', 'pinjamans', 'angsuranKe'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'no_angsuran' => 'required',
            'no_pinjaman' => 'required',
            'tgl_angsuran' => 'required|date',
            'nominal' => 'required|string', // Validasi awal sebagai string
            'angsuranke' => 'required|integer|min:1',
            'status' => 'required|string|in:lunas,belum',
        ]);

        // Konversi nilai nominal dari format string ke format numerik
        $nominal = $this->convertToNumber($request->input('nominal'));

        // Mengambil data pinjaman terkait untuk menghitung sisa pinjaman
        $pinjaman = Pinjaman::where('no_pinjaman', $request->input('no_pinjaman'))->first();

        // Jika pinjaman tidak ditemukan, kembalikan dengan error
        if (!$pinjaman) {
            return redirect()
                ->back()
                ->withErrors(['no_pinjaman' => 'Pinjaman tidak ditemukan.']);
        }

        // Hitung total nominal angsuran yang sudah dibayarkan
        $totalAngsuran = Angsuran::where('no_pinjaman', $request->input('no_pinjaman'))->sum('nominal');

        // Hitung sisa pinjaman
        $sisaPinjaman = $pinjaman->nominal - ($totalAngsuran + $nominal);

        // Update input request dengan nilai yang telah dikonversi dan sisa pinjaman
        $validatedData = $request->all();
        $validatedData['nominal'] = $nominal;
        $validatedData['sisa_pinjaman'] = $sisaPinjaman;

        // Membuat data angsuran baru
        Angsuran::create($validatedData);

        // Redirect ke halaman index angsuran dengan pesan sukses
        return redirect()->route('angsuran.index')->with('success', 'Angsuran berhasil ditambahkan.');
    }

    /**
     * Konversi format Rupiah ke angka numerik.
     *
     * @param  string  $value
     * @return int
     */

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
        // Mendapatkan angsuran berdasarkan ID
        $angsuran = Angsuran::findOrFail($id);

        // Mengembalikan view show dengan data angsuran
        return view('pages.angsuran.show', compact('angsuran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Mendapatkan angsuran dan data anggota untuk form edit
        $angsuran = Angsuran::findOrFail($id);
        $anggotas = Anggota::all();

        // Memformat data nominal
        $angsuran->nominal = $this->formatToRupiah($angsuran->nominal);

        // Mengembalikan view edit dengan data angsuran dan anggota
        return view('pages.angsuran.edit', compact('angsuran', 'anggotas'));
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
            'no_angsuran' => 'required',
            'no_pinjaman' => 'required',
            'tgl_angsuran' => 'required|date',
            'nominal' => 'required|string', // Validasi awal sebagai string
            'angsuranke' => 'required|integer|min:1',
            'status' => 'required|string|in:lunas,belum',
        ]);

        // Mengupdate data angsuran
        $angsuran = Angsuran::findOrFail($id);

        // Mengambil input dari request dan memformat nominal
        $data = $request->all();
        $data['nominal'] = $this->formatToDecimal($data['nominal']);

        // Mengupdate data angsuran
        $angsuran->update($data);

        // Redirect ke halaman index angsuran dengan pesan sukses
        return redirect()->route('angsuran.index')->with('success', 'Angsuran berhasil diperbarui.');
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
        // Menghapus angsuran berdasarkan ID
        $angsuran = Angsuran::findOrFail($id);
        $angsuran->delete();

        // Redirect ke halaman index angsuran dengan pesan sukses
        return redirect()->route('angsuran.index')->with('success', 'Angsuran berhasil dihapus.');
    }
    public function getAngsuranKe($no_pinjaman)
    {
        // Menghitung jumlah angsuran yang sudah ada untuk pinjaman tersebut
        $angsuranKe = Angsuran::where('no_pinjaman', $no_pinjaman)->count();

        // Mengembalikan hasil sebagai JSON
        return response()->json(['angsuran_ke' => $angsuranKe + 1]);
    }

    public function getSisaPinjaman($noPinjaman)
    {
        // Temukan angsuran terakhir berdasarkan no_pinjaman
        $lastAngsuran = Angsuran::where('no_pinjaman', $noPinjaman)->latest()->first();

        if ($lastAngsuran) {
            return response()->json(['sisa_pinjaman' => $lastAngsuran->sisa_pinjaman]);
        }

        return response()->json(['sisa_pinjaman' => null]); // Jika tidak ada, kembalikan null
    }
}
