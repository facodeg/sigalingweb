<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AkunAnggotaController extends Controller
{
    // Menampilkan form edit password
    public function editPassword($id)
    {
        $user = Auth::user();

        // Mencari data anggota berdasarkan no_anggota yang sama dengan email user
        $anggota = Anggota::where('no_anggota', $user->email)->first();

        $user = User::findOrFail($id);
        return view('pages.koperasi.anggota.edit-password', compact('user', 'anggota'));
    }

    // Mengupdate password user
    public function updatePassword(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);

        // Periksa apakah password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->view('pages.koperasi.anggota.edit-password')->with('success', 'Password berhasil diubah');
    }
}