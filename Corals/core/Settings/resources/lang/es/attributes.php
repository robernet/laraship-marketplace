<?php


return [
    'setting' => [
        'label' => 'Etiqueta',
        'value' => 'Valor',
        'code' => 'Código',
        'category' => 'Categoría',
        'enable' => 'Habilitado',
    ],
    'custom_field' => [
        'model' => 'Modelo',
        'name' => 'Nombre del Campo',
        'label' => 'Etiqueta',
        'type' => 'Tipo',
        'type_options' => [
            'text' => 'Text',
            'textarea' => 'TextArea',
            'date' => 'Date',
            'number' => 'Number',
            'select' => 'Select',
            'checkbox' => 'CheckBox',
            'radio' => 'Radio',
            'multi_values' => 'Multi Values',
            'label' => 'Label',
            'file' => 'File',
            'hidden' => 'Hidden',
            'google_location' => 'Google location',
            'color' => 'Color'
        ],

        'select_display_type_options' => [
            'label' => 'Etiqueta',
            'color' => 'Color',
            'image' => 'Imagen'
        ],

        'field_config' => [
            'searchable' => 'Buscable',
            'sortable' => 'Ordenable',
            'full_text_search' => 'Búsqueda de texto completo',
            'show_in_list' => 'Mostrar en la lista',
            'grid_class' => 'Clase de cuadrícula',
            'order' => 'Orden',
            'full_text_search_options' => [
                'title' => 'Título',
                'content' => 'Contenido'
            ],
            'is_identifier' => 'Es Identificador'
        ],
        'default_value' => 'Valor Predeterminado',
        'validation_rules' => 'Reglas de Validación',
        'validation_rules_help' => '<a target="_blank" href="https://laravel.com/docs/7.x/validation" >Reglas de Validación de Laravel</a>',
        'attribute' => 'Atributos de Entrada <small>(placeholder, title etc...)</small>',
        'options_source' => 'Fuente de Opciones',
        'options_source_model' => 'Modelo Fuente',
        'options_source_model_column' => 'Mostrar Columna del Modelo',
        'options' => 'Opciones',
        'required' => 'Requerido'
    ],
    'module' => [
        'code' => 'Código del Módulo',
        'license' => 'Clave de Licencia del Módulo',
    ],
    'address' => [
        'type' => 'Tipo',
        'address_one' => 'Dirección 1',
        'address_two' => 'Dirección 2',
        'city' => 'Ciudad',
        'state' => 'Estado',
        'zip' => 'Código Postal',
        'country' => 'País',
        'action' => 'Acción',
    ],
];
