<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeXss
{
    // Campos que no se alteran: el token CSRF y las contraseñas,
    // ya que el usuario debe autenticarse con exactamente lo que escribe.
    protected array $excluidos = [
        '_token',
        'password',
        'password_confirmation',
        'current_password',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $request->merge(
            $this->sanitizar($request->except($this->excluidos))
        );

        return $next($request);
    }

    // Blindaje anti-XSS: renombra los símbolos peligrosos (< > " ' &)
    // por sus entidades HTML para que el navegador no pueda
    // interpretarlos como código.
    private function sanitizar(mixed $valor): mixed
    {
        if (is_array($valor)) {
            return array_map([$this, 'sanitizar'], $valor);
        }

        if (is_string($valor)) {
            return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
        }

        return $valor;
    }
}
