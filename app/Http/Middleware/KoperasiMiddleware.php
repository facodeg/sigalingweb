<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class KoperasiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->role === 'koperasi' || Auth::user()->role === 'admin')) {
            return $next($request);
        }

        // Jika bukan admin atau koperasi, arahkan ke halaman 403 Forbidden
        return abort(403, 'Anda tidak memiliki akses.');
    }
}
