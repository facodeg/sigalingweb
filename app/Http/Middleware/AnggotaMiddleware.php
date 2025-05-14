<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AnggotaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            \Log::info('User Role: ' . Auth::user()->role);
        }
        // Cek apakah pengguna sudah login dan memiliki peran 'admin'
        if (Auth::check() && (Auth::user()->role === 'anggota' || Auth::user()->role === 'admin')) {
            return $next($request);
        }

        // Jika bukan admin, arahkan ke halaman 403 Forbidden
        return abort(403, 'Anda tidak memiliki akses sebagai Admin.');
    }
}