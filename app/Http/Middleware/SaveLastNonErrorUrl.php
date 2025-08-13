<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SaveLastNonErrorUrl
{
    public function handle(Request $request, Closure $next)
    {
        // Cek kalau ini GET dan bukan halaman 404 atau 500
        if (
            $request->method() === 'GET' &&
            !$request->is('404') &&
            !$request->is('500') &&
            !$request->ajax()
        ) {
            session(['last_non_error_url' => url()->full()]);
        }

        return $next($request);
    }
}
