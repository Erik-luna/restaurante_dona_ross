<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('nombre')->get();

        return view('admin.stock.index', compact('productos'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $producto->update(['stock' => $data['stock']]);

        return redirect()->route('admin.stock.index')->with('success', 'Stock de "'.$producto->nombre.'" actualizado.');
    }
}
