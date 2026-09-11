<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Promocion;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $destacados = Producto::where('activo', true)->where('destacado', true)->take(3)->get();
        $promociones = Promocion::where('activo', true)
            ->where(function ($q) {
                $q->whereNull('fecha_fin')->orWhere('fecha_fin', '>=', now());
            })
            ->take(2)
            ->get();

        return view('home', compact('destacados', 'promociones'));
    }

    public function catalogo(Request $request)
    {
        $query = Producto::with('categoria')->where('activo', true);

        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%'.$request->buscar.'%');
        }

        $productos = $query->orderBy('nombre')->paginate(9);
        $categorias = \App\Models\Categoria::where('activo', true)->get();

        return view('catalogo', compact('productos', 'categorias'));
    }

    public function promociones()
    {
        $promociones = Promocion::where('activo', true)
            ->where(function ($q) {
                $q->whereNull('fecha_fin')->orWhere('fecha_fin', '>=', now());
            })
            ->get();

        return view('promociones', compact('promociones'));
    }
}
