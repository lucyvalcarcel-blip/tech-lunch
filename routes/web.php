<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('inicio');

Route::view('/contacto', 'contacto')->name('contacto');