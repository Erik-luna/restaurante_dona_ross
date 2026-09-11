<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RecuperarPasswordController extends Controller
{
    public function formulario()
    {
        return view('auth.recuperar-password');
    }

    // Paso 1: el cliente introduce su correo y, en la misma ventana,
    // se muestra un código de verificación que deberá introducir.
    public function generarCodigo(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Debes introducir tu correo.',
            'email.email' => 'Introduce un correo válido.',
        ]);

        $user = User::where('email', $request->input('email'))
            ->where('role', 'cliente')
            ->first();

        if (! $user || ! $user->activo) {
            return back()->with('error', 'No existe una cuenta de cliente activa con ese correo.');
        }

        $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $request->session()->put([
            'recuperacion_email' => $user->email,
            'recuperacion_codigo' => $codigo,
            'recuperacion_expira' => now()->addMinutes(15),
        ]);

        return back()->with('success', 'Código de verificación generado. Tiene una vigencia de 15 minutos.');
    }

    // Paso 2: valida el código mostrado y permite cambiar la contraseña.
    public function cambiar(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'codigo' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.required' => 'Debes introducir tu correo.',
            'codigo.required' => 'Debes introducir el código de verificación.',
            'password.required' => 'Debes introducir la nueva contraseña.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        if (! $request->session()->has('recuperacion_email')) {
            return redirect()->route('password.formulario')->with('error', 'Primero solicita un código con tu correo.');
        }

        if (now()->gt($request->session()->get('recuperacion_expira'))) {
            $this->limpiarSesion($request);

            return redirect()->route('password.formulario')->with('error', 'El código ha expirado. Solicita uno nuevo.');
        }

        $user = User::where('email', $request->input('email'))
            ->where('role', 'cliente')
            ->first();

        $codigoValido = hash_equals(
            (string) $request->session()->get('recuperacion_codigo'),
            trim((string) $request->input('codigo'))
        );

        if (! $user || ! $user->activo || ! $codigoValido) {
            return back()
                ->withErrors(['codigo' => 'El correo o el código de verificación son incorrectos.'])
                ->onlyInput('email');
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        $this->limpiarSesion($request);

        return redirect()->route('login.cliente')
            ->with('success', 'Tu contraseña se actualizó correctamente. Ya puedes iniciar sesión.');
    }

    // Permite empezar de nuevo con otro correo.
    public function limpiar(Request $request)
    {
        $this->limpiarSesion($request);

        return redirect()->route('password.formulario');
    }

    private function limpiarSesion(Request $request): void
    {
        $request->session()->forget(['recuperacion_email', 'recuperacion_codigo', 'recuperacion_expira']);
    }
}
