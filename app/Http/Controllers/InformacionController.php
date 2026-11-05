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
            ['icono' => 'bi-geo-alt', 'titulo' => 'Llega a tu aula', 'texto' => 'Recibe tu pedido en el punto de entrega que elijas.'],
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
                'respuesta' => 'Entra al Menú, agrega tus productos al carrito y confirma tu pedido. Elige si lo recoges en el cafetín o si quieres delivery, y paga con Yape o Plin.',
            ],
            [
                'pregunta' => '¿Cómo pago mi pedido?',
                'respuesta' => 'Paga con Yape o Plin y escribe el número de operación al confirmar tu pedido. El personal del cafetín revisa el pago y tu pedido pasa a Confirmado.',
            ],
            [
                'pregunta' => '¿Hay delivery? ¿Cuánto cuesta?',
                'respuesta' => 'Sí, de 12:00 a 3:00 p. m., con un costo adicional de S/ 2.00. Eliges el punto de entrega del campus, la hora y tu número de celular.',
            ],
            [
                'pregunta' => '¿Cómo sé que mi pedido está listo?',
                'respuesta' => 'Revisa Mis pedidos. Cuando el estado cambie a Listo, verás "Ya puedes recogerlo" si es para recoger, o que tu pedido sale hacia tu punto de entrega si es delivery.',
            ],
            [
                'pregunta' => '¿Para qué sirve el código de pedido?',
                'respuesta' => 'Cada pedido tiene un código, por ejemplo TL-0001. Muéstralo al recoger tu pedido o al recibirlo en tu punto de entrega.',
            ],
            [
                'pregunta' => '¿Qué pasa si mi pago es rechazado?',
                'respuesta' => 'Si el número de operación no es correcto, el pedido pasa a Rechazado. Revisa tu pago y vuelve a hacer el pedido, o acércate al cafetín.',
            ],
        ];

        return view('preguntas', compact('preguntas'));
    }
}