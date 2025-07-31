<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        $user = auth()->user();

        // Kalau pakai relasi role()
        $userRoleName = $user->role->name ?? null;

        if ($userRoleName === $role) {
            return $next($request);
        }

        abort(403, 'Akses ditolak.');
    }

}
