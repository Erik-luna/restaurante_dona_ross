<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DocsApiController extends Controller
{
    /**
     * Interfaz visual interactiva para la documentación de la API (Swagger UI).
     */
    public function ui()
    {
        return view('api.docs');
    }

    /**
     * Especificación OpenAPI 3.0 en formato JSON.
     */
    public function spec(Request $request): JsonResponse
    {
        $baseUrl = url('/');

        $spec = [
            'openapi' => '3.0.3',
            'info' => [
                'title' => 'API REST Doña Ross - Backend Oficial para App Flutter',
                'description' => 'Documentación interactiva de la API REST para el sistema Doña Ross. Incluye autenticación mediante Bearer Tokens con Laravel Sanctum, catálogo de productos, gestión de compras y checkout, módulos de personal de ventas y administración integral.',
                'version' => '1.0.0',
                'contact' => [
                    'name' => 'Soporte Doña Ross',
                    'email' => 'soporte@donaross.com',
                ],
            ],
            'servers' => [
                [
                    'url' => $baseUrl,
                    'description' => 'Servidor de la API',
                ],
            ],
            'components' => [
                'securitySchemes' => [
                    'bearerAuth' => [
                        'type' => 'http',
                        'scheme' => 'bearer',
                        'bearerFormat' => 'Sanctum Token',
                        'description' => 'Introduce tu token de acceso obtenido en /api/auth/login-cliente o /api/auth/login-admin con el formato: Bearer {token}',
                    ],
                ],
                'schemas' => [
                    'Producto' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer', 'example' => 1],
                            'categoria_id' => ['type' => 'integer', 'nullable' => true, 'example' => 2],
                            'nombre' => ['type' => 'string', 'example' => 'Torta de Chocolate Casera'],
                            'descripcion' => ['type' => 'string', 'example' => 'Deliciosa torta artesanal con relleno de dulce de leche'],
                            'precio' => ['type' => 'string', 'example' => '45.00'],
                            'stock' => ['type' => 'integer', 'example' => 15],
                            'imagen' => ['type' => 'string', 'nullable' => true, 'example' => 'productos/torta.jpg'],
                            'imagen_url' => ['type' => 'string', 'nullable' => true, 'example' => $baseUrl . '/storage/productos/torta.jpg'],
                            'destacado' => ['type' => 'boolean', 'example' => true],
                            'activo' => ['type' => 'boolean', 'example' => true],
                            'categoria' => ['$ref' => '#/components/schemas/Categoria'],
                        ],
                    ],
                    'Categoria' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer', 'example' => 1],
                            'nombre' => ['type' => 'string', 'example' => 'Pastelería y Repostería'],
                            'descripcion' => ['type' => 'string', 'example' => 'Tortas, postres y bocaditos'],
                            'activo' => ['type' => 'boolean', 'example' => true],
                            'productos_count' => ['type' => 'integer', 'example' => 8],
                        ],
                    ],
                    'Promocion' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer', 'example' => 1],
                            'titulo' => ['type' => 'string', 'example' => '2x1 en Empanadas los Jueves'],
                            'descripcion' => ['type' => 'string', 'example' => 'Válido para pedidos online y consumo en local'],
                            'descuento_porcentaje' => ['type' => 'string', 'nullable' => true, 'example' => '20.00'],
                            'fecha_inicio' => ['type' => 'string', 'format' => 'date', 'example' => '2026-09-01'],
                            'fecha_fin' => ['type' => 'string', 'format' => 'date', 'example' => '2026-09-30'],
                            'imagen' => ['type' => 'string', 'nullable' => true, 'example' => 'promociones/promo1.jpg'],
                            'imagen_url' => ['type' => 'string', 'nullable' => true, 'example' => $baseUrl . '/storage/promociones/promo1.jpg'],
                            'activo' => ['type' => 'boolean', 'example' => true],
                        ],
                    ],
                    'Pedido' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer', 'example' => 10],
                            'user_id' => ['type' => 'integer', 'example' => 5],
                            'tipo' => ['type' => 'string', 'enum' => ['online', 'local'], 'example' => 'online'],
                            'estado' => ['type' => 'string', 'enum' => ['pendiente', 'confirmado', 'preparando', 'enviado', 'entregado', 'cancelado'], 'example' => 'pendiente'],
                            'total' => ['type' => 'string', 'example' => '90.00'],
                            'direccion_entrega' => ['type' => 'string', 'nullable' => true, 'example' => 'Calle Los Olivos #456'],
                            'telefono_contacto' => ['type' => 'string', 'nullable' => true, 'example' => '70012345'],
                            'notas' => ['type' => 'string', 'nullable' => true, 'example' => 'Por favor incluir cubiertos'],
                            'atendido_por' => ['type' => 'integer', 'nullable' => true, 'example' => null],
                            'created_at' => ['type' => 'string', 'format' => 'date-time'],
                            'items' => [
                                'type' => 'array',
                                'items' => ['$ref' => '#/components/schemas/PedidoItem'],
                            ],
                        ],
                    ],
                    'PedidoItem' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer', 'example' => 1],
                            'pedido_id' => ['type' => 'integer', 'example' => 10],
                            'producto_id' => ['type' => 'integer', 'example' => 1],
                            'cantidad' => ['type' => 'integer', 'example' => 2],
                            'precio_unitario' => ['type' => 'string', 'example' => '45.00'],
                            'subtotal' => ['type' => 'string', 'example' => '90.00'],
                            'producto' => ['$ref' => '#/components/schemas/Producto'],
                        ],
                    ],
                    'Usuario' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer', 'example' => 1],
                            'name' => ['type' => 'string', 'example' => 'Juan Pérez'],
                            'email' => ['type' => 'string', 'example' => 'juan@example.com'],
                            'role' => ['type' => 'string', 'enum' => ['cliente', 'personal', 'admin'], 'example' => 'cliente'],
                            'telefono' => ['type' => 'string', 'nullable' => true, 'example' => '70012345'],
                            'direccion' => ['type' => 'string', 'nullable' => true, 'example' => 'Av. América #789'],
                            'activo' => ['type' => 'boolean', 'example' => true],
                        ],
                    ],
                ],
            ],
            'paths' => [
                // --- RUTAS PÚBLICAS ---
                '/api/home' => [
                    'get' => [
                        'tags' => ['Público'],
                        'summary' => 'Datos para la pantalla principal de la App',
                        'description' => 'Retorna productos destacados, promociones vigentes, categorías con conteo y datos generales de la tienda Doña Ross.',
                        'responses' => [
                            '200' => ['description' => 'Datos cargados exitosamente'],
                        ],
                    ],
                ],
                '/api/catalogo' => [
                    'get' => [
                        'tags' => ['Público'],
                        'summary' => 'Catálogo con filtros, búsqueda y paginación',
                        'parameters' => [
                            ['name' => 'categoria', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer'], 'description' => 'Filtrar por ID de categoría'],
                            ['name' => 'buscar', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'string'], 'description' => 'Texto a buscar en nombre o descripción'],
                            ['name' => 'orden', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'string', 'enum' => ['recientes', 'precio_asc', 'precio_desc', 'nombre']], 'description' => 'Criterio de ordenamiento'],
                            ['name' => 'per_page', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer', 'default' => 12], 'description' => 'Resultados por página'],
                            ['name' => 'page', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer', 'default' => 1], 'description' => 'Número de página'],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Lista paginada de productos'],
                        ],
                    ],
                ],
                '/api/productos/{id}' => [
                    'get' => [
                        'tags' => ['Público'],
                        'summary' => 'Detalle de un producto',
                        'parameters' => [
                            ['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Detalle del producto y productos relacionados'],
                            '404' => ['description' => 'Producto no encontrado'],
                        ],
                    ],
                ],
                '/api/categorias' => [
                    'get' => [
                        'tags' => ['Público'],
                        'summary' => 'Listado de categorías activas',
                        'responses' => [
                            '200' => ['description' => 'Categorías con número de productos activos'],
                        ],
                    ],
                ],
                '/api/promociones' => [
                    'get' => [
                        'tags' => ['Público'],
                        'summary' => 'Listado de promociones activas vigentes',
                        'responses' => [
                            '200' => ['description' => 'Lista de promociones vigentes'],
                        ],
                    ],
                ],
                '/api/promociones/{id}' => [
                    'get' => [
                        'tags' => ['Público'],
                        'summary' => 'Detalle de una promoción específica',
                        'parameters' => [
                            ['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Datos de la promoción'],
                            '404' => ['description' => 'Promoción no encontrada'],
                        ],
                    ],
                ],
                '/api/portafolio' => [
                    'get' => [
                        'tags' => ['Público'],
                        'summary' => 'Elementos del portafolio (proyectos, habilidades, etc.)',
                        'responses' => [
                            '200' => ['description' => 'Portafolio institucional agrupado y ordenado'],
                        ],
                    ],
                ],
                '/api/delivery/enviar' => [
                    'post' => [
                        'tags' => ['Público'],
                        'summary' => 'Envío rápido de solicitud de delivery',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['cliente', 'direccion', 'telefono', 'pedido'],
                                        'properties' => [
                                            'cliente' => ['type' => 'string', 'example' => 'María Gutiérrez'],
                                            'direccion' => ['type' => 'string', 'example' => 'Calle Sucre #210'],
                                            'telefono' => ['type' => 'string', 'example' => '71234567'],
                                            'pedido' => ['type' => 'string', 'example' => '2 porciones de pastel y 1 refresco'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            '201' => ['description' => 'Solicitud registrada'],
                            '422' => ['description' => 'Error de validación'],
                        ],
                    ],
                ],
                '/api/horarios' => [
                    'get' => [
                        'tags' => ['Público'],
                        'summary' => 'Horarios de atención de Doña Ross',
                        'responses' => [
                            '200' => ['description' => 'Horarios y días de atención'],
                        ],
                    ],
                ],

                // --- AUTENTICACIÓN ---
                '/api/auth/register' => [
                    'post' => [
                        'tags' => ['Autenticación'],
                        'summary' => 'Registro de nuevo cliente',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['name', 'email', 'password', 'password_confirmation'],
                                        'properties' => [
                                            'name' => ['type' => 'string', 'example' => 'Carlos López'],
                                            'email' => ['type' => 'string', 'format' => 'email', 'example' => 'carlos@example.com'],
                                            'password' => ['type' => 'string', 'format' => 'password', 'example' => 'password123'],
                                            'password_confirmation' => ['type' => 'string', 'format' => 'password', 'example' => 'password123'],
                                            'telefono' => ['type' => 'string', 'example' => '78901234'],
                                            'direccion' => ['type' => 'string', 'example' => 'Calle Comercio #55'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            '201' => ['description' => 'Registro exitoso con token Sanctum'],
                            '422' => ['description' => 'Error de validación'],
                        ],
                    ],
                ],
                '/api/auth/login-cliente' => [
                    'post' => [
                        'tags' => ['Autenticación'],
                        'summary' => 'Login para usuarios clientes',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['email', 'password'],
                                        'properties' => [
                                            'email' => ['type' => 'string', 'format' => 'email', 'example' => 'cliente@donaross.com'],
                                            'password' => ['type' => 'string', 'format' => 'password', 'example' => 'password123'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Login exitoso, retorna token y usuario'],
                            '401' => ['description' => 'Credenciales inválidas'],
                            '403' => ['description' => 'Cuenta desactivada o rol no autorizado'],
                        ],
                    ],
                ],
                '/api/auth/login-admin' => [
                    'post' => [
                        'tags' => ['Autenticación'],
                        'summary' => 'Login para Staff (Admin o Personal)',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['email', 'password'],
                                        'properties' => [
                                            'email' => ['type' => 'string', 'format' => 'email', 'example' => 'admin@donaross.com'],
                                            'password' => ['type' => 'string', 'format' => 'password', 'example' => 'password123'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Login exitoso para staff'],
                            '401' => ['description' => 'Credenciales incorrectas'],
                            '403' => ['description' => 'No es staff o cuenta desactivada'],
                        ],
                    ],
                ],
                '/api/auth/me' => [
                    'get' => [
                        'tags' => ['Autenticación'],
                        'summary' => 'Obtener perfil del usuario autenticado actual',
                        'security' => [['bearerAuth' => []]],
                        'responses' => [
                            '200' => ['description' => 'Datos del usuario autenticado'],
                            '401' => ['description' => 'No autenticado'],
                        ],
                    ],
                ],
                '/api/auth/logout' => [
                    'post' => [
                        'tags' => ['Autenticación'],
                        'summary' => 'Cerrar sesión (revocar token)',
                        'security' => [['bearerAuth' => []]],
                        'responses' => [
                            '200' => ['description' => 'Sesión cerrada y token revocado'],
                        ],
                    ],
                ],
                '/api/auth/recuperar-password/codigo' => [
                    'post' => [
                        'tags' => ['Autenticación'],
                        'summary' => 'Paso 1: Solicitar código de recuperación de contraseña',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['email'],
                                        'properties' => [
                                            'email' => ['type' => 'string', 'format' => 'email', 'example' => 'cliente@donaross.com'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Código generado con éxito (vigencia 15 min)'],
                            '404' => ['description' => 'No existe cliente activo con ese correo'],
                        ],
                    ],
                ],
                '/api/auth/recuperar-password/cambiar' => [
                    'post' => [
                        'tags' => ['Autenticación'],
                        'summary' => 'Paso 2: Validar código y cambiar contraseña',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['email', 'codigo', 'password', 'password_confirmation'],
                                        'properties' => [
                                            'email' => ['type' => 'string', 'format' => 'email', 'example' => 'cliente@donaross.com'],
                                            'codigo' => ['type' => 'string', 'example' => '123456'],
                                            'password' => ['type' => 'string', 'format' => 'password', 'example' => 'nuevaPassword123'],
                                            'password_confirmation' => ['type' => 'string', 'format' => 'password', 'example' => 'nuevaPassword123'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Contraseña actualizada correctamente'],
                            '422' => ['description' => 'Código incorrecto o expirado'],
                        ],
                    ],
                ],

                // --- CLIENTE ---
                '/api/cliente/dashboard' => [
                    'get' => [
                        'tags' => ['Cliente'],
                        'summary' => 'Métricas y pedidos recientes del cliente autenticado',
                        'security' => [['bearerAuth' => []]],
                        'responses' => [
                            '200' => ['description' => 'Estadísticas y pedidos recientes'],
                        ],
                    ],
                ],
                '/api/cliente/perfil' => [
                    'get' => [
                        'tags' => ['Cliente'],
                        'summary' => 'Perfil del cliente',
                        'security' => [['bearerAuth' => []]],
                        'responses' => [
                            '200' => ['description' => 'Datos del perfil'],
                        ],
                    ],
                    'put' => [
                        'tags' => ['Cliente'],
                        'summary' => 'Actualizar datos de perfil del cliente',
                        'security' => [['bearerAuth' => []]],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['name'],
                                        'properties' => [
                                            'name' => ['type' => 'string', 'example' => 'Carlos López'],
                                            'telefono' => ['type' => 'string', 'example' => '77665544'],
                                            'direccion' => ['type' => 'string', 'example' => 'Calle Cochabamba #123'],
                                            'password' => ['type' => 'string', 'nullable' => true, 'example' => 'nuevaClave123'],
                                            'password_confirmation' => ['type' => 'string', 'nullable' => true, 'example' => 'nuevaClave123'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Perfil actualizado'],
                        ],
                    ],
                ],
                '/api/cliente/pedidos' => [
                    'get' => [
                        'tags' => ['Cliente'],
                        'summary' => 'Historial de pedidos del cliente autenticado',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [
                            ['name' => 'estado', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'string']],
                            ['name' => 'page', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer']],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Lista paginada de pedidos'],
                        ],
                    ],
                ],
                '/api/cliente/pedidos/{id}' => [
                    'get' => [
                        'tags' => ['Cliente'],
                        'summary' => 'Detalle de un pedido individual del cliente',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [
                            ['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Detalle completo del pedido'],
                            '404' => ['description' => 'Pedido no encontrado'],
                        ],
                    ],
                ],
                '/api/cliente/checkout' => [
                    'post' => [
                        'tags' => ['Cliente'],
                        'summary' => 'Procesar compra/pedido online desde el carrito de la App Flutter',
                        'security' => [['bearerAuth' => []]],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['direccion_entrega', 'telefono_contacto', 'items'],
                                        'properties' => [
                                            'direccion_entrega' => ['type' => 'string', 'example' => 'Av. Heroínas #500 Edificio A Depto 3B'],
                                            'telefono_contacto' => ['type' => 'string', 'example' => '70012345'],
                                            'notas' => ['type' => 'string', 'nullable' => true, 'example' => 'Enviar con cambio de 100'],
                                            'items' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'type' => 'object',
                                                    'required' => ['producto_id', 'cantidad'],
                                                    'properties' => [
                                                        'producto_id' => ['type' => 'integer', 'example' => 1],
                                                        'cantidad' => ['type' => 'integer', 'example' => 2],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            '201' => ['description' => 'Pedido creado exitosamente con descuento de stock automático'],
                            '422' => ['description' => 'Stock insuficiente o validación fallida'],
                        ],
                    ],
                ],

                // --- PERSONAL DE VENTAS ---
                '/api/personal/dashboard' => [
                    'get' => [
                        'tags' => ['Personal de Ventas'],
                        'summary' => 'Métricas de ventas y pedidos de hoy atendidos por el personal',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'Métricas del día']],
                    ],
                ],
                '/api/personal/clientes' => [
                    'get' => [
                        'tags' => ['Personal de Ventas'],
                        'summary' => 'Listado de clientes registrados con búsqueda',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [
                            ['name' => 'buscar', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'string']],
                            ['name' => 'page', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer']],
                        ],
                        'responses' => ['200' => ['description' => 'Lista paginada']],
                    ],
                    'post' => [
                        'tags' => ['Personal de Ventas'],
                        'summary' => 'Registrar nuevo cliente en mostrador',
                        'security' => [['bearerAuth' => []]],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['name', 'email', 'password'],
                                        'properties' => [
                                            'name' => ['type' => 'string', 'example' => 'Pedro Fernández'],
                                            'email' => ['type' => 'string', 'example' => 'pedro@example.com'],
                                            'password' => ['type' => 'string', 'example' => '123456'],
                                            'telefono' => ['type' => 'string', 'example' => '71122334'],
                                            'direccion' => ['type' => 'string', 'example' => 'Zona Central'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => ['201' => ['description' => 'Cliente registrado']],
                    ],
                ],
                '/api/personal/clientes/{id}' => [
                    'get' => [
                        'tags' => ['Personal de Ventas'],
                        'summary' => 'Detalle de cliente',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Detalle del cliente']],
                    ],
                    'put' => [
                        'tags' => ['Personal de Ventas'],
                        'summary' => 'Actualizar datos de cliente',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Cliente actualizado']],
                    ],
                    'delete' => [
                        'tags' => ['Personal de Ventas'],
                        'summary' => 'Eliminar cliente',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Cliente eliminado']],
                    ],
                ],
                '/api/personal/ventas/datos-creacion' => [
                    'get' => [
                        'tags' => ['Personal de Ventas'],
                        'summary' => 'Datos para el formulario de venta (productos disponibles y clientes)',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'Productos con stock y clientes']],
                    ],
                ],
                '/api/personal/ventas' => [
                    'get' => [
                        'tags' => ['Personal de Ventas'],
                        'summary' => 'Listado de ventas locales presenciales',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'Ventas paginadas']],
                    ],
                    'post' => [
                        'tags' => ['Personal de Ventas'],
                        'summary' => 'Registrar una venta presencial en local',
                        'security' => [['bearerAuth' => []]],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['user_id', 'items'],
                                        'properties' => [
                                            'user_id' => ['type' => 'integer', 'example' => 3, 'description' => 'ID del cliente que compra'],
                                            'notas' => ['type' => 'string', 'example' => 'Venta en caja principal'],
                                            'items' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'type' => 'object',
                                                    'required' => ['producto_id', 'cantidad'],
                                                    'properties' => [
                                                        'producto_id' => ['type' => 'integer', 'example' => 1],
                                                        'cantidad' => ['type' => 'integer', 'example' => 3],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => ['201' => ['description' => 'Venta registrada con éxito']],
                    ],
                ],
                '/api/personal/ventas/{id}' => [
                    'get' => [
                        'tags' => ['Personal de Ventas'],
                        'summary' => 'Detalle de venta local',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Detalle de la venta']],
                    ],
                ],

                // --- ADMINISTRADOR ---
                '/api/admin/dashboard' => [
                    'get' => [
                        'tags' => ['Administrador'],
                        'summary' => 'Resumen ejecutivo del sistema (métricas, caja, alertas de stock)',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'Estadísticas globales']],
                    ],
                ],
                '/api/admin/productos' => [
                    'get' => [
                        'tags' => ['Administrador - Productos'],
                        'summary' => 'Listar productos con filtros',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'Productos paginados']],
                    ],
                    'post' => [
                        'tags' => ['Administrador - Productos'],
                        'summary' => 'Crear nuevo producto (con imagen)',
                        'security' => [['bearerAuth' => []]],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'multipart/form-data' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['nombre', 'precio', 'stock'],
                                        'properties' => [
                                            'categoria_id' => ['type' => 'integer'],
                                            'nombre' => ['type' => 'string', 'example' => 'Tarta de Manzana'],
                                            'descripcion' => ['type' => 'string', 'example' => 'Relleno de manzanas caramelizadas'],
                                            'precio' => ['type' => 'number', 'example' => 35.50],
                                            'stock' => ['type' => 'integer', 'example' => 20],
                                            'imagen' => ['type' => 'string', 'format' => 'binary'],
                                            'destacado' => ['type' => 'boolean', 'example' => true],
                                            'activo' => ['type' => 'boolean', 'example' => true],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => ['201' => ['description' => 'Producto creado']],
                    ],
                ],
                '/api/admin/productos/{id}' => [
                    'get' => [
                        'tags' => ['Administrador - Productos'],
                        'summary' => 'Detalle de producto',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Detalle']],
                    ],
                    'post' => [
                        'tags' => ['Administrador - Productos'],
                        'summary' => 'Actualizar producto (admite multipart/form-data para imagen)',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Producto modificado']],
                    ],
                    'delete' => [
                        'tags' => ['Administrador - Productos'],
                        'summary' => 'Eliminar producto',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Producto eliminado']],
                    ],
                ],
                '/api/admin/categorias' => [
                    'get' => [
                        'tags' => ['Administrador - Categorías'],
                        'summary' => 'Listado de categorías con conteo de productos',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'Categorías']],
                    ],
                    'post' => [
                        'tags' => ['Administrador - Categorías'],
                        'summary' => 'Crear nueva categoría',
                        'security' => [['bearerAuth' => []]],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['nombre'],
                                        'properties' => [
                                            'nombre' => ['type' => 'string', 'example' => 'Bebidas Calientes'],
                                            'descripcion' => ['type' => 'string', 'example' => 'Cafetería, tés e infusiones'],
                                            'activo' => ['type' => 'boolean', 'example' => true],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => ['201' => ['description' => 'Categoría creada']],
                    ],
                ],
                '/api/admin/categorias/{id}' => [
                    'get' => [
                        'tags' => ['Administrador - Categorías'],
                        'summary' => 'Ver categoría',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Categoría']],
                    ],
                    'put' => [
                        'tags' => ['Administrador - Categorías'],
                        'summary' => 'Actualizar categoría',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Categoría actualizada']],
                    ],
                    'delete' => [
                        'tags' => ['Administrador - Categorías'],
                        'summary' => 'Eliminar categoría',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Categoría eliminada']],
                    ],
                ],
                '/api/admin/pedidos' => [
                    'get' => [
                        'tags' => ['Administrador - Pedidos Online'],
                        'summary' => 'Listar pedidos online con filtros por estado',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [
                            ['name' => 'estado', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'string', 'enum' => ['pendiente', 'confirmado', 'preparando', 'enviado', 'entregado', 'cancelado']]],
                            ['name' => 'page', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer']],
                        ],
                        'responses' => ['200' => ['description' => 'Lista de pedidos']],
                    ],
                ],
                '/api/admin/pedidos/{id}' => [
                    'get' => [
                        'tags' => ['Administrador - Pedidos Online'],
                        'summary' => 'Detalle de un pedido con cliente e items',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Detalle de pedido']],
                    ],
                ],
                '/api/admin/pedidos/{id}/estado' => [
                    'patch' => [
                        'tags' => ['Administrador - Pedidos Online'],
                        'summary' => 'Actualizar estado del pedido online',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['estado'],
                                        'properties' => [
                                            'estado' => ['type' => 'string', 'enum' => ['pendiente', 'confirmado', 'preparando', 'enviado', 'entregado', 'cancelado'], 'example' => 'preparando'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => ['200' => ['description' => 'Estado actualizado']],
                    ],
                ],
                '/api/admin/stock' => [
                    'get' => [
                        'tags' => ['Administrador - Stock'],
                        'summary' => 'Visualización rápida del inventario de productos',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'Lista de productos con cantidades']],
                    ],
                ],
                '/api/admin/stock/{id}' => [
                    'put' => [
                        'tags' => ['Administrador - Stock'],
                        'summary' => 'Actualización directa del stock de un producto',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['stock'],
                                        'properties' => [
                                            'stock' => ['type' => 'integer', 'example' => 25],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => ['200' => ['description' => 'Stock actualizado']],
                    ],
                ],
                '/api/admin/personal' => [
                    'get' => [
                        'tags' => ['Administrador - Personal'],
                        'summary' => 'Visualización de usuarios de tipo Personal (solo lectura)',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'Lista de personal']],
                    ],
                ],
                '/api/admin/personal/{id}' => [
                    'get' => [
                        'tags' => ['Administrador - Personal'],
                        'summary' => 'Detalle de un usuario de tipo Personal',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Detalle']],
                    ],
                ],
                '/api/admin/promociones' => [
                    'get' => [
                        'tags' => ['Administrador - Promociones'],
                        'summary' => 'Listar todas las promociones',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'Lista de promociones']],
                    ],
                    'post' => [
                        'tags' => ['Administrador - Promociones'],
                        'summary' => 'Crear promoción',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['201' => ['description' => 'Promoción creada']],
                    ],
                ],
                '/api/admin/promociones/{id}' => [
                    'get' => [
                        'tags' => ['Administrador - Promociones'],
                        'summary' => 'Ver promoción',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Detalle']],
                    ],
                    'post' => [
                        'tags' => ['Administrador - Promociones'],
                        'summary' => 'Actualizar promoción',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Actualizada']],
                    ],
                    'delete' => [
                        'tags' => ['Administrador - Promociones'],
                        'summary' => 'Eliminar promoción',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Eliminada']],
                    ],
                ],
                '/api/admin/portafolio' => [
                    'get' => [
                        'tags' => ['Administrador - Portafolio'],
                        'summary' => 'Listar items de portafolio para administración',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'Items de portafolio']],
                    ],
                    'post' => [
                        'tags' => ['Administrador - Portafolio'],
                        'summary' => 'Crear nuevo item de portafolio',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['201' => ['description' => 'Creado']],
                    ],
                ],
                '/api/admin/portafolio/{id}' => [
                    'get' => [
                        'tags' => ['Administrador - Portafolio'],
                        'summary' => 'Detalle de item de portafolio',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Detalle']],
                    ],
                    'post' => [
                        'tags' => ['Administrador - Portafolio'],
                        'summary' => 'Actualizar item de portafolio',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Actualizado']],
                    ],
                    'delete' => [
                        'tags' => ['Administrador - Portafolio'],
                        'summary' => 'Eliminar item de portafolio',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Eliminado']],
                    ],
                ],
                '/api/admin/ventas' => [
                    'get' => [
                        'tags' => ['Administrador - Ventas'],
                        'summary' => 'Listar todas las ventas locales registradas',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'Ventas']],
                    ],
                    'post' => [
                        'tags' => ['Administrador - Ventas'],
                        'summary' => 'Registrar venta como administrador',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['201' => ['description' => 'Venta registrada']],
                    ],
                ],
                '/api/admin/ventas/{id}' => [
                    'get' => [
                        'tags' => ['Administrador - Ventas'],
                        'summary' => 'Detalle de venta',
                        'security' => [['bearerAuth' => []]],
                        'parameters' => [['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']]],
                        'responses' => ['200' => ['description' => 'Detalle']],
                    ],
                ],
            ],
        ];

        return response()->json($spec);
    }
}
