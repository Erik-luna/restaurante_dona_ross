<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $items = PortfolioItem::where('activo', true)->orderBy('orden')->get();
        $proyectos = $items->where('tipo', 'proyecto');
        $habilidades = $items->where('tipo', 'habilidad');
        $experiencias = $items->where('tipo', 'experiencia');
        $educacion = $items->where('tipo', 'educacion');
        $sobreMi = $items->where('tipo', 'sobre_mi')->first();

        return view('portafolio.index', compact('proyectos', 'habilidades', 'experiencias', 'educacion', 'sobreMi'));
    }

    public function adminIndex()
    {
        $items = PortfolioItem::orderBy('orden')->paginate(15);

        return view('admin.portafolio.index', compact('items'));
    }

    public function create()
    {
        return view('admin.portafolio.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo' => 'required|in:proyecto,habilidad,experiencia,educacion,sobre_mi',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tecnologias' => 'nullable|string|max:255',
            'enlace' => 'nullable|url|max:255',
            'imagen' => 'nullable|image|max:2048',
            'orden' => 'nullable|integer|min:0',
            'activo' => 'boolean',
        ]);

        $data['activo'] = $request->boolean('activo', true);
        $data['orden'] = $data['orden'] ?? 0;

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('portafolio', 'public');
        }

        PortfolioItem::create($data);

        return redirect()->route('admin.portafolio.index')->with('success', 'Elemento del portafolio creado.');
    }

    public function edit(PortfolioItem $portafolio)
    {
        return view('admin.portafolio.edit', ['item' => $portafolio]);
    }

    public function update(Request $request, PortfolioItem $portafolio)
    {
        $data = $request->validate([
            'tipo' => 'required|in:proyecto,habilidad,experiencia,educacion,sobre_mi',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tecnologias' => 'nullable|string|max:255',
            'enlace' => 'nullable|url|max:255',
            'imagen' => 'nullable|image|max:2048',
            'orden' => 'nullable|integer|min:0',
            'activo' => 'boolean',
        ]);

        $data['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            if ($portafolio->imagen) {
                Storage::disk('public')->delete($portafolio->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('portafolio', 'public');
        }

        $portafolio->update($data);

        return redirect()->route('admin.portafolio.index')->with('success', 'Elemento actualizado.');
    }

    public function destroy(PortfolioItem $portafolio)
    {
        if ($portafolio->imagen) {
            Storage::disk('public')->delete($portafolio->imagen);
        }
        $portafolio->delete();

        return redirect()->route('admin.portafolio.index')->with('success', 'Elemento eliminado.');
    }
}
