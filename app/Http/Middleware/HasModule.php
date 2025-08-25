<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HasModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $moduleName)
    {
        $user = Auth::user();

        if (!$user) {
            // abort(403, 'No autenticado');
            return redirect()->route('login');
        }

        // Buscar módulos habilitados al usuario (por sus roles)
        $modules = $user->getAllModules();


        $tieneAcceso = $modules->contains(function ($modulo) use ($moduleName) {
            return strtolower($modulo->name) === strtolower($moduleName);
        });

        if (!$tieneAcceso) {
            abort(403, 'No tiene acceso a este modulo');
        }

        return $next($request);
    }
}
