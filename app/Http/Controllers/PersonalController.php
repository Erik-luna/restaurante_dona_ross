<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'ventas_hoy' => Pedido::where('atendido_por', auth()->id())
                ->whereDate('created_at', today())->sum('total'),
            'pedidos_hoy' => Pedido::where('atendido_por', auth()->id())
                ->whereDate('created_at', today())->count(),
            'clientes' => User::where('role', 'cliente')->count(),
        ];

        return view('personal.dashboard', compact('stats'));
    }
}
