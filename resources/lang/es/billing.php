<?php

// Avisos que se envían cuando falla o se recupera el pago de una suscripción (App\Notifications\SubscriptionPayment*).
// Mantén resources/lang/en/billing.php al día: un test compara las claves de ambos.
return [
    'payment_failed' => [
        // Primer aviso: no se pudo cobrar una renovación y el acceso queda en pausa; la pasarela reintentará.
        'past_due' => [
            'subject' => 'No pudimos cobrar tu suscripción a :plan',
            'message' => 'No pudimos cobrar la renovación de tu suscripción a :plan. Pausamos el acceso hasta que el pago se complete y lo volveremos a intentar en los próximos días.',
        ],
        // Aviso final: la pasarela dejó de reintentar; sigue en pausa.
        'unpaid' => [
            'subject' => 'Suspendimos tu suscripción a :plan',
            'message' => 'Después de varios intentos no logramos cobrar tu suscripción a :plan, así que la suspendimos.',
        ],
        // El primer pago nunca se completó; la suscripción se canceló.
        'incomplete_expired' => [
            'subject' => 'No se completó tu suscripción a :plan',
            'message' => 'No logramos cobrar el pago inicial de tu suscripción a :plan, así que la cancelamos.',
        ],
    ],
    'update_payment' => 'Para reactivarla, actualiza tu método de pago.',
    'resubscribe' => 'Si todavía la quieres, vuelve a suscribirte con otro método de pago.',
    'action_update_payment' => 'Actualizar método de pago',
    'action_resubscribe' => 'Suscribirme de nuevo',
    'recovered' => [
        'subject' => 'Tu suscripción a :plan está activa de nuevo',
        'message' => 'Cobramos tu pago y tu suscripción a :plan está activa de nuevo. Gracias.',
        'action' => 'Ir a mi cuenta',
    ],
];
