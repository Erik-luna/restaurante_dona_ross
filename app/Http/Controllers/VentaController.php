<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Pedido::with(['user', 'atendidoPor'])
            ->where('tipo', 'local')
            ->latest()
            ->paginate(15);

        return view('personal.ventas.index', compact('ventas'));
    }

    public function create()
    {
        $productos = Producto::where('activo', true)->where('stock', '>', 0)->orderBy('nombre')->get();
        $clientes = User::where('role', 'cliente')->where('activo', true)->orderBy('name')->get();

        return view('personal.ventas.create', compact('productos', 'clientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'notas' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($data) {
                $total = 0;
                $itemsData = [];

                foreach ($data['items'] as $item) {
                    $producto = Producto::lockForUpdate()->find($item['producto_id']);
                    if ($producto->stock < $item['cantidad']) {
                        throw new \RuntimeException('Stock insuficiente para: '.$producto->nombre);
                    }
                    $subtotal = $producto->precio * $item['cantidad'];
                    $total += $subtotal;
                    $itemsData[] = [
                        'producto' => $producto,
                        'cantidad' => $item['cantidad'],
                        'subtotal' => $subtotal,
                    ];
                }

                $pedido = Pedido::create([
                    'user_id' => $data['user_id'],
                    'tipo' => 'local',
                    'estado' => 'entregado',
                    'total' => $total,
                    'notas' => $data['notas'] ?? null,
                    'atendido_por' => auth()->id(),
                ]);

                foreach ($itemsData as $item) {
                    PedidoItem::create([
                        'pedido_id' => $pedido->id,
                        'producto_id' => $item['producto']->id,
                        'cantidad' => $item['cantidad'],
                        'precio_unitario' => $item['producto']->precio,
                        'subtotal' => $item['subtotal'],
                    ]);
                    $item['producto']->decrement('stock', $item['cantidad']);
                }
            });
        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        $route = auth()->user()->isAdmin() ? 'admin.ventas.index' : 'personal.ventas.index';

        return redirect()->route($route)->with('success', 'Venta registrada correctamente.');
    }

    public function show(Pedido $venta)
    {
        abort_unless($venta->tipo === 'local', 404);
        $venta->load(['user', 'items.producto', 'atendidoPor']);

        return view('personal.ventas.show', compact('venta'));
    }
}
