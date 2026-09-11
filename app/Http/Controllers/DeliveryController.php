<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Importante para que funcione el $request

class DeliveryController extends Controller
{
    // Método para mostrar la vista (si lo necesitas)
    public function index() {
        return view('delivery');
    }

    public function store(Request $request) {
        // 1. Validación
        $request->validate([
            'cliente' => 'required|string|max:100',
            'direccion' => 'required',
            'telefono' => 'required|numeric',
            'pedido' => 'required'
        ]);

        // 2. Retorno con mensaje
        return back()->with('success', '¡Pedido de Doña Ross en camino!');
    }
}