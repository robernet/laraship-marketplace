<?php

return [
    'coupon' => [
        'not_eligible_use_coupon' => 'No eres elegible para usar este código de cupón',
        'code_reached_maximum' => 'El código de cupón ha alcanzado su uso máximo',
        'must_least_total' => 'Debes tener al menos un total de :amount',
        'max_discount_amount' => 'Esto tiene un descuento máximo de :amount',
        'coupon_not_available' => 'Este cupón no está disponible',
        'must_use_discount_amount' => 'Debes usar un monto de descuento.',
    ],
    'cart' => [
        'not_find_relation' => 'No se pudo encontrar el modelo de relación',
        'not_find model' => 'No se pudo encontrar el modelo del artículo para :arg',
        'item_limited_per_order' => 'Este artículo está limitado a :quantity artículos por pedido.',
        'quantity_valid_num' => 'La cantidad debe ser un número válido',
        'price_must_valid_num' => 'El precio debe ser un número válido',
        'tax_must_number' => 'El impuesto debe ser un número válido',
        'taxable_option_must_boolean' => 'La opción tributable debe ser un booleano',

    ],
    'misc' => [
        'invalid_gateway' => 'Configuración de Gateway inválida',
        'product_code_exist' => 'El producto con código :arg existe en el Gateway.',
        'create_gateway' => 'Error al crear el producto del Gateway :message',
        'update_gateway' => 'Error al actualizar el producto del Gateway :message',
        'delete_product' => 'Error al eliminar el producto del Gateway :message',
        'create_gateway_sku' => 'Error al crear el SKU del Gateway :message',
        'update_gateway_sku' => 'Error al actualizar el SKU del Gateway :message',
        'delete_sku' => 'Error al eliminar el SKU del Gateway :message',
        'create_order_failed' => 'Error al crear el pedido del Gateway :message',
        'invalid_order_code' => 'Código de pedido inválido :data',
        'update_gateway_order_failed' => 'Error al actualizar el pedido del Gateway :message',
        'order_already_paid' => 'El pedido ya está pagado',
        'gateway_create_payment' => 'Error al crear el token de pago del Gateway :data',
        'least_should_upload' => 'Debe subir al menos un archivo',
    ],
    'sku' => [
        'item_has_only_quantity' => 'Este artículo solo tiene :quantity cantidad disponible en stock',
        'item_current_out' => 'Este artículo está actualmente agotado',
        'invalid_custom' => 'Valor de opción personalizada inválido',
        'nothing_to_update' => 'No hay nada que actualizar.'
    ],
    'checkout' => [
        'invalid_coupon' => 'Código de cupón inválido :code',
        'redeem_points_exceed_balance' => 'No puedes canjear puntos más de los que tienes en tu saldo',
    ],
    'shipping' => [
        'invalid_store' => 'Tienda inválida',
        'no_report_file' => 'El archivo de reporte ha sido eliminado o no está disponible'
    ],
    'store' => [
        'invalid_store' => 'El usuario no tiene una tienda adjunta',
        'invalid_subscription_product' => 'Producto de suscripción inválido'
    ],
];
