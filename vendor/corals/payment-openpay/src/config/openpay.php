<?php

return [
    'name' => 'Openpay',
    'key' => 'payment_openpay',
    'support_subscription' => false,
    'support_ecommerce' => true,
    'support_marketplace' => true,
    'support_online_refund' => true,
    'support_online_payout' => false,
    'manage_remote_plan' => false,
    'create_remote_customer' => false,
    'capture_payment_method' => true,
    'require_default_payment_set' => true,
    'supports_swap' => false,
    'can_update_payment' => true,
    'supports_swap_in_grace_period' => false,
    'require_invoice_creation' => false,
    'require_plan_activation' => false,
    'require_payment_token' => false,

    'settings' => [
        'live_merchant_id' => [
            'label' => 'Openpay::labels.settings.live_merchant_id',
            'type' => 'text',
            'required' => false,
        ],
        'live_private_key' => [
            'label' => 'Openpay::labels.settings.live_private_key',
            'type' => 'text',
            'required' => false,
        ],
        'live_public_key' => [
            'label' => 'Openpay::labels.settings.live_public_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_mode' => [
            'label' => 'Openpay::labels.settings.sandbox_mode',
            'type' => 'boolean'
        ],
        'sandbox_merchant_id' => [
            'label' => 'Openpay::labels.settings.sandbox_merchant_id',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_private_key' => [
            'label' => 'Openpay::labels.settings.sandbox_private_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_public_key' => [
            'label' => 'Openpay::labels.settings.sandbox_public_key',
            'type' => 'text',
            'required' => false,
        ],
        'country_code' => [
            'label' => 'Openpay::labels.settings.country_code',
            'type' => 'select',
            'options' => [
                'mx' => 'MX (México)',
                'pe' => 'PE (Peru)',
                'co' => 'CO (Colombia)',
            ],
            'required' => true,
        ]
    ],
    'events' => [
    ],
    'webhook_handler' => \Corals\Modules\Payment\Openpay\Gateway::class,
];
