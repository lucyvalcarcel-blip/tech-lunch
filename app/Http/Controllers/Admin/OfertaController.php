<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Oferta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OfertaController extends Controller
{
    // Listado de todas las ofertas (vigentes, programadas, vencidas e inactivas)
    public function index()
    {
        $ofertas = Oferta::with('producto')        // evita el problema N+1
            ->orderByDesc('fecha_inicio')          // las más nuevas primero
            ->get();

        return view('admin.ofertas.index', compact('ofertas'));
    }

    // Muestra el formulario vacío
    public function create()
    {
        $oferta = new Oferta();                    // oferta vacía (estado = true por defecto)
        $productos = Producto::orderBy('nombre')->get();

        return view('admin.ofertas.create', compact('oferta', 'productos'));
    }

    // Guarda la oferta nueva
    public function store(Request $request)
    {
        $datos = $this->validar($request);

        Oferta::create($datos);

        return redirect()->route('admin.ofertas.index')
            ->with('exito', 'Oferta creada correctamente.');
        
        
    }
    
    // Muestra el formulario con los datos de la oferta
    public function edit(Oferta $oferta)
    {
        $productos = Producto::orderBy('nombre')->get();

        return view('admin.ofertas.edit', compact('oferta', 'productos'));
    }

    // Guarda los cambios
    public function update(Request $request, Oferta $oferta)
    {
        $datos = $this->validar($request);     // las MISMAS reglas que al crear

        $oferta->update($datos);

        return redirect()->route('admin.ofertas.index')
            ->with('exito', 'Oferta actualizada correctamente.');
    }


    // Reglas de validación: las usan store() y update() (Paso 5)
    private function validar(Request $request): array
    {
        $datos = $request->validate([
            'producto_id' => ['required', Rule::exists('productos', 'id')],
            'tipo' => ['required', Rule::in(Oferta::TIPOS)],
            'precio_oferta' => [
                'required', 'numeric', 'min:0.10',
                // El precio de oferta tiene que ser MENOR al precio normal del producto
                function ($atributo, $valor, $fallar) use ($request) {
                    $producto = Producto::find($request->producto_id);
                    if ($producto && $valor >= $producto->precio) {
                        $fallar('El precio de oferta debe ser menor al precio normal (S/ ' . $producto->precio . ').');
                    }
                },
            ],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
        ], [], [
            'producto_id' => 'producto',
            'precio_oferta' => 'precio de oferta',
            'fecha_inicio' => 'fecha de inicio',
            'fecha_fin' => 'fecha de fin',
        ]);

        // El checkbox no se envía si está desmarcado: boolean() lo convierte en true/false
        $datos['estado'] = $request->boolean('estado');

        return $datos;
    }
}