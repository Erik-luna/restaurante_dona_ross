<?php

namespace App\Http\Controllers;

use App\Models\Promocion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromocionController extends Controller
{
    public function index()
    {
        $promociones = Promocion::latest()->paginate(10);

        return view('admin.promociones.index', compact('promociones'));
    }

    public function create()
    {
        return view('admin.promociones.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'imagen' => 'nullable|image|max:2048',
            'activo' => 'boolean',
        ]);

        $data['activo'] = $request->boolean('activo', true);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('promociones', 'public');
        }

        Promocion::create($data);

        return redirect()->route('admin.promociones.index')->with('success', 'Promoción creada.');
    }

    public function edit(Promocion $promocione)
    {
        return view('admin.promociones.edit', ['promocion' => $promocione]);
    }

    public function update(Request $request, Promocion $promocione)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'imagen' => 'nullable|image|max:2048',
            'activo' => 'boolean',
        ]);

        $data['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            if ($promocione->imagen) {
                Storage::disk('public')->delete($promocione->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('promociones', 'public');
        }

        $promocione->update($data);

        return redirect()->route('admin.promociones.index')->with('success', 'Promoción actualizada.');
    }

    public function destroy(Promocion $promocione)
    {
        if ($promocione->imagen) {
            Storage::disk('public')->delete($promocione->imagen);
        }
        $promocione->delete();

        return redirect()->route('admin.promociones.index')->with('success', 'Promoción eliminada.');
    }
}
