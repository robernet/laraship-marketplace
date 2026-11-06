<?php

return [
    'notification_template' => [
        'name' => 'Nombre',
        'friendly_name' => 'Nombre Amigable',
        'title' => 'Título',
        'title_help' => 'El título de la notificación a ser mostrado.',
        'via' => 'ía',
        'via_help' => "Canales de Notificación. Si se elige 'Preferencias del Usuario', la notificación será enviada para ambos canales forzados y preferidos por el usuario.",
        'read_at' => 'Leído en',
        'roles' => 'Roles',
        'roles_help' => 'Solo usuarios con este rol pueden personalizar el canal para esta notificación.',
        'bcc_roles' => 'Enviar notificación a Roles (BCC)',
        'bcc_roles_help' => 'BCC será enviado a todos los usuarios en los roles seleccionados.',
        'bcc_users' => 'Enviar notificación a Usuarios (BCC)',
        'bcc_users_help' => 'BCC será enviado a los usuarios seleccionados.',
        'body' => 'Cuerpo *',
        'email_from' => 'De',
        'email_from_help' => 'Al llenar, se anulará el email predeterminado',
    ]
];
