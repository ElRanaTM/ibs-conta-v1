<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckContador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Verificar si el usuario está activo
        if ($user->estado !== 'activo') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Tu cuenta está inactiva.');
        }

        // Si el usuario tiene rol 'contador', verificar rutas permitidas
        if ($user->hasRole('contador')) {
            $currentRoute = $request->route()->getName();

            // Rutas permitidas para contador
            $rutasPermitidas = [
                'dashboard',
                'contabilidad.',
                'catalogos.',
            ];

            $permitido = false;
            foreach ($rutasPermitidas as $ruta) {
                if (str_starts_with($currentRoute, $ruta)) {
                    $permitido = true;
                    break;
                }
            }

            if (!$permitido) {
                return redirect()->route('dashboard')->with('error', 'No tienes permiso para acceder a esta sección.');
            }
        }

        return $next($request);
    }
}
