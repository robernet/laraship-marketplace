<?php

return [
    'models' => [
        'location' => [
            'presenter' => \Corals\Utility\Location\Transformers\LocationPresenter::class,
            'resource_url' => 'utilities/address/locations',
            'genericActions' => [
                'import' => [
                    'class' => 'btn btn-primary',
                    'href_pattern' => [
                        'pattern' => '[arg]',
                        'replace' => ['return url("utilities/locations/import/locations/get-import-modal");']
                    ],
                    'label_pattern' => ['pattern' => '[arg]', 'replace' => ['return trans("utility-location::labels.import");']],
                    'policies' => ['create'],
                    'data' => [
                        'action' => 'modal-load',
                        'title_pattern' => [
                            'pattern' => '[arg]',
                            'replace' => ['return trans("utility-location::labels.import");']
                        ],
                    ],
                ],
            ]
        ],
    ],
];
