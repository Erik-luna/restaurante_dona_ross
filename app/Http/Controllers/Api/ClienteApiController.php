<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClienteApiController extends Controller
{
    /**
     * Resumen para el dashboard del cliente.
     */
    public function dashboard(Request $request): JsonResponse
    {
        $user = $request->user();

        $pedidosRecientes = $user->pedidos()
            ->with('items.producto')
            ->latest()
            ->take(5)
            ->get();

        $totalPedidos = $user->pedidos()->count();
        $pedidosPendientes = $user->pedidos()->where('estado', 'pendiente')->count();
        $pedidosEnCamino = $user->pedidos()->whereIn('estado', ['confirmado', 'preparando', 'enviado'])->count();
        $pedidosEntregados = $user->pedidos()->where('estado', 'entregado')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'usuario' => $user,
                'estadisticas' => [
                    'total_pedidos' => $totalPedidos,
                    'pendientes' => $pedidosPendientes,
                    'en_camino' => $pedidosEnCamino,
                    'entregados' => $pedidosEntregados,
                ],
                'pedidos_recientes' => $pedidosRecientes,
            ],
        ]);
    }

    /**
     * Ver perfil del cliente.
     */
    public function perfil(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    }

    /**
     * Actualizar perfil del cliente autenticado.
     */
    public function updatePerfil(Request $request): JsonResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = strip_tags($data['name']);
        $user->telefono = isset($data['telefono']) ? strip_tags($data['telefono']) : null;
        $user->direccion = isset($data['direccion']) ? strip_tags($data['direccion']) : null;

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Perfil actualizado correctamente.',
            'data' => $user,
        ]);
    }

    /**
     * Historial de pedidos del cliente con paginación y filtro opcional por estado.
     */
    public function pedidos(Request $request): JsonResponse
    {
        $query = $request->user()->pedidos()->with('items.producto');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $perPage = min((int) $request->input('per_page', 10), 30);
        $pedidos = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $pedidos,
        ]);
    }

    /**
     * Detalle completo de un pedido individual del cliente.
     */
    public function pedidoDetalle(Request $request, int $id): JsonResponse
    {
        $pedido = $request->user()
            ->pedidos()
            ->with(['items.producto.categoria', 'atendidoPor'])
            ->find($id);

        if (! $pedido) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pedido,
        ]);
    }

    /**
     * Checkout de la aplicación móvil para pedidos online.
     * Recibe la lista de items del carrito y procesa la compra atómicamente.
     */
    public function checkout(Request $request): JsonResponse
    {
        $data = $request->validate([
            'direccion_entrega' => 'required|string|max:255',
            'telefono_contacto' => 'required|string|max:20',
            'notas' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|integer|exists:productos,id',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);

        try {
            $pedidoCreado = DB::transaction(function () use ($data, $request) {
                $total = 0;
                $itemsAProcesar = [];

                foreach ($data['items'] as $item) {
                    $producto = Producto::lockForUpdate()->find($item['producto_id']);

                    if (! $producto || ! $producto->activo) {
                        throw new \RuntimeException("El producto ID {$item['producto_id']} no está disponible.");
                    }

                    if ($producto->stock < $item['cantidad']) {
                        throw new \RuntimeException("Stock insuficiente para: {$producto->nombre}. Stock disponible: {$producto->stock}.");
                    }

                    $subtotal = $producto->precio * $item['cantidad'];
                    $total += $subtotal;

                    $itemsAProcesar[] = [
                        'producto' => $producto,
                        'cantidad' => $item['cantidad'],
                        'precio_unitario' => $producto->precio,
                        'subtotal' => $subtotal,
                    ];
                }

                $pedido = Pedido::create([
                    'user_id' => $request->user()->id,
                    'tipo' => 'online',
                    'estado' => 'pendiente',
                    'total' => $total,
                    'direccion_entrega' => $data['direccion_entrega'],
                    'telefono_contacto' => $data['telefono_contacto'],
                    'notas' => $data['notas'] ?? null,
                ]);

                foreach ($itemsAProcesar as $itemData) {
                    PedidoItem::create([
                        'pedido_id' => $pedido->id,
                        'producto_id' => $itemData['producto']->id,
                        'cantidad' => $itemData['cantidad'],
                        'precio_unitario' => $itemData['precio_unitario'],
                        'subtotal' => $itemData['subtotal'],
                    ]);

                    $itemData['producto']->decrement('stock', $itemData['cantidad']);
                }

                return $pedido->load('items.producto');
            });

            return response()->json([
                'success' => true,
                'message' => '¡Pedido realizado con éxito!',
                'data' => $pedidoCreado,
            ], 201);

        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar el pedido. Intenta nuevamente.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
