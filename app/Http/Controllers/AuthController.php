<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showClienteLogin()
    {
        return view('auth.login-cliente');
    }

    public function loginCliente(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && ! $user->activo) {
            return back()->with('error', 'Tu cuenta está desactivada. Contacta al administrador.');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if ($user->role === 'personal') {
                return redirect()->route('personal.dashboard');
            }

            return redirect()->intended(route('cliente.dashboard'));
        }

        return back()->with('error', 'Credenciales incorrectas.')->onlyInput('email');
    }

    public function showAdminLogin()
    {
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! in_array($user->role, ['admin', 'personal'])) {
            return back()->with('error', 'Acceso denegado. Solo personal autorizado.')->onlyInput('email');
        }

        if (! $user->activo) {
            return back()->with('error', 'Tu cuenta está desactivada.');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $user->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('personal.dashboard');
        }

        return back()->with('error', 'Credenciales incorrectas.')->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Sanitización anti-XSS: elimina cualquier etiqueta <script> o HTML recibida
        $request->merge([
            'name' => strip_tags($request->input('name')),
            'direccion' => strip_tags($request->input('direccion')),
            'telefono' => strip_tags($request->input('telefono')),
        ]);

        // 2. Validación de datos estricta
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        // 3. Creación limpia del usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'cliente',
            'telefono' => $data['telefono'] ?? null,
            'direccion' => $data['direccion'] ?? null,
        ]);

        // 4. Login y regeneración de sesión por seguridad
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('cliente.dashboard')->with('success', '¡Registro exitoso! Bienvenido a Doña Ross.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Sesión cerrada correctamente.');
    }
}