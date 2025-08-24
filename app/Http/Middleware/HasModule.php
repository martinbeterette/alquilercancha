<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $moduleSlug)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'No autenticado');
        }

        // Buscar módulos habilitados al usuario (por sus roles)
        $modules = $user->getAllModules()->pluck('slug');

        if (!$modules->contains($moduleSlug)) {
            abort(403, 'No tenés acceso a este módulo');
        }

        return $next($request);
    }
}
