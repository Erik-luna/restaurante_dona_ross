<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    /**
     * Registro de nuevo cliente desde la aplicación móvil.
     */
    public function register(Request $request): JsonResponse
    {
        // Sanitización anti-XSS
        $request->merge([
            'name' => strip_tags((string) $request->input('name')),
            'direccion' => strip_tags((string) $request->input('direccion')),
            'telefono' => strip_tags((string) $request->input('telefono')),
        ]);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'cliente',
            'telefono' => $data['telefono'] ?? null,
            'direccion' => $data['direccion'] ?? null,
            'activo' => true,
        ]);

        $token = auth('api')->login($user);

        return $this->tokenResponse($token, $user, '¡Registro exitoso! Bienvenido a Doña Ross.', 201);
    }

    public function login(Request $request): JsonResponse
    {
        return $this->authenticate($request);
    }

    /**
     * Login exclusivo para clientes.
     */
    public function loginCliente(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        return $this->authenticate($request, 'cliente');
    }

    /**
     * Login para personal y administradores (staff).
     */
    public function loginStaff(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        return $this->authenticate($request, ['admin', 'personal']);
    }

    /**
     * Obtener el perfil del usuario autenticado actual.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => auth('api')->user(),
        ]);
    }

    public function profile(): JsonResponse
    {
        return $this->me(request());
    }

    /**
     * Cerrar sesión y revocar el token actual.
     */
    public function logout(Request $request): JsonResponse
    {
        auth('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.',
        ]);
    }

    private function authenticate(Request $request, string|array|null $requiredRole = null): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json(['success' => false, 'message' => 'Credenciales incorrectas.'], 401);
        }

        if ($requiredRole !== null && ! in_array($user->role, (array) $requiredRole, true)) {
            return response()->json(['success' => false, 'message' => 'Acceso denegado.'], 403);
        }

        if (! $user->activo) {
            return response()->json(['success' => false, 'message' => 'Tu cuenta está desactivada.'], 403);
        }

        $token = auth('api')->login($user);

        return $this->tokenResponse($token, $user, 'Inicio de sesión exitoso.');
    }

    private function tokenResponse(string $token, User $user, string $message, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'access_token' => $token,
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'user' => $user,
            ],
        ], $status);
    }

    /**
     * Paso 1: Generar código de verificación para recuperación de contraseña.
     */
    public function solicitarCodigoRecuperacion(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->input('email'))
            ->where('role', 'cliente')
            ->first();

        if (! $user || ! $user->activo) {
            return response()->json([
                'success' => false,
                'message' => 'No existe una cuenta de cliente activa con ese correo.',
            ], 404);
        }

        $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Guardamos en Cache durante 15 minutos
        Cache::put("recuperar_codigo_{$user->email}", $codigo, now()->addMinutes(15));

        return response()->json([
            'success' => true,
            'message' => 'Código de verificación generado. Tiene una vigencia de 15 minutos.',
            'data' => [
                'email' => $user->email,
                'codigo' => $codigo, // Expuesto para facilitar pruebas y desarrollo en Flutter
                'expira_en_minutos' => 15,
            ],
        ]);
    }

    /**
     * Paso 2: Validar el código y cambiar la contraseña.
     */
    public function cambiarPasswordRecuperacion(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'codigo' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = $request->input('email');
        $codigoIngresado = trim((string) $request->input('codigo'));
        $codigoGuardado = Cache::get("recuperar_codigo_{$email}");

        if (! $codigoGuardado || ! hash_equals((string) $codigoGuardado, $codigoIngresado)) {
            return response()->json([
                'success' => false,
                'message' => 'El código de verificación es inválido o ha expirado.',
            ], 422);
        }

        $user = User::where('email', $email)
            ->where('role', 'cliente')
            ->first();

        if (! $user || ! $user->activo) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado o inactivo.',
            ], 404);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Limpiar el código usado
        Cache::forget("recuperar_codigo_{$email}");

        return response()->json([
            'success' => true,
            'message' => 'Tu contraseña se actualizó correctamente. Ya puedes iniciar sesión con tu nueva contraseña.',
        ]);
    }
}
