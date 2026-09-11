<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\PortfolioItem;
use App\Models\Producto;
use App\Models\Promocion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicApiController extends Controller
{
    /**
     * Datos para la pantalla de inicio (Home) de la app móvil.
     */
    public function home(): JsonResponse
    {
        $destacados = Producto::with('categoria')
            ->where('activo', true)
            ->where('destacado', true)
            ->take(6)
            ->get();

        $promociones = Promocion::where('activo', true)
            ->where(function ($q) {
                $q->whereNull('fecha_fin')->orWhere('fecha_fin', '>=', now()->toDateString());
            })
            ->latest()
            ->take(5)
            ->get();

        $categorias = Categoria::where('activo', true)
            ->withCount(['productos' => function ($q) {
                $q->where('activo', true);
            }])
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'negocio' => [
                    'nombre' => 'Doña Ross',
                    'eslogan' => 'Sabor casero y tradicional a tu alcance',
                    'telefono' => '+591 70000000',
                    'direccion' => 'Av. Principal #123',
                ],
                'destacados' => $destacados,
                'promociones' => $promociones,
                'categorias' => $categorias,
            ],
        ]);
    }

    /**
     * Catálogo completo con filtros de búsqueda y paginación.
     */
    public function catalogo(Request $request): JsonResponse
    {
        $query = Producto::with('categoria')->where('activo', true);

        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%")
                  ->orWhere('descripcion', 'like', "%{$busqueda}%");
            });
        }

        // Ordenamiento
        $orden = $request->input('orden', 'recientes');
        match ($orden) {
            'precio_asc' => $query->orderBy('precio', 'asc'),
            'precio_desc' => $query->orderBy('precio', 'desc'),
            'nombre' => $query->orderBy('nombre', 'asc'),
            default => $query->latest(),
        };

        $perPage = min((int) $request->input('per_page', 12), 50);
        $productos = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $productos,
        ]);
    }

    /**
     * Listado general de productos activos.
     */
    public function productos(Request $request): JsonResponse
    {
        return $this->catalogo($request);
    }

    /**
     * Detalle de un producto individual por ID.
     */
    public function productoDetalle(int $id): JsonResponse
    {
        $producto = Producto::with('categoria')->find($id);

        if (! $producto || ! $producto->activo) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado o no disponible.',
            ], 404);
        }

        // Productos relacionados de la misma categoría
        $relacionados = Producto::where('categoria_id', $producto->categoria_id)
            ->where('id', '!=', $producto->id)
            ->where('activo', true)
            ->take(4)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'producto' => $producto,
                'relacionados' => $relacionados,
            ],
        ]);
    }

    /**
     * Lista de categorías activas con conteo de productos.
     */
    public function categorias(): JsonResponse
    {
        $categorias = Categoria::where('activo', true)
            ->withCount(['productos' => function ($q) {
                $q->where('activo', true);
            }])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categorias,
        ]);
    }

    /**
     * Lista de promociones activas y vigentes.
     */
    public function promociones(): JsonResponse
    {
        $promociones = Promocion::where('activo', true)
            ->where(function ($q) {
                $q->whereNull('fecha_fin')->orWhere('fecha_fin', '>=', now()->toDateString());
            })
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $promociones,
        ]);
    }

    /**
     * Detalle de una promoción por ID.
     */
    public function promocionDetalle(int $id): JsonResponse
    {
        $promocion = Promocion::find($id);

        if (! $promocion || ! $promocion->activo) {
            return response()->json([
                'success' => false,
                'message' => 'Promoción no encontrada.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $promocion,
        ]);
    }

    /**
     * Información y proyectos del Portafolio institucional.
     */
    public function portafolio(): JsonResponse
    {
        $items = PortfolioItem::where('activo', true)->orderBy('orden')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'todos' => $items,
                'agrupados' => [
                    'proyectos' => $items->where('tipo', 'proyecto')->values(),
                    'habilidades' => $items->where('tipo', 'habilidad')->values(),
                    'experiencias' => $items->where('tipo', 'experiencia')->values(),
                    'educacion' => $items->where('tipo', 'educacion')->values(),
                    'sobre_mi' => $items->where('tipo', 'sobre_mi')->first(),
                ],
            ],
        ]);
    }

    /**
     * Formulario rápido de delivery sin necesidad de autenticación previa.
     */
    public function delivery(Request $request): JsonResponse
    {
        $data = $request->validate([
            'cliente' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'pedido' => 'required|string|max:1000',
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Pedido de Doña Ross en camino! Nos comunicaremos contigo en breve.',
            'data' => $data,
        ], 201);
    }

    /**
     * Horarios de atención.
     */
    public function horarios(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'atencion' => [
                    ['dias' => 'Lunes a Viernes', 'horario' => '08:00 - 20:00'],
                    ['dias' => 'Sábados', 'horario' => '08:00 - 18:00'],
                    ['dias' => 'Domingos y Feriados', 'horario' => '09:00 - 15:00'],
                ],
                'delivery_disponible' => true,
                'telefono_contacto' => '+591 70000000',
            ],
        ]);
    }
}
