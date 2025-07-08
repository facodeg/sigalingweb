<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AlamatDomisili;
use App\Models\Anggota;
use App\Models\Angsuran;
use App\Models\City;
use App\Models\District;
use App\Models\Karyawan;
use App\Models\LimitPinjaman;
use App\Models\PendidikanTb;
use App\Models\Pinjaman;
use App\Models\Province;
use App\Models\SimpananWajib;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class PerAnggotaController extends Controller
{
    public function index()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mencari data karyawan berdasarkan nip yang sama dengan email user
        $karyawan = Karyawan::where('nip_nrp_nipppk_nipb', $user->email)->first();

        // Jika tidak ditemukan
        if (!$karyawan) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        // Kembali ke view dengan data karyawan dan user
        return view('pages.perkaryawan.index', compact('karyawan', 'user'));
    }

    public function rincian()
    {
        $user = Auth::user();

        // Ambil data karyawan berdasarkan NIP/NPP/NIPB = email login
        $karyawan = Karyawan::where('nip_nrp_nipppk_nipb', $user->email)->firstOrFail();

        // Daftar provinsi untuk select2 form
        $provinsiList = Province::orderBy('name')->get();

        // Ambil data alamat & konversi code ke nama provinsi/kota/dll
        $alamatList = AlamatDomisili::where('karyawan_id', $karyawan->id)
            ->get()
            ->map(function ($alamat) {
                $alamat->provinsi = Province::where('code', $alamat->province_code)->value('name');
                $alamat->kota = City::where('code', $alamat->city_code)->value('name');
                $alamat->kecamatan = District::where('code', $alamat->district_code)->value('name');
                $alamat->kelurahan = Village::where('code', $alamat->village_code)->value('name');
                $alamat->jenis = $alamat->keterangan; // Alias saja
                return $alamat;
            });

        // Ambil data pendidikan berdasarkan pegawai_id
        $pendidikanList = PendidikanTb::where('pegawai_id', $karyawan->id)->get();

        return view('pages.peranggota.rincian', compact('karyawan', 'provinsiList', 'alamatList', 'pendidikanList'));
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
