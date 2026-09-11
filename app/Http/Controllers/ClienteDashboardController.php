<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class ClienteDashboardController extends Controller
{
    public function dashboard()
    {
        $pedidos = auth()->user()->pedidos()->latest()->take(5)->get();
        $carritoCount = array_sum(session('carrito', []));

        return view('cliente.dashboard', compact('pedidos', 'carritoCount'));
    }

    public function pedidos()
    {
        $pedidos = auth()->user()->pedidos()->with('items.producto')->latest()->paginate(10);

        return view('cliente.pedidos', compact('pedidos'));
    }

    public function perfil()
    {
        return view('cliente.perfil', ['user' => auth()->user()]);
    }

    public function updatePerfil(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $data['name'];
        $user->telefono = $data['telefono'] ?? null;
        $user->direccion = $data['direccion'] ?? null;

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
