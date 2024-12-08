<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\FileUploadController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);
Route::post('/users', [AuthController::class, 'register']);
Route::get('productos', [ProductoController::class, 'index']);
Route::post('productos', [ProductoController::class, 'store']);
Route::put('productos/{id}', [ProductoController::class, 'update']);
Route::delete('productos/{id}', [ProductoController::class, 'destroy']);
Route::post('login', [AuthController::class, 'login']);

Route::post('/upload', [FileUploadController::class, 'upload']);
Route::apiResource('productos', ProductoController::class);
// routes/api.php

Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin-dashboard', function () {
    return response()->json(['message' => 'Bienvenido al panel de administrador']);
});

Route::middleware(['auth:sanctum', 'role:cliente'])->get('/client-dashboard', function () {
    return response()->json(['message' => 'Bienvenido al panel de cliente']);

});
Route::post('register', [AuthController::class, 'register']);
// Ruta para obtener todos los pedidos
Route::get('orders', [OrderController::class, 'index']);

// Ruta para crear un nuevo pedido
Route::post('orders', [OrderController::class, 'store']);

// Ruta para obtener un pedido específico
Route::get('orders/{id}', [OrderController::class, 'show']);
Route::get('categorias', [CategoriaController::class, 'index']);
Route::post('categorias', [CategoriaController::class, 'store']);
Route::get('categorias/{id}', [CategoriaController::class, 'show']);
Route::put('categorias/{id}', [CategoriaController::class, 'update']);
Route::delete('categorias/{id}', [CategoriaController::class, 'destroy']);
Route::apiResource('categorias', CategoriaController::class);
Route::resource('orders', App\Http\Controllers\Api\OrderController::class);
Route::post('/compras', [CompraController::class, 'createCompra']);
Route::get('/compras/{userId}', [CompraController::class, 'obtenerCompras']);
Route::middleware('auth:sanctum')->post('/compras', [CompraController::class, 'createCompra']);
Route::post('simular-pago/{compraId}', [CompraController::class, 'simularPago']);
Route::post('/compra', [CompraController::class, 'realizarCompra'])->middleware('auth');
Route::post('/compras', [CompraController::class, 'createCompra']);
Route::post('/compras/{compraId}/completar-pago', [CompraController::class, 'completarPago']);
// routes/api.php
Route::get('/compras', [CompraController::class, 'obtenerCompras']);
Route::get('envios', [EnvioController::class, 'index']);  // Obtener todos los envíos
Route::post('envios', [EnvioController::class, 'store']);  // Crear un nuevo envío
Route::get('envios/{id}', [EnvioController::class, 'show']);  // Obtener un envío específico
Route::put('envios/{id}', [EnvioController::class, 'update']);  // Actualizar un envío
Route::delete('envios/{id}', [EnvioController::class, 'destroy']);  // Eliminar un envío
Route::post('envios', [EnvioController::class, 'store']);
