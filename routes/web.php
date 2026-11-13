<?php
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformacionController;
use App\Http\Controllers\Admin\ProductoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;

// ===== Sitio público (área 2) =====
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/{producto}', [CarritoController::class, 'store'])->name('carrito.store');
Route::patch('/carrito/{producto}', [CarritoController::class, 'update'])->name('carrito.update');
Route::delete('/carrito/{producto}', [CarritoController::class, 'destroy'])->name('carrito.destroy');
Route::get('/', [HomeController::class, 'index'])->name('inicio');
Route::middleware('auth')->group(function () {
Route::resource('pedidos', PedidoController::class)->only(['index', 'create', 'store', 'show']);
});
Route::get('/quienes-somos', [InformacionController::class, 'acercaDe'])->name('acerca-de');
Route::get('/preguntas-frecuentes', [InformacionController::class, 'preguntas'])->name('preguntas');

Route::view('/contacto', 'contacto')->name('contacto');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::view('/perfil', 'perfil')->middleware('auth')->name('perfil');

// ===== Panel del administrador =====
// Solo usuarios con sesión y rol administrador (auth + spatie role)
Route::middleware(['auth', 'role:administrador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Área 1: CRUD de Categorías (sin show ni destroy)
        Route::resource('categorias', CategoriaController::class)
            ->except(['show', 'destroy']);

        // Área 3: CRUD de Productos (sin show ni destroy)
        Route::resource('productos', ProductoController::class)
            ->except(['show', 'destroy']);
    });