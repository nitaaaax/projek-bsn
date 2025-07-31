<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guard = $guards[0] ?? null;

        if (Auth::guard($guard)->check()) {
            // Langsung redirect ke route 'home' yang menangani redirect berdasarkan role
            return redirect()->route('home');
        }

        return $next($request);
    }
}
