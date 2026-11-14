<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class InformacionController extends Controller
{
    public function acercaDe(): View
    {
        $valores = [
            ['icono' => 'bi-lightning-charge', 'titulo' => 'Rapidez', 'texto' => 'Pides desde tu celular y recoges sin hacer cola.'],
            ['icono' => 'bi-phone', 'titulo' => 'Pago fácil', 'texto' => 'Pagas con Yape o Plin y el cafetín valida tu pago.'],
            ['icono' => 'bi-geo-alt', 'titulo' => 'Recoge en el cafetín', 'texto' => 'Retira tu pedido listo con tu código de pedido.'],
        ];

        $equipo = [
            'Morales Lecca, Fabrizio',
            'Silva Silva, Ingrid',
            'Valcarcel Cabia, Lucy',
            'Zumaran Palomino, Gabriel',
        ];

        return view('acerca-de', compact('valores', 'equipo'));
    }

    public function preguntas(): View
    {
        $preguntas = [
            [
                'pregunta' => '¿Cómo hago un pedido?',
                'respuesta' => 'Entra al Menú, agrega tus productos al carrito y confirma tu pedido. Paga con Yape o Plin y recógelo en el cafetín.',
            ],
            [
                'pregunta' => '¿Cómo pago mi pedido?',
                'respuesta' => 'Paga con Yape o Plin y escribe el número de operación al confirmar tu pedido. El personal del cafetín revisa el pago y tu pedido pasa a Confirmado.',
            ],
            [
                'pregunta' => '¿Hay delivery?',
                'respuesta' => 'Todavía no. Por ahora el pedido se recoge en el cafetín con tu código. El delivery estará disponible próximamente.',
            ],
            [
                'pregunta' => '¿Cómo sé que mi pedido está listo?',
                'respuesta' => 'Revisa Mis pedidos. Cuando el estado cambie a Listo, ya puedes recogerlo en el cafetín con tu código de pedido.',
            ],
            [
                'pregunta' => '¿Para qué sirve el código de pedido?',
                'respuesta' => 'Cada pedido tiene un código, por ejemplo TL-0001. Muéstralo en el cafetín al recoger tu pedido.',
            ],
            [
                'pregunta' => '¿Qué pasa si mi pago es rechazado?',
                'respuesta' => 'Si el número de operación no es correcto, el pedido pasa a Rechazado. Revisa tu pago y vuelve a hacer el pedido, o acércate al cafetín.',
            ],
        ];

        return view('preguntas', compact('preguntas'));
    }
}