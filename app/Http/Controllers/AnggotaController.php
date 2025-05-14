<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Angsuran;
use App\Models\Pinjaman;
use App\Models\SimpananWajib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AnggotaController extends Controller
{
    // Menampilkan daftar anggota
    public function index()
    {
        $anggotas = Anggota::orderBy('created_at', 'desc')->get();
        $totalManual = $anggotas->where('pembayaran', '1')->count();
        $totalOtomatis = $anggotas->where('pembayaran', '!=', '1')->count();
        return view('pages.anggotas.index', compact('anggotas', 'totalManual', 'totalOtomatis'));
    }

    public function contoh()
    {
        // Mengambil semua data anggota
        $anggotas = Anggota::all();

        // Menghitung jumlah anggota yang diproses
        $totalProses = 0;

        // Menambahkan status 'Proses' pada setiap anggota
        foreach ($anggotas as $anggota) {
            $anggota->status = 'Proses';
            $totalProses++;
        }

        // Mengirimkan data ke view beserta total anggota
        return view('pages.anggotas.daftar', compact('anggotas', 'totalProses'));
    }

    // Menampilkan form untuk membuat anggota baru
    public function create()
    {
        return view('pages.anggotas.create');
    }

    // Menyimpan anggota baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'no_anggota' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'nip_nipb_nrptt' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer',
            'nik' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'status_kepegawaian' => 'required|string|max:255',
            'status_pernikahan' => 'required|string|max:255',
            'simpanan_pokok' => 'required|numeric',
            'simpanan_wajib' => 'required|numeric',
            'waktu_pembayaran' => 'required|numeric',
            'no_hp' => 'required|string|max:20',
            'upload_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'upload_foto_diri' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $anggota = new Anggota();
        $anggota->no_anggota = $request->no_anggota;
        $anggota->nama = $request->nama;
        $anggota->nip_nipb_nrptt = $request->nip_nipb_nrptt;
        $anggota->tempat_lahir = $request->tempat_lahir;
        $anggota->tanggal_lahir = $request->tanggal_lahir;
        $anggota->umur = $request->umur;
        $anggota->nik = $request->nik;
        $anggota->alamat = $request->alamat;
        $anggota->unit_kerja = $request->unit_kerja;
        $anggota->status_kepegawaian = $request->status_kepegawaian;
        $anggota->status_pernikahan = $request->status_pernikahan;
        $anggota->simpanan_pokok = $request->simpanan_pokok;
        $anggota->simpanan_wajib = $request->simpanan_wajib;
        $anggota->waktu_pembayaran = $request->waktu_pembayaran;
        $anggota->no_hp = $request->no_hp;

        // Menangani upload file
        if ($request->hasFile('upload_ktp')) {
            $file = $request->file('upload_ktp');
            $path = $file->store('ktp', 'public');
            $anggota->upload_ktp = $path;
        }

        if ($request->hasFile('upload_foto_diri')) {
            $file = $request->file('upload_foto_diri');
            $path = $file->store('foto_diri', 'public');
            $anggota->upload_foto_diri = $path;
        }

        $anggota->save();

        return redirect()->route('anggotas.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    // Menampilkan detail anggota
    public function show(Anggota $anggota)
    {
        return view('pages.anggotas.show', compact('anggota'));
    }

    // Menampilkan form untuk mengedit anggota
    public function edit(Anggota $anggota)
    {
        return view('pages.anggotas.edit', compact('anggota'));
    }

    // Mengupdate data anggota di database
    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'no_anggota' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'nip_nipb_nrptt' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer',
            'nik' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'unit_kerja' => 'nullable|string|max:255', // Mengubah menjadi nullable
            'status_kepegawaian' => 'required|string|max:255',
            'status_pernikahan' => 'required|string|max:255',
            'simpanan_pokok' => 'required|numeric',
            'simpanan_wajib' => 'required|numeric',
            'waktu_pembayaran' => 'nullable|numeric',
            'pembayaran' => 'nullable|in:1', // Validasi untuk pembayaran
            'no_hp' => 'nullable|string|max:20', // Mengubah menjadi nullable
            'upload_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'upload_foto_diri' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update data anggota
        $anggota->no_anggota = $request->no_anggota;
        $anggota->nama = $request->nama;
        $anggota->nip_nipb_nrptt = $request->nip_nipb_nrptt;
        $anggota->tempat_lahir = $request->tempat_lahir;
        $anggota->tanggal_lahir = $request->tanggal_lahir;
        $anggota->umur = $request->umur;
        $anggota->nik = $request->nik;
        $anggota->alamat = $request->alamat;
        $anggota->unit_kerja = $request->unit_kerja; // Tetap sama
        $anggota->status_kepegawaian = $request->status_kepegawaian;
        $anggota->status_pernikahan = $request->status_pernikahan;
        $anggota->simpanan_pokok = $request->simpanan_pokok;
        $anggota->simpanan_wajib = $request->simpanan_wajib;
        $anggota->waktu_pembayaran = $request->waktu_pembayaran;
        $anggota->no_hp = $request->no_hp; // Tetap sama

        // Menambahkan pembayaran
        if ($request->has('pembayaran')) {
            $anggota->pembayaran = $request->pembayaran === '1' ? '1' : null; // Jika memilih manual, simpan 1, jika otomatis null
        }

        // Menangani upload file jika ada perubahan
        if ($request->hasFile('upload_ktp')) {
            // Hapus file lama jika ada
            if ($anggota->upload_ktp) {
                Storage::disk('public')->delete($anggota->upload_ktp);
            }
            $file = $request->file('upload_ktp');
            $path = $file->store('ktp', 'public');
            $anggota->upload_ktp = $path;
        }

        if ($request->hasFile('upload_foto_diri')) {
            // Hapus file lama jika ada
            if ($anggota->upload_foto_diri) {
                Storage::disk('public')->delete($anggota->upload_foto_diri);
            }
            $file = $request->file('upload_foto_diri');
            $path = $file->store('foto_diri', 'public');
            $anggota->upload_foto_diri = $path;
        }

        $anggota->save();

        return redirect()->route('anggotas.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    // Menghapus anggota dari database
    public function destroy(Anggota $anggota)
    {
        // Periksa apakah anggota memiliki pinjaman terkait
        if ($anggota->pinjaman()->count() > 0) {
            // Jika anggota memiliki pinjaman terkait, tampilkan pesan kesalahan
            return redirect()->route('anggotas.index')->with('error', 'Anggota tidak dapat dihapus karena masih memiliki pinjaman terkait.');
        }

        // Periksa apakah anggota memiliki pinjaman terkait
        if ($anggota->simpananwajib()->count() > 0) {
            // Jika anggota memiliki pinjaman terkait, tampilkan pesan kesalahan
            return redirect()->route('anggotas.index')->with('error', 'Anggota tidak dapat dihapus karena masih memiliki Simpanan Wajib.');
        }

        // Hapus file jika ada
        if ($anggota->upload_ktp) {
            Storage::disk('public')->delete($anggota->upload_ktp);
        }

        if ($anggota->upload_foto_diri) {
            Storage::disk('public')->delete($anggota->upload_foto_diri);
        }

        // Hapus anggota
        $anggota->delete();

        return redirect()->route('anggotas.index')->with('success', 'Anggota berhasil dihapus.');
    }

    public function rincian($id)
    {
        // Temukan anggota berdasarkan ID
        $anggota = Anggota::findOrFail($id);

        // Ambil data simpanan wajib berdasarkan no_anggota dari anggota yang ditemukan
        $simpananWajib = SimpananWajib::where('no_anggota', $anggota->no_anggota)->orderBy('tgl_simpanan', 'desc')->get();

        // Hitung total simpanan wajib hanya dengan status = 1
        $totalSimpanan = $simpananWajib->where('status', 1)->sum('nominal');

        // Ambil data pinjaman berdasarkan no_anggota dari anggota yang ditemukan
        $pinjaman = Pinjaman::where('no_anggota', $anggota->no_anggota)->get();

        // Hitung total pinjaman
        $totalPinjaman = $pinjaman->sum('nominal');

        // Ambil data angsuran berdasarkan no_anggota dari anggota yang ditemukan
        $angsuran = Angsuran::whereHas('pinjaman', function ($query) use ($anggota) {
            $query->where('no_anggota', $anggota->no_anggota);
        })->get();

        // Hitung total angsuran
        $totalAngsuran = $angsuran->sum('nominal');

        // Gunakan totalPinjaman sebagai maxValue
        $maxValue = $totalPinjaman;

        // Calculate percentage for the progress bar
        // Avoid division by zero
        $totalPinjamanPercentage = $maxValue > 0 ? min(($totalPinjaman / $maxValue) * 100, 100) : 0;

        // Kirim data ke view rincian anggota
        return view('pages.anggotas.rincian', compact('anggota', 'simpananWajib', 'totalSimpanan', 'pinjaman', 'maxValue', 'totalPinjaman', 'angsuran', 'totalAngsuran', 'totalPinjamanPercentage'));
    }

    public function updateSimpanan($id)
    {
        // Temukan anggota berdasarkan ID
        $anggota = Anggota::findOrFail($id);

        // Pastikan anggota aktif
        if ($anggota->status != 'aktif') {
            return redirect()->back()->with('error', 'Anggota tidak aktif, tidak dapat memperbarui simpanan.');
        }

        // Ambil no_anggota
        $noAnggota = $anggota->no_anggota;

        // Ambil tanggal dari no_anggota
        $tanggalAwal = Carbon::createFromFormat('d-m-Y', substr($noAnggota, 0, 2) . '-' . substr($noAnggota, 2, 2) . '-' . substr($noAnggota, 4, 4));

        // Buat tanggal sekarang
        $tanggalSekarang = Carbon::now();

        // Loop dari tanggal awal sampai tanggal sekarang untuk setiap bulan pada tanggal 20
        while ($tanggalAwal->lessThanOrEqualTo($tanggalSekarang)) {
            // Set tanggal simpanan ke tanggal 20 bulan yang sedang diiterasi
            $tanggalSimpanan = $tanggalAwal->copy()->day(20);

            // Jika simpanan sudah ada pada tanggal tersebut, skip
            $existingSimpanan = SimpananWajib::where('no_anggota', $noAnggota)->whereDate('tgl_simpanan', $tanggalSimpanan)->first();

            if (!$existingSimpanan) {
                // Buat simpanan baru
                SimpananWajib::create([
                    'no_anggota' => $noAnggota,
                    'tgl_simpanan' => $tanggalSimpanan,
                    'nominal' => 30000,
                    'status' => 1,
                ]);
            }

            // Tambah 1 bulan
            $tanggalAwal->addMonth();
        }

        return redirect()->back()->with('success', 'Data simpanan berhasil diperbarui.');
    }
}