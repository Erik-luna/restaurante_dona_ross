<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ClienteDashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PersonalManageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RecuperarPasswordController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

// --- Rutas Públicas ---
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/catalogo', [PublicController::class, 'catalogo'])->name('catalogo');
Route::get('/promociones', [PublicController::class, 'promociones'])->name('promociones');
Route::get('/portafolio', [PortfolioController::class, 'index'])->name('portafolio');
Route::post('/delivery/enviar', [DeliveryController::class, 'store'])->name('delivery.store');

// --- Autenticación ---
Route::get('/login-cliente', [AuthController::class, 'showClienteLogin'])->name('login.cliente');
Route::post('/login-cliente', [AuthController::class, 'loginCliente'])->name('login.cliente.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login-admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/login-admin', [AuthController::class, 'loginAdmin'])->name('login.admin.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Recuperación de contraseña (cliente) ---
Route::get('/recuperar-password', [RecuperarPasswordController::class, 'formulario'])->name('password.formulario');
Route::post('/recuperar-password', [RecuperarPasswordController::class, 'generarCodigo'])->name('password.codigo');
Route::post('/recuperar-password/cambiar', [RecuperarPasswordController::class, 'cambiar'])->name('password.cambiar');
Route::get('/recuperar-password/limpiar', [RecuperarPasswordController::class, 'limpiar'])->name('password.limpiar');

// --- Cliente (requiere login) ---
Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/dashboard', [ClienteDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'add'])->name('carrito.add');
    Route::put('/carrito/{producto}', [CarritoController::class, 'update'])->name('carrito.update');
    Route::delete('/carrito/{producto}', [CarritoController::class, 'remove'])->name('carrito.remove');
    Route::post('/checkout', [CarritoController::class, 'checkout'])->name('checkout');
    Route::get('/pedidos', [ClienteDashboardController::class, 'pedidos'])->name('pedidos');
    Route::get('/perfil', [ClienteDashboardController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [ClienteDashboardController::class, 'updatePerfil'])->name('perfil.update');
});

// --- Personal ---
Route::middleware(['auth', 'role:personal,admin'])->prefix('personal')->name('personal.')->group(function () {
    Route::get('/dashboard', [PersonalController::class, 'dashboard'])->name('dashboard');
    Route::resource('clientes', ClienteController::class)->except(['show']);
    Route::resource('ventas', VentaController::class)->only(['index', 'create', 'store', 'show']);
});

// --- Admin ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/horarios', [AdminController::class, 'horarios'])->name('horarios');
    Route::resource('productos', ProductoController::class)->except(['show']);

// El administrador solo puede VISUALIZAR la información de registro
// del usuario personal y del usuario cliente, sin opción de editarla.
    Route::get('/personal', [PersonalManageController::class, 'index'])->name('personal.index');
    Route::get('/personal/{personal}', [PersonalManageController::class, 'show'])->name('personal.show');
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
    Route::resource('promociones', PromocionController::class)->except(['show']);
    Route::resource('portafolio', PortfolioController::class)->except(['index', 'show']);
    Route::get('/portafolio', [PortfolioController::class, 'adminIndex'])->name('portafolio.index');
    Route::resource('pedidos', PedidoController::class)->only(['index', 'show']);
    Route::patch('/pedidos/{pedido}/estado', [PedidoController::class, 'updateEstado'])->name('pedidos.estado');
    Route::resource('ventas', VentaController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::put('/stock/{producto}', [StockController::class, 'update'])->name('stock.update');
});

// Redirect legacy admin route
Route::redirect('/admin', '/admin/dashboard');
