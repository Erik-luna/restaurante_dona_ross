<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('user')->where('tipo', 'online')->latest()->paginate(15);

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['user', 'items.producto', 'atendidoPor']);

        return view('admin.pedidos.show', compact('pedido'));
    }

    public function updateEstado(Request $request, Pedido $pedido)
    {
        $data = $request->validate([
            'estado' => 'required|in:pendiente,confirmado,preparando,enviado,entregado,cancelado',
        ]);

        $pedido->update(['estado' => $data['estado']]);

        return back()->with('success', 'Estado del pedido actualizado.');
    }
}
