<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.home');
        } elseif ($user->role === 'anggota') {
            return redirect()->route('peranggota.home');
        } elseif ($user->role === 'koperasi') {
            return redirect()->route('koperasi.home');
        }

        return abort(403);
    }
}