<?php

return [
    'models' => [
        'category' => [
            'presenter' => \Corals\Utility\Category\Transformers\CategoryPresenter::class,
            'resource_url' => 'utilities/categories',
            'default_image' => 'assets/corals/images/default_product_image.png',
            'translatable' => ['name'],
            'genericActions' => [
                'import' => [
                    'class' => 'btn btn-primary',
                    'href_pattern' => [
                        'pattern' => '[arg]',
                        'replace' => ['return url("utilities/categories/import/categories/get-import-modal");']
                    ],
                    'label_pattern' => ['pattern' => '[arg]', 'replace' => ['return trans("utility-category::labels.import");']],
                    'policies' => ['create'],
                    'data' => [
                        'action' => 'modal-load',
                        'title_pattern' => [
                            'pattern' => '[arg]',
                            'replace' => ['return trans("utility-category::labels.import");']
                        ],
                    ],
                ],
            ]
        ],
        'attribute' => [
            'presenter' => \Corals\Utility\Category\Transformers\AttributePresenter::class,
            'resource_url' => 'utilities/attributes',
        ],
    ],
];
