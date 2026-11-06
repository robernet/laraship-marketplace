<?php


return [
    'theme' => [
        'theme_exception' => 'Tema [:name] ya existe',
        'theme_exception_extend' => ', Tema Actual: [:theme]',
        'theme_not_found' => 'Tema :themeName no encontrado',

        'theme_not_added' => 'Archivo de tema inválido',
        'theme_invalid_structure' => 'Estructura de tema inválida',

        'theme_invalid_installed' => 'Tema :themeName ya existe. Debes eliminarlo primero.',

        'theme_not_exist' => 'Error: El tema :name no existe',

        'theme_asset_not_found' => 'Recurso no encontrado [:url]',

        'theme_asset_not_found_warning' => 'Recurso no encontrado [:url] en el Tema [:name]',

        'theme_import_demo' => 'No se encontraron datos de demostración para importar',

        'theme_cannot_delete' => 'No se puede eliminar la carpeta [:viewsPath] del tema [:name] porque
        también es utilizada por el tema [:themeName]',

        'theme_invalid_json' => 'Archivo theme.json inválido [:filename]',

        'theme_invalid_cash_json' => 'Archivo de caché de tema inválido [:cachePath]',

        'theme_invalid_folder' => 'Archivo theme.json inválido en [:themeFolder]',

        'theme_cannot_execute' => 'Tema no activado. No se puede ejecutar el método [:method] en [:self_class]',

    ],
];