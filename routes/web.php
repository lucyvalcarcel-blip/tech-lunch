<?php

use Illuminate\Support\Facades\Route;

// Sitio público
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformacionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;

// Panel del administrador
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ProductoController;

// ===== Sitio público =====
Route::get('/', [HomeController::class, 'index'])->name('inicio');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Páginas informativas
Route::get('/quienes-somos', [InformacionController::class, 'acercaDe'])->name('acerca-de');
Route::get('/preguntas-frecuentes', [InformacionController::class, 'preguntas'])->name('preguntas');
Route::view('/contacto', 'contacto')->name('contacto');

// ===== Carrito (en la sesión, no pide iniciar sesión) =====
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/{producto}', [CarritoController::class, 'store'])->name('carrito.store');
Route::patch('/carrito/{producto}', [CarritoController::class, 'update'])->name('carrito.update');
Route::delete('/carrito/{producto}', [CarritoController::class, 'destroy'])->name('carrito.destroy');

// ===== Cliente con sesión iniciada =====
Route::middleware('auth')->group(function () {
    Route::view('/perfil', 'perfil')->name('perfil');

    Route::resource('pedidos', PedidoController::class)
        ->only(['index', 'create', 'store', 'show']);
});

// ===== Panel del administrador =====
// Solo usuarios con sesión y rol administrador (auth + spatie role)
Route::middleware(['auth', 'role:administrador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // CRUD de Categorías (Lucy)
        Route::resource('categorias', CategoriaController::class)
            ->except(['show']);

        // CRUD de Productos (Fabrizio)
        Route::resource('productos', ProductoController::class)
            ->except(['show', 'destroy']);
    });