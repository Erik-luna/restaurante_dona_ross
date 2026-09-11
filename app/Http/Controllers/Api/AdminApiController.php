<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\PortfolioItem;
use App\Models\Producto;
use App\Models\Promocion;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminApiController extends Controller
{
    /**
     * Resumen general del sistema y estadísticas clave.
     */
    public function dashboard(): JsonResponse
    {
        $stats = [
            'productos_total' => Producto::count(),
            'productos_activos' => Producto::where('activo', true)->count(),
            'clientes_total' => User::where('role', 'cliente')->count(),
            'personal_total' => User::where('role', 'personal')->count(),
            'pedidos_hoy' => Pedido::whereDate('created_at', today())->count(),
            'ventas_hoy_monto' => (float) Pedido::whereDate('created_at', today())->sum('total'),
            'pedidos_pendientes' => Pedido::where('estado', 'pendiente')->count(),
            'stock_bajo' => Producto::where('stock', '<=', 5)->count(),
        ];

        $pedidosRecientes = Pedido::with(['user', 'items.producto'])
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'estadisticas' => $stats,
                'pedidos_recientes' => $pedidosRecientes,
            ],
        ]);
    }

    /* -------------------------------------------------------------
     * CRUD PRODUCTOS
     * ------------------------------------------------------------- */

    public function indexProductos(Request $request): JsonResponse
    {
        $query = Producto::with('categoria');

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('activo')) {
            $query->where('activo', $request->boolean('activo'));
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $productos = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $productos,
        ]);
    }

    public function showProducto(int $id): JsonResponse
    {
        $producto = Producto::with('categoria')->find($id);

        if (! $producto) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado.'], 404);
        }

        return response()->json(['success' => true, 'data' => $producto]);
    }

    public function storeProducto(Request $request): JsonResponse
    {
        $data = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|max:2048',
            'destacado' => 'nullable|boolean',
            'activo' => 'nullable|boolean',
        ]);

        $data['destacado'] = $request->boolean('destacado', false);
        $data['activo'] = $request->boolean('activo', true);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Producto creado correctamente.',
            'data' => $producto->load('categoria'),
        ], 201);
    }

    public function updateProducto(Request $request, int $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (! $producto) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado.'], 404);
        }

        $data = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'imagen' => 'nullable|image|max:2048',
            'destacado' => 'nullable|boolean',
            'activo' => 'nullable|boolean',
        ]);

        if ($request->has('destacado')) {
            $data['destacado'] = $request->boolean('destacado');
        }

        if ($request->has('activo')) {
            $data['activo'] = $request->boolean('activo');
        }

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente.',
            'data' => $producto->load('categoria'),
        ]);
    }

    public function destroyProducto(int $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (! $producto) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado.'], 404);
        }

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente.',
        ]);
    }

    /* -------------------------------------------------------------
     * CRUD CATEGORÍAS
     * ------------------------------------------------------------- */

    public function indexCategorias(): JsonResponse
    {
        $categorias = Categoria::withCount('productos')->get();

        return response()->json(['success' => true, 'data' => $categorias]);
    }

    public function showCategoria(int $id): JsonResponse
    {
        $categoria = Categoria::with('productos')->find($id);

        if (! $categoria) {
            return response()->json(['success' => false, 'message' => 'Categoría no encontrada.'], 404);
        }

        return response()->json(['success' => true, 'data' => $categoria]);
    }

    public function storeCategoria(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
            'activo' => 'nullable|boolean',
        ]);

        $data['activo'] = $request->boolean('activo', true);
        $categoria = Categoria::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Categoría creada correctamente.',
            'data' => $categoria,
        ], 201);
    }

    public function updateCategoria(Request $request, int $id): JsonResponse
    {
        $categoria = Categoria::find($id);

        if (! $categoria) {
            return response()->json(['success' => false, 'message' => 'Categoría no encontrada.'], 404);
        }

        $data = $request->validate([
            'nombre' => 'sometimes|required|string|max:255|unique:categorias,nombre,'.$categoria->id,
            'descripcion' => 'nullable|string',
            'activo' => 'nullable|boolean',
        ]);

        if ($request->has('activo')) {
            $data['activo'] = $request->boolean('activo');
        }

        $categoria->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada correctamente.',
            'data' => $categoria,
        ]);
    }

    public function destroyCategoria(int $id): JsonResponse
    {
        $categoria = Categoria::withCount('productos')->find($id);

        if (! $categoria) {
            return response()->json(['success' => false, 'message' => 'Categoría no encontrada.'], 404);
        }

        if ($categoria->productos_count > 0) {
            return response()->json([
                'success' => false,
                'message' => "No se puede eliminar la categoría porque tiene {$categoria->productos_count} productos asociados.",
            ], 422);
        }

        $categoria->delete();

        return response()->json(['success' => true, 'message' => 'Categoría eliminada correctamente.']);
    }

    /* -------------------------------------------------------------
     * VISUALIZACIÓN DE PERSONAL Y CLIENTES (Solo lectura por rol)
     * ------------------------------------------------------------- */

    public function indexPersonal(Request $request): JsonResponse
    {
        $query = User::where('role', 'personal');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%")
                  ->orWhere('telefono', 'like', "%{$buscar}%");
            });
        }

        $personal = $query->latest()->paginate(15);

        return response()->json(['success' => true, 'data' => $personal]);
    }

    public function showPersonal(int $id): JsonResponse
    {
        $personal = User::where('role', 'personal')->find($id);

        if (! $personal) {
            return response()->json(['success' => false, 'message' => 'Personal no encontrado.'], 404);
        }

        return response()->json(['success' => true, 'data' => $personal]);
    }

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

        $clientes = $query->latest()->paginate(15);

        return response()->json(['success' => true, 'data' => $clientes]);
    }

    public function showCliente(int $id): JsonResponse
    {
        $cliente = User::where('role', 'cliente')->with('pedidos')->find($id);

        if (! $cliente) {
            return response()->json(['success' => false, 'message' => 'Cliente no encontrado.'], 404);
        }

        return response()->json(['success' => true, 'data' => $cliente]);
    }

    /* -------------------------------------------------------------
     * CRUD PROMOCIONES
     * ------------------------------------------------------------- */

    public function indexPromociones(Request $request): JsonResponse
    {
        $query = Promocion::query();

        if ($request->filled('activo')) {
            $query->where('activo', $request->boolean('activo'));
        }

        $promociones = $query->latest()->paginate(15);

        return response()->json(['success' => true, 'data' => $promociones]);
    }

    public function showPromocion(int $id): JsonResponse
    {
        $promocion = Promocion::find($id);

        if (! $promocion) {
            return response()->json(['success' => false, 'message' => 'Promoción no encontrada.'], 404);
        }

        return response()->json(['success' => true, 'data' => $promocion]);
    }

    public function storePromocion(Request $request): JsonResponse
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'imagen' => 'nullable|image|max:2048',
            'activo' => 'nullable|boolean',
        ]);

        $data['activo'] = $request->boolean('activo', true);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('promociones', 'public');
        }

        $promocion = Promocion::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Promoción creada correctamente.',
            'data' => $promocion,
        ], 201);
    }

    public function updatePromocion(Request $request, int $id): JsonResponse
    {
        $promocion = Promocion::find($id);

        if (! $promocion) {
            return response()->json(['success' => false, 'message' => 'Promoción no encontrada.'], 404);
        }

        $data = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'imagen' => 'nullable|image|max:2048',
            'activo' => 'nullable|boolean',
        ]);

        if ($request->has('activo')) {
            $data['activo'] = $request->boolean('activo');
        }

        if ($request->hasFile('imagen')) {
            if ($promocion->imagen) {
                Storage::disk('public')->delete($promocion->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('promociones', 'public');
        }

        $promocion->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Promoción actualizada correctamente.',
            'data' => $promocion,
        ]);
    }

    public function destroyPromocion(int $id): JsonResponse
    {
        $promocion = Promocion::find($id);

        if (! $promocion) {
            return response()->json(['success' => false, 'message' => 'Promoción no encontrada.'], 404);
        }

        if ($promocion->imagen) {
            Storage::disk('public')->delete($promocion->imagen);
        }

        $promocion->delete();

        return response()->json(['success' => true, 'message' => 'Promoción eliminada correctamente.']);
    }

    /* -------------------------------------------------------------
     * CRUD PORTAFOLIO
     * ------------------------------------------------------------- */

    public function indexPortafolio(Request $request): JsonResponse
    {
        $query = PortfolioItem::query();

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $items = $query->orderBy('orden')->paginate(15);

        return response()->json(['success' => true, 'data' => $items]);
    }

    public function showPortafolio(int $id): JsonResponse
    {
        $item = PortfolioItem::find($id);

        if (! $item) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado.'], 404);
        }

        return response()->json(['success' => true, 'data' => $item]);
    }

    public function storePortafolio(Request $request): JsonResponse
    {
        $data = $request->validate([
            'tipo' => 'required|in:proyecto,habilidad,experiencia,educacion,sobre_mi',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tecnologias' => 'nullable|string|max:255',
            'enlace' => 'nullable|url|max:255',
            'imagen' => 'nullable|image|max:2048',
            'orden' => 'nullable|integer|min:0',
            'activo' => 'nullable|boolean',
        ]);

        $data['activo'] = $request->boolean('activo', true);
        $data['orden'] = $data['orden'] ?? 0;

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('portafolio', 'public');
        }

        $item = PortfolioItem::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Elemento de portafolio creado correctamente.',
            'data' => $item,
        ], 201);
    }

    public function updatePortafolio(Request $request, int $id): JsonResponse
    {
        $item = PortfolioItem::find($id);

        if (! $item) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado.'], 404);
        }

        $data = $request->validate([
            'tipo' => 'sometimes|required|in:proyecto,habilidad,experiencia,educacion,sobre_mi',
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'tecnologias' => 'nullable|string|max:255',
            'enlace' => 'nullable|url|max:255',
            'imagen' => 'nullable|image|max:2048',
            'orden' => 'nullable|integer|min:0',
            'activo' => 'nullable|boolean',
        ]);

        if ($request->has('activo')) {
            $data['activo'] = $request->boolean('activo');
        }

        if ($request->hasFile('imagen')) {
            if ($item->imagen) {
                Storage::disk('public')->delete($item->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('portafolio', 'public');
        }

        $item->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Elemento actualizado correctamente.',
            'data' => $item,
        ]);
    }

    public function destroyPortafolio(int $id): JsonResponse
    {
        $item = PortfolioItem::find($id);

        if (! $item) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado.'], 404);
        }

        if ($item->imagen) {
            Storage::disk('public')->delete($item->imagen);
        }

        $item->delete();

        return response()->json(['success' => true, 'message' => 'Elemento eliminado correctamente.']);
    }

    /* -------------------------------------------------------------
     * GESTIÓN DE PEDIDOS ONLINE
     * ------------------------------------------------------------- */

    public function indexPedidos(Request $request): JsonResponse
    {
        $query = Pedido::with(['user', 'items.producto'])->where('tipo', 'online');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $pedidos = $query->latest()->paginate(15);

        return response()->json(['success' => true, 'data' => $pedidos]);
    }

    public function showPedido(int $id): JsonResponse
    {
        $pedido = Pedido::with(['user', 'items.producto', 'atendidoPor'])->find($id);

        if (! $pedido) {
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado.'], 404);
        }

        return response()->json(['success' => true, 'data' => $pedido]);
    }

    public function updateEstadoPedido(Request $request, int $id): JsonResponse
    {
        $pedido = Pedido::find($id);

        if (! $pedido) {
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado.'], 404);
        }

        $data = $request->validate([
            'estado' => 'required|in:pendiente,confirmado,preparando,enviado,entregado,cancelado',
        ]);

        $pedido->update([
            'estado' => $data['estado'],
            'atendido_por' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estado del pedido actualizado.',
            'data' => $pedido->fresh(['user', 'items.producto', 'atendidoPor']),
        ]);
    }

    /* -------------------------------------------------------------
     * GESTIÓN DE STOCK
     * ------------------------------------------------------------- */

    public function indexStock(): JsonResponse
    {
        $productos = Producto::with('categoria')
            ->orderBy('stock', 'asc')
            ->get();

        return response()->json(['success' => true, 'data' => $productos]);
    }

    public function updateStock(Request $request, int $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (! $producto) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado.'], 404);
        }

        $data = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $producto->update(['stock' => $data['stock']]);

        return response()->json([
            'success' => true,
            'message' => "Stock de {$producto->nombre} actualizado a {$producto->stock}.",
            'data' => $producto,
        ]);
    }

    /* -------------------------------------------------------------
     * GESTIÓN DE VENTAS
     * ------------------------------------------------------------- */

    public function indexVentas(Request $request): JsonResponse
    {
        $query = Pedido::with(['user', 'atendidoPor', 'items.producto'])->where('tipo', 'local');

        $ventas = $query->latest()->paginate(15);

        return response()->json(['success' => true, 'data' => $ventas]);
    }

    public function showVenta(int $id): JsonResponse
    {
        $venta = Pedido::with(['user', 'atendidoPor', 'items.producto'])
            ->where('tipo', 'local')
            ->find($id);

        if (! $venta) {
            return response()->json(['success' => false, 'message' => 'Venta no encontrada.'], 404);
        }

        return response()->json(['success' => true, 'data' => $venta]);
    }

    public function storeVenta(Request $request): JsonResponse
    {
        // Reutilizamos la lógica del personal con atendido_por = admin actual
        $personalController = new PersonalApiController();

        return $personalController->storeVenta($request);
    }
}
