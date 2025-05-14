<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PendaftaranAnggotaController extends Controller
{
    public function create()
    {
        // Menampilkan form pendaftaran anggota
        return view('pages.pendaftaran.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'no_anggota' => 'required|unique:anggotas,no_anggota',
            'nama' => 'required|string|max:255',
            'nip_nipb_nrptt' => 'nullable|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer',
            'jk' => 'required|string|max:1',
            'nik' => 'required|string|max:16',
            'alamat' => 'required|string',
            'unit_kerja' => 'required|string',
            'status_kepegawaian' => 'required|string',
            'status_pernikahan' => 'required|string',
            'simpanan_pokok' => 'required|numeric',
            'simpanan_wajib' => 'required|numeric',
            'no_hp' => 'required|string|max:15',
            'upload_ktp' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'upload_foto_diri' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Mulai transaksi
        DB::beginTransaction();
        try {
            // Simpan data ke tabel anggotas
            $anggota = Anggota::create([
                'tanggal' => $validatedData['tanggal'],
                'no_anggota' => $validatedData['no_anggota'],
                'nama' => $validatedData['nama'],
                'nip_nipb_nrptt' => $validatedData['nip_nipb_nrptt'],
                'tempat_lahir' => $validatedData['tempat_lahir'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'umur' => $validatedData['umur'],
                'jk' => $validatedData['jk'],
                'nik' => $validatedData['nik'],
                'alamat' => $validatedData['alamat'],
                'unit_kerja' => $validatedData['unit_kerja'],
                'status_kepegawaian' => $validatedData['status_kepegawaian'],
                'status_pernikahan' => $validatedData['status_pernikahan'],
                'simpanan_pokok' => $validatedData['simpanan_pokok'],
                'simpanan_wajib' => $validatedData['simpanan_wajib'],
                'no_hp' => $validatedData['no_hp'],
                'upload_ktp' => $request->file('upload_ktp')->store('ktp'),
                'upload_foto_diri' => $request->file('upload_foto_diri')->store('foto_diri'),
                'status' => 'pending',
            ]);

            // Buat email berdasarkan no_anggota
            $emailAnggota = $validatedData['no_anggota'] . '@example.com';

            // Simpan data user ke tabel users
            $user = User::create([
                'name' => $validatedData['nama'],
                'email' => $emailAnggota, // Email dibuat dari no_anggota
                'password' => Hash::make('password123'), // Atur password default atau bisa digenerate
                'role' => 'anggota', // Role sebagai anggota
                'email2' => $validatedData['no_anggota'], // email2 berisi no_anggota
            ]);

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect()->back()->with('success', 'Pendaftaran anggota berhasil');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat pendaftaran: ' . $e->getMessage());
        }
    }
}