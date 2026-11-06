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
        'images_root' => 'Ruta Raíz de Imágenes',
        'images_root_help' => 'Ruta completa desde la raíz de la aplicación. <br/>ej. storage/app/marketplace, public/marketplace or /',
        'clear_images' => 'Limpiar imágenes existentes y subir nuevas imágenes desde la importación.'
    ],
    'messages' => [
        'file_uploaded' => 'El archivo ha sido subido exitosamente y un trabajo ha sido enviado para manejar el proceso de importación.'
    ],
    'exceptions' => [
        'invalid_headers' => 'Columnas de archivo de importación inválidas. Por favor, revise el archivo de importación de muestra.',
        'path_not_exist' => 'La ruta no existe.',
    ],
    'product-headers' => [
        'SKU' => '<sup class="required-asterisk">*</sup> El producto se agregará o actualizará según el SKU.',
        'Parent SKU' => 'El SKU del producto principal. Requerido en caso de que el Tipo sea <b>variable</b>.',
        'Type' => '<sup class="required-asterisk">*</sup> Valores válidos: <b>simple</b>, <b>variable</b>',
        'Name' => '<sup class="required-asterisk">*</sup> El nombre del producto.',
        'Short Description' => '<sup class="required-asterisk">*</sup> La descripción corta del producto',
        'Description' => 'La descripción del producto',
        'Status' => '<sup class="required-asterisk">*</sup> Valores válidos: <b>activo</b>, <b>inactivo</b>',
        'Attribute Sets' => 'El código de los conjuntos de atributos del producto. Pipe concatenado para múltiples
                        <br/> <b>e.g. dimension:10cm,15cm,20cm|cubierta:plastico</b>',
        'Attributes' => 'El código de los atributos de variación del producto. Pipe concatenado para múltiples
                        <br/> <b>e.g. color:red|size:small</b>',
        'Brand Name' => 'El nombre de la marca del producto',
        'Categories' => '<sup class="required-asterisk">*</sup> Las categorías del producto. Pipe concatenado para múltiples categorías e.g. <b>Software|Themes|Scripts</b>',
        'Featured Image' => 'La imagen destacada del producto.
                          <br/> Ubicación del archivo en la ruta seleccionada <u>[Ruta Raiz de Imágenes]</u>
                          <br/> e.g. <b>products/x-product/featured.png</b>',
        'Images' => 'Las imágenes del producto.
                          <br/> Ubicación del archivo en la ruta seleccionada <u>[Ruta Raiz de Imágenes]</u>. Pipe concatenado para múltiples
                          <br/> e.g. <b>products/x-product/image-0.png|products/x-product/image-1.png</b>',
        'Regular Price' => '<sup class="required-asterisk">*</sup> El precio regular del producto',
        'Sale Price' => 'El precio de venta del producto',
        'Inventory' => '<sup class="required-asterisk">*</sup> Valores válidos: <b>finito</b>, <b>bucket</b>, <b>infinito</b>',
        'Inventory Value' => 'Requerido cuando el inventario es finito o un bucket. 
                                <br/> En caso de <b>finito</b> el valor es la cantidad de inventario como valor <b>entero</b>.
                                <br/> En caso de <b>bucket</b> valores válidos: <b>in_stock</b>, <b>out_of_stock</b>, <b>limited</b>',
        'Shippable' => 'Determinar si el producto es enviable o no. Valores válidos: <b>1</b>, <b>0</b>',
        'Width' => 'Ancho del paquete',
        'Height' => 'Alto del paquete',
        'Length' => 'Longitud del paquete',
        'Weight' => 'Peso del paquete',
    ],
    'category-headers' => [
        'Name' => 'El nombre de la categoría',
        'Status' => 'El estado de la categoría',
        'Slug' => 'El slug de la categoría. auto generado cuando está vacío',
        'Parent Category' => 'El nombre de la categoría padre.',
        'Featured' => 'Determinar si la categoría es destacada o no. Valores válidos: <b>1</b>, <b>0</b>',
        'Image' => 'Imagen de la categoría.
                          <br/> Ubicación del archivo en la ruta seleccionada <u>[Ruta Raiz de Imágenes]</u>
                          <br/> ej. <b>categories/software/logo.png</b>',
    ],
    'brand-headers' => [
        'Name' => 'El nombre de la marca',
        'Status' => 'El estado de la marca',
        'Slug' => 'El slug de la marca. auto generado cuando está vacío',
        'Featured' => 'Determinar si la marca es destacada o no. Valores válidos: <b>1</b>, <b>0</b>',
        'Image' => 'Imagen de la marca.
                          <br/> Ubicación del archivo en la ruta seleccionada <u>[Ruta Raiz de Imágenes]</u>
                          <br/> e.g. <b>brands/dell/logo.png</b>',
    ]
];
