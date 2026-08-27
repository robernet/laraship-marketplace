<?php

return [
    'labels' => [
        'import' => '<i class="fa fa-th fa-th"></i> Import',
        'download_sample' => '<i class="fa fa-download fa-th"></i> Download Import Sample',
        'column' => 'Column',
        'description' => 'Description',
        'column_description' => 'Import columns description',
        'file' => 'Import File (csv)',
        'upload_file' => '<i class="fa fa-upload fa-th"></i> Upload',
    ],
    'messages' => [
        'file_uploaded' => 'File has been uploaded successfully and a job dispatched to handle the import process.'
    ],
    'exceptions' => [
        'invalid_headers' => 'Invalid import file columns. Please check the sample import file.',
        'path_not_exist' => 'path not exist.',
    ],
    'category-headers' => [
        'name' => '<sup class="required-asterisk">*</sup>name',
        'slug' => '<sup class="required-asterisk">*</sup>slug. If there is a matching stored record, it will be modified.',
        'status' => '<sup class="required-asterisk">*</sup>status. Valid values: <b>active</b>, <b>inactive</b>',
        'parent_id' => 'Parent Category id <div><b>Source: </b>Categories</div>',
        'module' => 'module',
        'is_featured' => 'is featured. Valid values: <b>1</b>, <b>0</b>',
        'category_attributes' => 'attributes id. Pipe concatenated for multiple  e.g. <b>2|4</b> <div><b>Source: </b>Attributes</div>',
        'description' => 'description',
        'thumbnail_link' => 'thumbnail link'
    ],
];
