<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (auth()->check() && auth()->user()->role->nama_role === $role) {
            return $next($request);
        }

        abort(403, 'Anda Bukanlah Admin.');
    }
}

