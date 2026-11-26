<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cupon;

class CuponController extends Controller
{
    // Listado de todos los cupones (vigentes, programados, vencidos, usados e inactivos)
    public function index()
    {
        $cupones = Cupon::orderByDesc('fecha_inicio')->get();   // los más nuevos primero

        return view('admin.cupones.index', compact('cupones'));
    }
}