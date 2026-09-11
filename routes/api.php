<?php

use App\Http\Controllers\Api\AdminApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ClienteApiController;
use App\Http\Controllers\Api\DocsApiController;
use App\Http\Controllers\Api\PersonalApiController;
use App\Http\Controllers\Api\PublicApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Doña Ross Backend
|--------------------------------------------------------------------------
|
| Todas las rutas API cuentan con prefijo automático '/api'.
| Diseñadas para ser consumidas por aplicaciones móviles Flutter y clientes REST.
|
*/

// =========================================================================
// 1. DOCUMENTACIÓN VISUAL INTERACTIVA (SWAGGER UI & OPENAPI SPEC)
// =========================================================================
Route::get('/docs', [DocsApiController::class, 'ui'])->name('api.docs');
Route::get('/docs/openapi.json', [DocsApiController::class, 'spec'])->name('api.docs.spec');

// =========================================================================
// 2. RUTAS PÚBLICAS (Catálogo, Home, Promociones, Portafolio, Horarios)
// =========================================================================
Route::get('/home', [PublicApiController::class, 'home'])->name('api.home');
Route::get('/catalogo', [PublicApiController::class, 'catalogo'])->name('api.catalogo');
Route::get('/productos', [PublicApiController::class, 'productos'])->name('api.productos');
Route::get('/productos/{id}', [PublicApiController::class, 'productoDetalle'])->name('api.productos.show');
Route::get('/categorias', [PublicApiController::class, 'categorias'])->name('api.categorias');
Route::get('/promociones', [PublicApiController::class, 'promociones'])->name('api.promociones');
Route::get('/promociones/{id}', [PublicApiController::class, 'promocionDetalle'])->name('api.promociones.show');
Route::get('/portafolio', [PublicApiController::class, 'portafolio'])->name('api.portafolio');
Route::post('/delivery/enviar', [PublicApiController::class, 'delivery'])->name('api.delivery.store');
Route::get('/horarios', [PublicApiController::class, 'horarios'])->name('api.horarios');

// =========================================================================
// 3. AUTENTICACIÓN Y RECUPERACIÓN DE CONTRASEÑA
// =========================================================================
Route::prefix('auth')->name('api.auth.')->group(function () {
    Route::post('/register', [AuthApiController::class, 'register'])->name('register');
    Route::post('/login-cliente', [AuthApiController::class, 'loginCliente'])->name('login.cliente');
    Route::post('/login-admin', [AuthApiController::class, 'loginStaff'])->name('login.staff');

    // Recuperación de clave para clientes
    Route::post('/recuperar-password/codigo', [AuthApiController::class, 'solicitarCodigoRecuperacion'])->name('password.codigo');
    Route::post('/recuperar-password/cambiar', [AuthApiController::class, 'cambiarPasswordRecuperacion'])->name('password.cambiar');

    // Rutas que requieren token Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthApiController::class, 'me'])->name('me');
        Route::post('/logout', [AuthApiController::class, 'logout'])->name('logout');
    });
});

// =========================================================================
// 4. RUTAS DE CLIENTE (Requiere Auth Sanctum + Rol 'cliente')
// =========================================================================
Route::middleware(['auth:sanctum', 'role:cliente'])->prefix('cliente')->name('api.cliente.')->group(function () {
    Route::get('/dashboard', [ClienteApiController::class, 'dashboard'])->name('dashboard');
    Route::get('/perfil', [ClienteApiController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [ClienteApiController::class, 'updatePerfil'])->name('perfil.update');

    // Historial y detalle de pedidos
    Route::get('/pedidos', [ClienteApiController::class, 'pedidos'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [ClienteApiController::class, 'pedidoDetalle'])->name('pedidos.show');

    // Procesar compra/checkout online
    Route::post('/checkout', [ClienteApiController::class, 'checkout'])->name('checkout');
});

// =========================================================================
// 5. RUTAS DE PERSONAL (Requiere Auth Sanctum + Roles 'personal' o 'admin')
// =========================================================================
Route::middleware(['auth:sanctum', 'role:personal,admin'])->prefix('personal')->name('api.personal.')->group(function () {
    Route::get('/dashboard', [PersonalApiController::class, 'dashboard'])->name('dashboard');

    // Gestión de clientes por mostrador
    Route::get('/clientes', [PersonalApiController::class, 'indexClientes'])->name('clientes.index');
    Route::get('/clientes/{id}', [PersonalApiController::class, 'showCliente'])->name('clientes.show');
    Route::post('/clientes', [PersonalApiController::class, 'storeCliente'])->name('clientes.store');
    Route::put('/clientes/{id}', [PersonalApiController::class, 'updateCliente'])->name('clientes.update');
    Route::delete('/clientes/{id}', [PersonalApiController::class, 'destroyCliente'])->name('clientes.destroy');

    // Ventas presenciales en el local
    Route::get('/ventas/datos-creacion', [PersonalApiController::class, 'datosCreacionVenta'])->name('ventas.datos');
    Route::get('/ventas', [PersonalApiController::class, 'indexVentas'])->name('ventas.index');
    Route::get('/ventas/{id}', [PersonalApiController::class, 'showVenta'])->name('ventas.show');
    Route::post('/ventas', [PersonalApiController::class, 'storeVenta'])->name('ventas.store');
});

// =========================================================================
// 6. RUTAS DE ADMINISTRADOR (Requiere Auth Sanctum + Rol 'admin')
// =========================================================================
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->name('api.admin.')->group(function () {
    Route::get('/dashboard', [AdminApiController::class, 'dashboard'])->name('dashboard');
    Route::get('/horarios', [PublicApiController::class, 'horarios'])->name('horarios');

    // CRUD de Productos (con soporte multipart/form-data)
    Route::get('/productos', [AdminApiController::class, 'indexProductos'])->name('productos.index');
    Route::get('/productos/{id}', [AdminApiController::class, 'showProducto'])->name('productos.show');
    Route::post('/productos', [AdminApiController::class, 'storeProducto'])->name('productos.store');
    Route::post('/productos/{id}', [AdminApiController::class, 'updateProducto'])->name('productos.update.post');
    Route::put('/productos/{id}', [AdminApiController::class, 'updateProducto'])->name('productos.update');
    Route::delete('/productos/{id}', [AdminApiController::class, 'destroyProducto'])->name('productos.destroy');

    // CRUD de Categorías
    Route::get('/categorias', [AdminApiController::class, 'indexCategorias'])->name('categorias.index');
    Route::get('/categorias/{id}', [AdminApiController::class, 'showCategoria'])->name('categorias.show');
    Route::post('/categorias', [AdminApiController::class, 'storeCategoria'])->name('categorias.store');
    Route::put('/categorias/{id}', [AdminApiController::class, 'updateCategoria'])->name('categorias.update');
    Route::delete('/categorias/{id}', [AdminApiController::class, 'destroyCategoria'])->name('categorias.destroy');

    // Visualización de Personal y Clientes (solo lectura por requerimiento)
    Route::get('/personal', [AdminApiController::class, 'indexPersonal'])->name('personal.index');
    Route::get('/personal/{id}', [AdminApiController::class, 'showPersonal'])->name('personal.show');
    Route::get('/clientes', [AdminApiController::class, 'indexClientes'])->name('clientes.index');
    Route::get('/clientes/{id}', [AdminApiController::class, 'showCliente'])->name('clientes.show');

    // CRUD de Promociones
    Route::get('/promociones', [AdminApiController::class, 'indexPromociones'])->name('promociones.index');
    Route::get('/promociones/{id}', [AdminApiController::class, 'showPromocion'])->name('promociones.show');
    Route::post('/promociones', [AdminApiController::class, 'storePromocion'])->name('promociones.store');
    Route::post('/promociones/{id}', [AdminApiController::class, 'updatePromocion'])->name('promociones.update.post');
    Route::put('/promociones/{id}', [AdminApiController::class, 'updatePromocion'])->name('promociones.update');
    Route::delete('/promociones/{id}', [AdminApiController::class, 'destroyPromocion'])->name('promociones.destroy');

    // CRUD de Portafolio
    Route::get('/portafolio', [AdminApiController::class, 'indexPortafolio'])->name('portafolio.index');
    Route::get('/portafolio/{id}', [AdminApiController::class, 'showPortafolio'])->name('portafolio.show');
    Route::post('/portafolio', [AdminApiController::class, 'storePortafolio'])->name('portafolio.store');
    Route::post('/portafolio/{id}', [AdminApiController::class, 'updatePortafolio'])->name('portafolio.update.post');
    Route::put('/portafolio/{id}', [AdminApiController::class, 'updatePortafolio'])->name('portafolio.update');
    Route::delete('/portafolio/{id}', [AdminApiController::class, 'destroyPortafolio'])->name('portafolio.destroy');

    // Gestión de Pedidos Online y Estados
    Route::get('/pedidos', [AdminApiController::class, 'indexPedidos'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [AdminApiController::class, 'showPedido'])->name('pedidos.show');
    Route::patch('/pedidos/{id}/estado', [AdminApiController::class, 'updateEstadoPedido'])->name('pedidos.estado');

    // Control de Stock
    Route::get('/stock', [AdminApiController::class, 'indexStock'])->name('stock.index');
    Route::put('/stock/{id}', [AdminApiController::class, 'updateStock'])->name('stock.update');

    // Ventas (administración)
    Route::get('/ventas', [AdminApiController::class, 'indexVentas'])->name('ventas.index');
    Route::get('/ventas/{id}', [AdminApiController::class, 'showVenta'])->name('ventas.show');
    Route::post('/ventas', [AdminApiController::class, 'storeVenta'])->name('ventas.store');
});
