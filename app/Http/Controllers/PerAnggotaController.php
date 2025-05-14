<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Angsuran;
use App\Models\LimitPinjaman;
use App\Models\Pinjaman;
use App\Models\SimpananWajib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class PerAnggotaController extends Controller
{
    public function index()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mencari data anggota berdasarkan no_anggota yang sama dengan email user
        $anggota = Anggota::where('no_anggota', $user->email)->first();

        // Jika tidak ditemukan anggota
        if (!$anggota) {
            return redirect()->back()->with('error', 'Data anggota tidak ditemukan.');
        }

        // Kembali ke view dengan data anggota dan user
        return view('pages.peranggota.index', compact('anggota', 'user'));
    }

    public function rincian()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Temukan anggota berdasarkan email user
        $anggota = Anggota::where('no_anggota', $user->email)->firstOrFail();

        // Ambil data simpanan wajib berdasarkan no_anggota dari anggota yang ditemukan
        $simpananWajib = SimpananWajib::where('no_anggota', $anggota->no_anggota)
            ->orderBy('tgl_simpanan', 'desc')
            ->get();

        // Hitung total simpanan wajib hanya dengan status = 1
        $totalSimpanan = $simpananWajib->where('status', 1)->sum('nominal');

        // Ambil data pinjaman dengan status "disetujui" berdasarkan no_anggota dari anggota yang ditemukan
        $pinjaman = Pinjaman::where('no_anggota', $anggota->no_anggota)
            ->where('status', 'disetujui') // Menambahkan kondisi status disetujui
            ->get();

        // Hitung total pinjaman hanya jika status disetujui
        $totalPinjaman = $pinjaman->sum('nominal');

        // Ambil data angsuran berdasarkan no_anggota dari anggota yang ditemukan
        $angsuran = Angsuran::whereHas('pinjaman', function ($query) use ($anggota) {
            $query->where('no_anggota', $anggota->no_anggota);
        })->get();

        // Hitung total angsuran
        $totalAngsuran = $angsuran->sum('nominal');

        // Gunakan totalPinjaman sebagai maxValue
        $maxValue = $totalPinjaman;

        $limitPinjaman = LimitPinjaman::where('user_id', $user->id)->first();

        // Jika tidak ada limit untuk user, ambil limit dengan status "semua"
        $limitSemua = LimitPinjaman::where('status', 'semua')->first();

        // Calculate percentage for the progress bar
        // Avoid division by zero
        $totalPinjamanPercentage = $maxValue > 0 ? min(($totalPinjaman / $maxValue) * 100, 100) : 0;

        // Kirim data ke view rincian anggota
        return view('pages.peranggota.rincian', compact('anggota', 'simpananWajib', 'totalSimpanan', 'pinjaman', 'maxValue', 'totalPinjaman', 'angsuran', 'totalAngsuran', 'totalPinjamanPercentage', 'limitPinjaman', 'limitSemua'));
    }

    public function edit()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Temukan anggota berdasarkan email user
        $anggota = Anggota::where('no_anggota', $user->email)->firstOrFail();

        // Kembali ke view edit dengan data anggota
        return view('pages.peranggota.edit', compact('anggota'));
    }
    public function indexPerbarui()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Temukan anggota berdasarkan email user
        $anggota = Anggota::where('no_anggota', $user->email)->firstOrFail();

        // Kembali ke view perbarui dengan data anggota
        return view('pages.peranggota.perbarui', compact('anggota', 'user'));
    }

    public function perbarui(Request $request)
    {
        // Validasi input yang diterima dari form
        $request->validate([
            'jk' => 'required|string|in:L,P', // Validasi untuk jenis kelamin
            'no_hp' => 'required|string|min:10', // Validasi nomor handphone
            'email2' => 'nullable|email|max:255|unique:users,email2,' . Auth::id(), // Validasi email2, kecuali untuk user yang sedang login
            'upload_foto_diri' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto diri
            'unit_kerja' => 'required|string', // Validasi untuk unit kerja
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Temukan anggota berdasarkan no_anggota user
        $anggota = Anggota::where('no_anggota', $user->email)->firstOrFail();

        // Update data anggota
        $anggota->jk = $request->input('jk');
        $anggota->no_hp = $request->input('no_hp'); // Simpan no_hp di tabel anggota
        $anggota->unit_kerja = $request->input('unit_kerja'); // Tambahkan unit kerja

        // Simpan perubahan ke tabel anggota
        $anggota->save();

        // Update data no_hp dan email2 di tabel users
        $user->phone = $request->input('no_hp'); // Simpan no_hp di tabel users
        if ($request->has('email2')) {
            $user->email2 = $request->input('email2'); // Simpan email2 di tabel users
        }

        // Simpan perubahan ke tabel users
        $user->save();

        // Cek apakah file foto diri di-upload
        if ($request->hasFile('upload_foto_diri')) {
            // Hapus foto lama jika ada
            if ($anggota->upload_foto_diri && Storage::disk('public')->exists($anggota->upload_foto_diri)) {
                Storage::disk('public')->delete($anggota->upload_foto_diri);
            }

            // Simpan file yang baru
            $path = $request->file('upload_foto_diri')->store('uploads/foto_diri', 'public');
            $anggota->upload_foto_diri = $path;

            // Simpan perubahan ke tabel anggota setelah upload foto
            $anggota->save();
        }

        // Redirect ke halaman yang sesuai dengan pesan sukses
        return redirect()->route('anggotas.perbarui')->with('success', 'Data anggota berhasil diperbarui.');
    }
}