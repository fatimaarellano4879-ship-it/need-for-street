<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Middleware\ValidarPrecioProducto;

// Página principal
Route::view('/', 'welcome')->name('inicio');

// Catálogo de productos
Route::get('/productos', [ProductoController::class, 'index'])
    ->name('productos.index');

// Formulario de registro
Route::get('/productos/crear', [ProductoController::class, 'create'])
    ->name('productos.create');

// Guardar producto: validar el precio antes de llegar al controlador
Route::post('/productos', [ProductoController::class, 'store'])
    ->middleware(ValidarPrecioProducto::class)
    ->name('productos.store');

// Formulario de edición
Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])
    ->name('productos.edit');

// Actualizar producto: aplicar la misma regla
Route::put('/productos/{producto}', [ProductoController::class, 'update'])
    ->middleware(ValidarPrecioProducto::class)
    ->name('productos.update');

// Eliminar producto
// Eliminar producto
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])
    ->name('productos.destroy');