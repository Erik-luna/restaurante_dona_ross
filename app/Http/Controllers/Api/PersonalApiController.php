<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PersonalApiController extends Controller
{
    /**
     * Dashboard con métricas del día para el personal de ventas.
     */
    public function dashboard(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $stats = [
            'ventas_hoy_monto' => (float) Pedido::where('atendido_por', $userId)
                ->whereDate('created_at', today())
                ->sum('total'),
            'pedidos_hoy_cantidad' => Pedido::where('atendido_por', $userId)
                ->whereDate('created_at', today())
                ->count(),
            'total_clientes' => User::where('role', 'cliente')->count(),
            'ultimas_ventas' => Pedido::with(['user', 'items.producto'])
                ->where('atendido_por', $userId)
                ->latest()
                ->take(5)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Listado de clientes con paginación y búsqueda.
     */
    public function indexClientes(Request $request): JsonResponse
    {
        $query = User::where('role', 'cliente');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%")
                  ->orWhere('telefono', 'like', "%{$buscar}%");
            });
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $clientes = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $clientes,
        ]);
    }

    /**
     * Detalle de un cliente.
     */
    public function showCliente(int $id): JsonResponse
    {
        $cliente = User::where('role', 'cliente')->with('pedidos')->find($id);

        if (! $cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $cliente,
        ]);
    }

    /**
     * Registrar un nuevo cliente desde mostrador o personal.
     */
    public function storeCliente(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        $cliente = User::create([
            'name' => strip_tags($data['name']),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'cliente',
            'telefono' => isset($data['telefono']) ? strip_tags($data['telefono']) : null,
            'direccion' => isset($data['direccion']) ? strip_tags($data['direccion']) : null,
            'activo' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado correctamente.',
            'data' => $cliente,
        ], 201);
    }

    /**
     * Actualizar datos de un cliente existente.
     */
    public function updateCliente(Request $request, int $id): JsonResponse
    {
        $cliente = User::where('role', 'cliente')->find($id);

        if (! $cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado.',
            ], 404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$cliente->id,
            'password' => 'nullable|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ]);

        $cliente->name = strip_tags($data['name']);
        $cliente->email = $data['email'];
        $cliente->telefono = isset($data['telefono']) ? strip_tags($data['telefono']) : null;
        $cliente->direccion = isset($data['direccion']) ? strip_tags($data['direccion']) : null;

        if ($request->has('activo')) {
            $cliente->activo = $request->boolean('activo');
        }

        if (! empty($data['password'])) {
            $cliente->password = Hash::make($data['password']);
        }

        $cliente->save();

        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado correctamente.',
            'data' => $cliente,
        ]);
    }

    /**
     * Eliminar un cliente.
     */
    public function destroyCliente(int $id): JsonResponse
    {
        $cliente = User::where('role', 'cliente')->find($id);

        if (! $cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado.',
            ], 404);
        }

        $cliente->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente eliminado correctamente.',
        ]);
    }

    /**
     * Obtiene productos disponibles y clientes activos para armar una venta en mostrador.
     */
    public function datosCreacionVenta(): JsonResponse
    {
        $productos = Producto::where('activo', true)
            ->where('stock', '>', 0)
            ->orderBy('nombre')
            ->get();

        $clientes = User::where('role', 'cliente')
            ->where('activo', true)
            ->orderBy('name')
            ->select('id', 'name', 'email', 'telefono', 'direccion')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'productos' => $productos,
                'clientes' => $clientes,
            ],
        ]);
    }

    /**
     * Listado de ventas locales con paginación.
     */
    public function indexVentas(Request $request): JsonResponse
    {
        $query = Pedido::with(['user', 'atendidoPor', 'items.producto'])
            ->where('tipo', 'local');

        $perPage = min((int) $request->input('per_page', 15), 50);
        $ventas = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $ventas,
        ]);
    }

    /**
     * Detalle de una venta local específica.
     */
    public function showVenta(int $id): JsonResponse
    {
        $venta = Pedido::with(['user', 'atendidoPor', 'items.producto'])
            ->where('tipo', 'local')
            ->find($id);

        if (! $venta) {
            return response()->json([
                'success' => false,
                'message' => 'Venta no encontrada.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $venta,
        ]);
    }

    /**
     * Registrar una venta en local (presencial/mostrador).
     */
    public function storeVenta(Request $request): JsonResponse
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'notas' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|integer|exists:productos,id',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);

        try {
            $venta = DB::transaction(function () use ($data, $request) {
                $total = 0;
                $itemsAProcesar = [];

                foreach ($data['items'] as $item) {
                    $producto = Producto::lockForUpdate()->find($item['producto_id']);

                    if (! $producto || ! $producto->activo) {
                        throw new \RuntimeException("El producto ID {$item['producto_id']} no está activo.");
                    }

                    if ($producto->stock < $item['cantidad']) {
                        throw new \RuntimeException("Stock insuficiente para: {$producto->nombre}. Disponible: {$producto->stock}.");
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
                    'user_id' => $data['user_id'],
                    'tipo' => 'local',
                    'estado' => 'entregado',
                    'total' => $total,
                    'notas' => $data['notas'] ?? null,
                    'atendido_por' => $request->user()->id,
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

                return $pedido->load(['user', 'atendidoPor', 'items.producto']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Venta registrada correctamente.',
                'data' => $venta,
            ], 201);

        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la venta.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
