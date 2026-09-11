<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    private function getCarrito(): array
    {
        return session('carrito', []);
    }

    private function saveCarrito(array $carrito): void
    {
        session(['carrito' => $carrito]);
    }

    public function index()
    {
        $carrito = $this->getCarrito();
        $items = [];
        $total = 0;

        foreach ($carrito as $productoId => $cantidad) {
            $producto = Producto::find($productoId);
            if ($producto && $producto->activo) {
                $subtotal = $producto->precio * $cantidad;
                $items[] = compact('producto', 'cantidad', 'subtotal');
                $total += $subtotal;
            }
        }

        return view('cliente.carrito', compact('items', 'total'));
    }

    public function add(Request $request, Producto $producto)
    {
        if (! auth()->check() || ! auth()->user()->isCliente()) {
            return redirect()->route('login.cliente')
                ->with('error', 'Debes iniciar sesión o registrarte para agregar al carrito.');
        }

        if (! $producto->activo || $producto->stock < 1) {
            return back()->with('error', 'Producto no disponible.');
        }

        $carrito = $this->getCarrito();
        $cantidadActual = $carrito[$producto->id] ?? 0;

        if ($cantidadActual + 1 > $producto->stock) {
            return back()->with('error', 'Stock insuficiente.');
        }

        $carrito[$producto->id] = $cantidadActual + 1;
        $this->saveCarrito($carrito);

        return back()->with('success', '"'.$producto->nombre.'" agregado al carrito.');
    }

    public function update(Request $request, Producto $producto)
    {
        $cantidad = $request->validate(['cantidad' => 'required|integer|min:1'])['cantidad'];

        if ($cantidad > $producto->stock) {
            return back()->with('error', 'Stock insuficiente.');
        }

        $carrito = $this->getCarrito();
        $carrito[$producto->id] = $cantidad;
        $this->saveCarrito($carrito);

        return back()->with('success', 'Carrito actualizado.');
    }

    public function remove(Producto $producto)
    {
        $carrito = $this->getCarrito();
        unset($carrito[$producto->id]);
        $this->saveCarrito($carrito);

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function checkout(Request $request)
    {
        $carrito = $this->getCarrito();

        if (empty($carrito)) {
            return redirect()->route('cliente.carrito')->with('error', 'Tu carrito está vacío.');
        }

        $data = $request->validate([
            'direccion_entrega' => 'required|string|max:255',
            'telefono_contacto' => 'required|string|max:20',
            'notas' => 'nullable|string|max:500',
        ]);

        try {
            DB::transaction(function () use ($carrito, $data) {
                $total = 0;
                $itemsData = [];

                foreach ($carrito as $productoId => $cantidad) {
                    $producto = Producto::lockForUpdate()->find($productoId);
                    if (! $producto || $producto->stock < $cantidad) {
                        throw new \RuntimeException('Stock insuficiente para: '.($producto->nombre ?? 'producto'));
                    }
                    $subtotal = $producto->precio * $cantidad;
                    $total += $subtotal;
                    $itemsData[] = [
                        'producto' => $producto,
                        'cantidad' => $cantidad,
                        'subtotal' => $subtotal,
                    ];
                }

                $pedido = Pedido::create([
                    'user_id' => auth()->id(),
                    'tipo' => 'online',
                    'estado' => 'pendiente',
                    'total' => $total,
                    'direccion_entrega' => $data['direccion_entrega'],
                    'telefono_contacto' => $data['telefono_contacto'],
                    'notas' => $data['notas'] ?? null,
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
            return back()->with('error', $e->getMessage());
        }

        session()->forget('carrito');

        return redirect()->route('cliente.pedidos')->with('success', '¡Pedido realizado con éxito!');
    }
}
