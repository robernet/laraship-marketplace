<?php

return [
    'webhook' => [
        'event_name' => 'Event',
        'payload' => 'Payload',
        'exception' => 'Exception',
        'properties' => 'Properties',
        'status_options' => [
            'pending' => 'Pending',
            'processed' => 'Processed',
            'partially_processed' => 'Partially Processed',
            'failed' => 'Failed',
        ],
    ],
    'update_status' => 'Status has been update.',
    'no_permission' => 'There is no permission update status',
];
