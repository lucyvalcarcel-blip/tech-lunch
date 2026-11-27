<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class InformacionController extends Controller
{
    public function acercaDe(): View
    {
        $valores = [
            ['icono' => 'bi-lightning-charge', 'titulo' => 'Rapidez', 'texto' => 'Pides desde tu celular y recoges sin hacer cola.'],
            ['icono' => 'bi-phone', 'titulo' => 'Pago fácil', 'texto' => 'Pagas con Yape, Plin o tarjeta y el cafetín valida tu pago.'],
            ['icono' => 'bi-geo-alt', 'titulo' => 'Recojo o delivery', 'texto' => 'Recoge tu pedido en el cafetín o recíbelo en tu aula.'],
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
                'respuesta' => 'Con Yape o Plin escribe el número de operación; con tarjeta de débito o crédito, sus datos. El personal del cafetín revisa el pago y tu pedido pasa a Confirmado.',
            ],
            [
                'pregunta' => '¿Hay delivery?',
                'respuesta' => 'Sí, dentro del campus de 12:00 a 3:00 p. m., por S/ 2.00. Elige tu zona, tu aula y la hora; te esperamos hasta 10 minutos después.',
            ],
            [
                'pregunta' => '¿Cómo sé que mi pedido está listo?',
                'respuesta' => 'Revisa Mis pedidos. Tu pedido pasa por 3 estados: Pago en revisión, Confirmado y Entregado. Si es delivery, te esperamos en tu aula hasta 10 minutos después de la hora elegida.',
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