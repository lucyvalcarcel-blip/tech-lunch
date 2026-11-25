<?php
// lucy - paso 4 - ya habia creado el controlador para esta tabla, ahora estoy agregando los campos de entrega y pago a la tabla de pedidos.
namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use App\Models\Zona;
use Illuminate\Validation\Rule;
class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $pedidos = Pedido::where('user_id', auth()->id())
        ->withCount('detalles')
        ->latest()
        ->get();

    return view('pedidos.index', compact('pedidos'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $carrito = session('carrito', []);

    if (empty($carrito)) {
        return redirect()->route('menu')->with('error', 'Tu carrito está vacío.');
    }

    $productos = Producto::whereIn('id', array_keys($carrito))->get();
    $total = $productos->sum(fn ($producto) => $producto->precio * $carrito[$producto->id]);

    $zonas = Zona::activas()->orderBy('nombre')->get();

    return view('pedidos.create', compact('productos', 'carrito', 'total', 'zonas'));
}

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
{
    $datos = $request->validate([
        // NUEVO: entrega
                
            'tipo_entrega'     => 'required|in:recojo,delivery',
            'zona_id'          => ['required_if:tipo_entrega,delivery', 'nullable',
                                   Rule::exists('zonas', 'id')->where('estado', true)],
            'aula'             => 'required_if:tipo_entrega,delivery|nullable|string|max:50',
            'referencia'       => 'nullable|string|max:100',
            'hora'             => ['required_if:tipo_entrega,delivery', 'nullable',
                                   Rule::in(array_keys(Pedido::HORAS))],
            // Pago
            'celular'          => 'required|digits:9',
            'metodo_pago'      => 'required|in:yape,plin,debito,credito',
            // Yape o Plin
            'numero_operacion' => 'required_if:metodo_pago,yape,plin|nullable|string|max:20',
            // Tarjeta
            'titular'          => 'required_if:metodo_pago,debito,credito|nullable|string|max:60',
            'numero_tarjeta'   => ['required_if:metodo_pago,debito,credito', 'nullable',
                function ($atributo, $valor, $fallar) {
                    $digitos = preg_replace('/\D/', '', $valor);
                    if (! str_starts_with($digitos, '4') && ! str_starts_with($digitos, '5')) {
                        $fallar('Solo aceptamos tarjetas Visa o Mastercard.');
                    } elseif (! $this->luhnValido($valor)) {
                        $fallar('El número de tarjeta no es válido.');
                    }
                }],
            'vencimiento'      => ['required_if:metodo_pago,debito,credito', 'nullable',
                'regex:/^(0[1-9]|1[0-2])\/\d{2}$/',
                function ($atributo, $valor, $fallar) {
                    if (preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $valor)
                        && \Carbon\Carbon::createFromFormat('m/y', $valor)->endOfMonth()->isPast()) {
                        $fallar('La tarjeta está vencida.');
                    }
                }],
            'cvv'              => 'required_if:metodo_pago,debito,credito|nullable|digits:3',
            'cuotas'           => 'required_if:metodo_pago,credito|nullable|integer|in:1,3,6',
        ], [], [
            'zona_id'          => 'zona',
            'hora'             => 'hora de entrega',
            'metodo_pago'      => 'método de pago',
            'numero_operacion' => 'número de operación',
            'numero_tarjeta'   => 'número de tarjeta',
            'cvv'              => 'CVV',
        ]);


    $carrito = session('carrito', []);
    if (empty($carrito)) {
        return redirect()->route('menu');
    }

    $productos = Producto::whereIn('id', array_keys($carrito))->get();

    foreach ($productos as $producto) {
        if ($carrito[$producto->id] > $producto->stock) {
            return back()->withInput()->with('error', 'Ya no hay stock suficiente de ' . $producto->nombre . '.');
        }
    }

    // NUEVO: hora, límite y costo según el tipo de entrega
    if ($datos['tipo_entrega'] === 'delivery') {
        $horaEntrega   = today()->setTimeFromTimeString($datos['hora']);
        $limite        = $horaEntrega->copy()->addMinutes(Pedido::MINUTOS_LIMITE);
        $costoDelivery = Pedido::COSTO_DELIVERY;
    } else {
        $horaEntrega   = null;
        $limite        = today()->setTimeFromTimeString(Pedido::HORA_CIERRE);
        $costoDelivery = 0;
        $datos['zona_id'] = null;
        $datos['aula'] = null;
        $datos['referencia'] = null;
    }
    unset($datos['hora']); // "hora" no es una columna: se guarda como hora_entrega

//    preparar los datos de pago 
    // NUEVO: datos del pago
    if (in_array($datos['metodo_pago'], ['debito', 'credito'])) {
        $digitos = preg_replace('/\D/', '', $datos['numero_tarjeta']);

        // Simulación: esta tarjeta de prueba siempre es rechazada por el "banco"
        if ($digitos === '4000000000000002') {
            return back()->withInput($request->except('numero_tarjeta', 'cvv'))
                ->with('error', 'El banco rechazó la tarjeta (simulación). Prueba con otra.');
        }

        $datos['tarjeta_marca']    = str_starts_with($digitos, '4') ? 'VISA' : 'MASTERCARD';
        $datos['tarjeta_ultimos4'] = substr($digitos, -4);
        $datos['numero_operacion'] = null;
        if ($datos['metodo_pago'] === 'debito') {
            $datos['cuotas'] = null;
        }
    } else {
        $datos['cuotas'] = null;
    }

    // Por seguridad, el número completo, el CVV, el titular y el vencimiento NO se guardan
    unset($datos['numero_tarjeta'], $datos['cvv'], $datos['titular'], $datos['vencimiento']);



    $total = $productos->sum(fn ($p) => $p->precio * $carrito[$p->id]) + $costoDelivery; // NUEVO: + delivery

    $pedido = DB::transaction(function () use ($datos, $productos, $carrito, $total, $horaEntrega, $limite, $costoDelivery) {
        $pedido = Pedido::create($datos + [
            'user_id'        => auth()->id(),
            'hora_entrega'   => $horaEntrega,     // NUEVO
            'limite_entrega' => $limite,          // NUEVO
            'costo_delivery' => $costoDelivery,   // NUEVO
            'total'          => $total,
        ]);

        $pedido->update(['codigo' => 'TL-' . str_pad($pedido->id, 4, '0', STR_PAD_LEFT)]);

        foreach ($productos as $producto) {
            $cantidad = $carrito[$producto->id];
            $pedido->detalles()->create([
                'producto_id'     => $producto->id,
                'cantidad'        => $cantidad,
                'precio_unitario' => $producto->precio,
                'subtotal'        => $producto->precio * $cantidad,
            ]);
            $producto->decrement('stock', $cantidad);
        }

        return $pedido;
    });

    session()->forget('carrito');

    return redirect()->route('pedidos.show', $pedido)
        ->with('exito', 'Pedido ' . $pedido->codigo . ' registrado.');
}


    // Algoritmo de Luhn: valida que el número de tarjeta sea matemáticamente posible
    private function luhnValido(string $numero): bool
    {
        $digitos = preg_replace('/\D/', '', $numero);

        if (strlen($digitos) !== 16) {
            return false;
        }

        $suma = 0;
        foreach (str_split(strrev($digitos)) as $posicion => $digito) {
            $digito = (int) $digito;
            if ($posicion % 2 === 1) {
                $digito *= 2;
                if ($digito > 9) {
                    $digito -= 9;
                }
            }
            $suma += $digito;
        }

        return $suma % 10 === 0;
    }





    public function show(Pedido $pedido)
{
    abort_if($pedido->user_id !== auth()->id(), 403);

    $pedido->load('detalles.producto' , 'zona');

    return view('pedidos.show', compact('pedido'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
