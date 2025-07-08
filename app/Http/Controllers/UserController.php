<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Anggota;
use App\Models\Karyawan;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan semua pengguna
        $users = User::all();
        return view('pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat pengguna baru
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
            'password' => 'required',
            'position' => 'required',
            'imageUrl' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Buat pengguna baru
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->position = $request->position;
        $user->password = Hash::make($request->password);

        // Proses upload gambar baru jika ada
        if ($request->hasFile('imageUrl')) {
            // Hapus gambar lama jika ada
            if ($user->imageUrl) {
                Storage::disk('public')->delete($user->imageUrl);
            }
            // Upload gambar baru
            $filename = Str::random(20) . '.' . $request->file('imageUrl')->getClientOriginalExtension();
            $user->imageUrl = $request->file('imageUrl')->storeAs('photos', $filename, 'public');
        }

        // Simpan data pengguna
        $user->save();

        return redirect()->route('users.index')->with('success', 'User successfully created');
    }

    /**
     * Display the specified resource.
     */
    // public function show($id)
    // {
    //     // Menampilkan detail pengguna
    //     $user = User::find($id);
    //     return view('pages.users.show', compact('user'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Menampilkan form untuk mengedit pengguna
        $user = User::find($id);
        return view('pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'position' => 'required',
            'password' => 'sometimes|nullable|min:6',
            'imageUrl' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update data pengguna
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->position = $request->position;

        // Proses upload gambar baru jika ada
        if ($request->hasFile('imageUrl')) {
            // Hapus gambar lama jika ada
            if ($user->imageUrl) {
                Storage::disk('public')->delete($user->imageUrl);
            }
            // Upload gambar baru
            $filename = Str::random(20) . '.' . $request->file('imageUrl')->getClientOriginalExtension();
            $user->imageUrl = $request->file('imageUrl')->storeAs('photos', $filename, 'public');
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan
        $user->save();

        return redirect()->route('users.edit', $user->id)->with('success', 'User successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Hapus pengguna dan gambar terkait
        $user = User::find($id);
        if ($user->imageUrl) {
            Storage::disk('public')->delete($user->imageUrl);
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User successfully deleted');
    }

    public function autoGenerate()
    {
        // Ambil semua data dari model Karyawan
        $karyawans = Karyawan::all();

        foreach ($karyawans as $karyawan) {
            // Cek apakah pengguna dengan email atau NIP sudah ada
            $existingUser = User::where('email', $karyawan->nip_nrp_nipppk_nipb)->first();
            if (!$existingUser) {
                // Buat akun user baru berdasarkan data dari karyawan
                $user = new User();
                $user->name = $karyawan->nama;
                $user->email = $karyawan->nip_nrp_nipppk_nipb;
                $user->role = 'karyawan';
                $user->position = $karyawan->jabatan_terakhir ?? 'karyawan';
                $user->password = Hash::make('rsudl123'); // Password default

                $user->save();
            }
        }

        return redirect()->route('users.index')->with('success', 'Auto-generate users completed successfully');
    }
}
