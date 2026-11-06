<?php

return [
    'labels' => [
        'import' => '<i class="fa fa-th fa-th"></i> Importar',
        'download_sample' => '<i class="fa fa-download fa-th"></i> Descargar Muestra de Importación',
        'column' => 'Columna',
        'description' => 'Descripción',
        'column_description' => 'Descripción de las columnas de importación',
        'file' => 'Archivo de Importación (csv)',
        'upload_file' => '<i class="fa fa-upload fa-th"></i> Subir Archivo',
    ],
    'messages' => [
        'file_uploaded' => 'Archivo subido exitosamente y un trabajo ha sido enviado para manejar el proceso de importación.'
    ],
    'exceptions' => [
        'invalid_headers' => 'Columnas del archivo de importación inválidas. Por favor, verifique el archivo de importación de muestra.',
        'path_not_exist' => 'La ruta no existe.',
    ],
    'user-headers' => [
        'name' => 'nombre del usuario',
        'last_name' => 'apellido del usuario',
        'email' => 'correo electrónico del usuario',
    ],

];
