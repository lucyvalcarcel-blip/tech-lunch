<?php
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformacionController;
use App\Http\Controllers\Admin\ProductoController;
use Illuminate\Support\Facades\Route;


// ===== Sitio público (área 2) =====


Route::get('/', [HomeController::class, 'index'])->name('inicio');

Route::get('/quienes-somos', [InformacionController::class, 'acercaDe'])->name('acerca-de');
Route::get('/preguntas-frecuentes', [InformacionController::class, 'preguntas'])->name('preguntas');

Route::view('/contacto', 'contacto')->name('contacto');

Route::view('/perfil', 'perfil')->middleware('auth')->name('perfil');
// ===== Panel del administrador =====

Route::prefix('admin')->name('admin.')->group(function () {

    // Área 1: CRUD de Categorías (sin show ni destroy)
    Route::resource('categorias', CategoriaController::class)
        ->except(['show', 'destroy']);

    Route::resource('productos', ProductoController::class)
        ->except(['show', 'destroy']);
});