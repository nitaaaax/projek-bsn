<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            abort(403, 'Silakan login terlebih dahulu.');
        }

        // Ambil nama role dari relasi Role
        $userRole = strtolower(trim(auth()->user()->role->name ?? ''));

        // Admin bebas akses semua
        if ($userRole === 'admin') {
            return $next($request);
        }

        // Selain admin, harus cocok dengan parameter middleware
        if ($userRole !== strtolower(trim($role))) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
