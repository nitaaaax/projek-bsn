<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SaveLastUrl
{
    public function handle(Request $request, Closure $next)
    {
        // Jangan simpan kalau ini request untuk error page atau Ajax
        if (!$request->ajax() && $request->method() === 'GET' && !$request->is('404')) {
            session(['last_url' => url()->current()]);
        }

        return $next($request);
    }
}
