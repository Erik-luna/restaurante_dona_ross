<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = User::where('role', 'cliente')->latest()->paginate(10);

        return view('admin.clientes.index', compact('clientes'));
    }

    // Visualización de la información de registro: el administrador
    // puede consultarla pero no editarla.
    public function show(User $cliente)
    {
        abort_unless($cliente->role === 'cliente', 404);

        return view('admin.clientes.show', compact('cliente'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'cliente',
            'telefono' => $data['telefono'] ?? null,
            'direccion' => $data['direccion'] ?? null,
        ]);

        $route = auth()->user()->isAdmin() ? 'admin.clientes.index' : 'personal.clientes.index';

        return redirect()->route($route)->with('success', 'Cliente registrado correctamente.');
    }

    public function edit(User $cliente)
    {
        abort_unless($cliente->role === 'cliente', 404);

        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, User $cliente)
    {
        abort_unless($cliente->role === 'cliente', 404);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$cliente->id,
            'password' => 'nullable|min:6',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ]);

        $cliente->name = $data['name'];
        $cliente->email = $data['email'];
        $cliente->telefono = $data['telefono'] ?? null;
        $cliente->direccion = $data['direccion'] ?? null;
        $cliente->activo = $request->boolean('activo', true);

        if (! empty($data['password'])) {
            $cliente->password = Hash::make($data['password']);
        }

        $cliente->save();

        $route = auth()->user()->isAdmin() ? 'admin.clientes.index' : 'personal.clientes.index';

        return redirect()->route($route)->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(User $cliente)
    {
        abort_unless($cliente->role === 'cliente', 404);
        $cliente->delete();

        $route = auth()->user()->isAdmin() ? 'admin.clientes.index' : 'personal.clientes.index';

        return redirect()->route($route)->with('success', 'Cliente eliminado correctamente.');
    }
}
