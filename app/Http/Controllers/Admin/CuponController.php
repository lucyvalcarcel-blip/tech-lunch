<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CuponController extends Controller
{
    // Listado de todos los cupones (vigentes, programados, vencidos, usados e inactivos)
    public function index()
    {
        $cupones = Cupon::orderByDesc('fecha_inicio')->get();   // los más nuevos primero

        return view('admin.cupones.index', compact('cupones'));
    }

    // Muestra el formulario vacío
    public function create()
    {
        $cupon = new Cupon();    // cupón vacío (estado = Disponible por defecto)

        return view('admin.cupones.create', compact('cupon'));
    }

    // Guarda el cupón nuevo
    public function store(Request $request)
    {
        $datos = $this->validar($request);

        Cupon::create($datos);

        return redirect()->route('admin.cupones.index')
            ->with('exito', 'Cupón creado correctamente.');
    }

    // Reglas de validación: las usan store() y update() (Paso 4)
    // $cupon llega solo al editar, para que "unique" no choque con el mismo cupón
    private function validar(Request $request, ?Cupon $cupon = null): array
    {
        // El código siempre en MAYÚSCULAS y sin espacios: "tecsup20 " -> "TECSUP20"
        $request->merge(['codigo' => strtoupper(trim((string) $request->codigo))]);

        $datos = $request->validate([
            'codigo' => [
                'required', 'string', 'max:20',
                'regex:/^[A-Z0-9]+$/',                                   // solo letras y números
                Rule::unique('cupones', 'codigo')->ignore($cupon),       // no se repite
            ],
            'descripcion' => ['nullable', 'string', 'max:100'],
            'porcentaje' => ['required', 'integer', 'between:1,100'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
        ], [
            'codigo.regex' => 'El código solo puede tener letras y números, sin espacios ni tildes.',
        ], [
            'codigo' => 'código',
            'descripcion' => 'descripción',
            'fecha_inicio' => 'fecha de inicio',
            'fecha_fin' => 'fecha de fin',
        ]);

        // El interruptor decide si el cupón queda Disponible o Inactivo
        // ("Usado" NUNCA se elige a mano: lo pone el sistema al pagar, en el Paso 7)
        $datos['estado'] = $request->boolean('activo') ? Cupon::DISPONIBLE : Cupon::INACTIVO;

        return $datos;
    }
}