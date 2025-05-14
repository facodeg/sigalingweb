<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data izin dengan relasi user, diurutkan berdasarkan user_id
        $izin = Izin::with('user')->orderBy('user_id')->get();
        return view('pages.izin.index', compact('izin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat izin baru
        return view('pages.izin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        // Membuat entri izin baru
        Izin::create([
            'user_id' => $request->user_id,
            'type' => $request->type,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('izins.index')->with('success', 'Izin berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $izin = Izin::with('user')->findOrFail($id);
        return view('pages.izin.show', compact('izin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $izin = Izin::findOrFail($id);
        return view('pages.izin.edit', compact('izin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'is_approved' => 'required|boolean',
        ]);

        // Menemukan entri izin dan memperbarui status persetujuan
        $izin = Izin::findOrFail($id);
        $izin->is_approved = $request->is_approved;
        $str = $izin->is_approved == 1 ? 'Disetujui' : 'Ditolak';
        $izin->save();
        $this->sendNotificationToUser($izin->user_id, 'Status Izin Anda adalah'. $str);
        return redirect()->route('izins.index')->with('success', 'Data izin berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Menghapus entri izin yang ditemukan
        $izin = Izin::findOrFail($id);
        $izin->delete();

        return redirect()->route('izins.index')->with('success', 'Data izin berhasil dihapus');
    }


    public function sendNotificationToUser($userId, $message)
    {
        // Dapatkan FCM token user dari tabel 'users'

        $user = User::find($userId);
        $token = $user->fcm_token;

        // Kirim notifikasi ke perangkat Android
        $messaging = app('firebase.messaging');
        $notification = Notification::create('Status Izin', $message);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        $messaging->send($message);
    }
}
