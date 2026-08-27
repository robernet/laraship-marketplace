<?php

return [
    'models' => [
        'rating' => [
            'presenter' => \Corals\Utility\Rating\Transformers\RatingPresenter::class,
            'resource_url' => 'utilities/ratings',
            'actions' => [
                'pending' => [
                    'icon' => 'fa fa-fw fa-clock-o',
                    'href_pattern' => ['pattern' => '[arg]/pending', 'replace' => ['return $object->getShowURL();']],
                    'label_pattern' => ['pattern' => '[arg]', 'replace' => ["return trans('utility-rating::attributes.rating.status_options.pending');"]],
                    'policies' => ['updateStatus'],
                    'policies_args' => 'pending',
                    'permissions' => [],
                    'data' => [
                        'action' => "post",
                        'table' => "#RatingsDataTable",
                    ],
                ],
                'approved' => [
                    'icon' => 'fa fa-fw fa-check',
                    'href_pattern' => ['pattern' => '[arg]/approved', 'replace' => ['return $object->getShowURL();']],
                    'label_pattern' => ['pattern' => '[arg]', 'replace' => ["return trans('utility-rating::attributes.rating.status_options.approved');"]],
                    'policies' => ['updateStatus'],
                    'policies_args' => 'approved',
                    'permissions' => [],
                    'data' => [
                        'action' => "post",
                        'table' => "#RatingsDataTable",
                    ],
                ],

                'disapproved' => [
                    'icon' => 'fa fa-fw fa-remove',
                    'href_pattern' => ['pattern' => '[arg]/disapproved', 'replace' => ['return $object->getShowURL();']],
                    'label_pattern' => ['pattern' => '[arg]', 'replace' => ["return trans('utility-rating::attributes.rating.status_options.disapproved');"]],
                    'policies' => ['updateStatus'],
                    'policies_args' => 'disapproved',
                    'permissions' => [],
                    'data' => [
                        'action' => "post",
                        'table' => "#RatingsDataTable",
                    ],
                ],
                'spam' => [
                    'icon' => 'fa fa-fw fa-remove',
                    'href_pattern' => ['pattern' => '[arg]/spam', 'replace' => ['return $object->getShowURL();']],
                    'label_pattern' => ['pattern' => '[arg]', 'replace' => ["return trans('utility-rating::attributes.rating.status_options.spam');"]],
                    'policies' => ['updateStatus'],
                    'policies_args' => 'spam',
                    'permissions' => [],
                    'data' => [
                        'action' => "post",
                        'table' => "#RatingsDataTable",
                    ],
                ],
            ],
        ],
    ],
];
