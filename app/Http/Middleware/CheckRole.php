<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'No autenticado.'], 401);
            }
            return redirect()->route('login.cliente')->with('error', 'Debes iniciar sesión.');
        }

        if (! $request->user()->activo) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Tu cuenta está desactivada.'], 403);
            }
            auth()->logout();
            return redirect()->route('home')->with('error', 'Tu cuenta está desactivada.');
        }

        if (! in_array($request->user()->role, $roles)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'No tienes permiso para acceder a este recurso.'], 403);
            }
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
