<?php

$locationTypes = \Settings::get('utility_location_types', []);
$types = [];
foreach ($locationTypes as $locationType) {
    $types [] = '<b>' . $locationType . '</b>';
}

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
    'location-headers' => [
        'name' => '<sup class="required-asterisk">*</sup>name. If there is a matching stored record, it will be modified.',
        'slug' => 'slug',
        'status' => '<sup class="required-asterisk">*</sup>status. Valid values: <b>active</b>, <b>inactive</b>',
        'address' => '<sup class="required-asterisk">*</sup>address',
        'lat' => '<sup class="required-asterisk">*</sup>latitude',
        'long' => '<sup class="required-asterisk">*</sup>longitude',
        'zip' => 'zip',
        'city' => 'city',
        'state' => 'state',
        'country' => 'country',
        'module' => 'module',
        'type' => 'type e.g. ' . implode(', ', $types),
        'parent_id' => 'parent location. <div><b>Source: </b>Locations</div>',
        'description' => 'description',
    ],
];
