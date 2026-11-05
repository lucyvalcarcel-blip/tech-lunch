<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('inicio');

Route::get('/quienes-somos', [InformacionController::class, 'acercaDe'])->name('acerca-de');

Route::view('/contacto', 'contacto')->name('contacto');