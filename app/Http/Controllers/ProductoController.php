<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->latest()->paginate(10);

        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::where('activo', true)->get();

        return view('admin.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|max:2048',
            'destacado' => 'boolean',
            'activo' => 'boolean',
        ]);

        $data['destacado'] = $request->boolean('destacado');
        $data['activo'] = $request->boolean('activo', true);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::where('activo', true)->get();

        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|max:2048',
            'destacado' => 'boolean',
            'activo' => 'boolean',
        ]);

        $data['destacado'] = $request->boolean('destacado');
        $data['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
