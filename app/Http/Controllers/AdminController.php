<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Promocion;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'productos' => Producto::count(),
            'clientes' => User::where('role', 'cliente')->count(),
            'personal' => User::where('role', 'personal')->count(),
            'pedidos_hoy' => Pedido::whereDate('created_at', today())->count(),
            'ventas_hoy' => Pedido::whereDate('created_at', today())->sum('total'),
            'pedidos_pendientes' => Pedido::where('estado', 'pendiente')->count(),
        ];

        $pedidosRecientes = Pedido::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pedidosRecientes'));
    }

    public function horarios()
    {
        return view('admin.horarios');
    }
}
