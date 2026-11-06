<?php

return [
    'invite_friends' => [
        'email' => 'Email',
        'name' => 'Nombre',
        'invitation_text_default_placeholder' => 'Hola {name},',
        'invitation_text' => 'Texto de la invitación',
        'invitation_text_help' => 'Utilice el siguiente shortcode para usarlo como marcador de posición del nombre del amigo.',
        'invitation_subject' => 'Asunto de la invitación',
    ],

    'content_consent' => [
        'enabled' => 'Habilitado',
        'popup_content' => 'Contenido del popup',
        'popup_title' => 'Título del popup',
        'accept_button_text' => 'Texto del botón de aceptar',
        'reject_button_text' => 'Texto del botón de rechazar',
        'rejected_redirect_url' => 'Redirigir a url cuando es rechazado',
        'ask_every' => 'Preguntar cada (días)',
        'accept_action_url' => 'URL de acción de aceptar',
        'reject_action_url' => 'URL de acción de rechazar',
    ],

    'notifications' => [
        'invitation' => [
            'body' => 'Cuerpo del mensaje',
            'link' => '<a href=":url">Haga clic aquí para aceptar la invitación</a>',
            'subject' => 'Asunto',
        ],
        'accept_invitation' => [
            'invitee_name' => 'El nombre del invitado',
            'invitee_email' => 'El correo electrónico del invitado',
        ]
    ],
    'pre_defined_date' => 'Fecha Pre Definida',
];
