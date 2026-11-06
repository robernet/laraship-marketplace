<?php


return [
    'advertiser' => [
        'name' => 'Nombre',
        'contact' => 'Contacto',
        'email' => 'Correo Electrónico',
        'notes' => 'Notas',
        'status_option' => [
            'active' => 'Activo',
            'inactive' => 'Inactivo',
        ],
    ],
    'banner' => [
        'name' => 'Nombre',
        'campaign' => 'Campaña',
        'dimension' => 'Dimensión',
        'type' => 'Tipo',
        'type_options' => [
            'script' => 'Script',
            'media' => 'Media',
            'link' => 'Link',
        ],
        'weight' => 'Peso',
        'notes' => 'Notas',
        'url' => 'URL',
        'zone' => 'Zonas',

    ],
    'banner_ctr' => [
        'banner' => 'Banner',
        'zone' => 'Zona',
        'clicks' => '# de Clicks',
        'impressions' => 'Impresiones',
        'ctr' => 'CTR',
    ],
    'campaign' => [
        'name' => 'Nombre',
        'advertiser' => 'Anunciante',
        'starts_at' => 'Comienza en',
        'ends_at' => 'Termina en',
        'ends_at_help' => 'Si la fecha de finalización no está seleccionada; la campaña no expirará',
        'notes' => 'Notas',
        'weight' => 'Peso',
        'limit_type' => 'Tipo de Límite',
        'limit_type_options' => [
            'impressions' => 'Impresiones',
            'clicks' => 'Clics',
        ],
        'limit_per_day' => 'Límite por día',
        'limit_per_day_help' => '* required if limit type selected',
    ],
    'impression' => [
        'banner_id' => 'Banner',
        'zone_id' => 'Zona',
        'session_id' => 'Sesión',
        'page_slug' => 'Slug',
        'clicked' => 'Clickeado',
        'visitor_details' => 'Detalles',
    ],
    'website' => [
        'name' => 'Nombre',
        'url' => 'URL',
        'contact' => 'Contacto',
        'email' => 'Correo Electrónico',
        'notes' => 'Notas',
    ],
    'zone' => [
        'name' => 'Nombre',
        'website' => 'Sitio Web',
        'key' => 'Clave',
        'dimension' => 'Dimensión',
        'notes' => 'Notas',
        'banner' => 'Banners',
        'embed_code' => 'Codigo Embebido',
    ],
    'update_status' => 'Status Actualizado !',
    'no_permission' => 'No tiene permisos para actualizar el estado',
];
