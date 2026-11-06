<?php


return [
    'menu' => [
        'key' => 'Clave',
        'name' => 'Nombre',
        'url' => 'URL',
        'active_menu_url' => 'Patrón de URL activa',
        'active_menu_url_help' => 'e.g: users* (entonces este elemento de menú será activo en la url users/create)',
        'icon' => 'Ícono',
        'icon_help' => '<i class="fa fa-info-circle"></i> Para más iconos, por favor visita
                <a href="http://fontawesome.io/icons" target="_blank">
                <i class="fa fa-font-awesome" aria-hidden="true"></i> Font Awesome</a>',
        'target' => 'Target',
        'target_options' => [
            '_blank' => 'Nueva ventana',
            '_self' => 'Misma ventana',
        ],
        'roles' => 'Roles',
        'roles_help' => '<span class="text-danger">if no se selecciona ningún rol, entonces el elemento de menú será visible para todos.</span>',
        'description' => 'Descripción',
        'always_active' => 'Siempre Activo'
    ]

];