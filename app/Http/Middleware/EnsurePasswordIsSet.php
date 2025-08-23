<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordIsSet
{
    public function handle(Request $request, Closure $next)
    {
        if (
            auth()->check() &&
            auth()->user()->needsPassword() &&
            !$request->routeIs('dashboard')
        ) {
            return redirect()->route('dashboard')->with('toast_warning', 'Primero debes establecer una contraseña para acceder a esa página.');
        }

        return $next($request);
    }
}
