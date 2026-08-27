<?php

return [
    'models' => [
        'comment' => [
            'presenter' => \Corals\Utility\Comment\Transformers\CommentPresenter::class,
            'resource_url' => 'utilities/comments',
            'status_options' => [
                'pending' => [
                    'text' => 'utility-comment::attributes.comments.status_options.pending',
                    'level' => 'info',
                ],
                'published' => [
                    'text' => 'utility-comment::attributes.comments.status_options.published',
                    'level' => 'success',
                ],
                'trashed' => [
                    'text' => 'utility-comment::attributes.comments.status_options.trashed',
                    'level' => 'warning',
                ],
            ],
            'actions' => [
                'edit' => [],
                'pending' => [
                    'icon' => 'fa fa-fw fa-clock-o',
                    'href_pattern' => ['pattern' => '[arg]/pending', 'replace' => ['return $object->getShowURL();']],
                    'label_pattern' => [
                        'pattern' => '[arg]',
                        'replace' => ["return trans('utility-comment::attributes.comments.status_options.pending');"],
                    ],
                    'policies' => ['updateStatus'],
                    'policies_args' => 'pending',
                    'permissions' => [],
                    'data' => [
                        'action' => "post",
                        'table' => "#CommentsDataTable",
                    ],
                ],
                'published' => [
                    'icon' => 'fa fa-fw fa-check',
                    'href_pattern' => ['pattern' => '[arg]/published', 'replace' => ['return $object->getShowURL();']],
                    'label_pattern' => [
                        'pattern' => '[arg]',
                        'replace' => ["return trans('utility-comment::attributes.comments.status_options.published');"],
                    ],
                    'policies' => ['updateStatus'],
                    'policies_args' => 'published',
                    'permissions' => [],
                    'data' => [
                        'action' => "post",
                        'table' => "#CommentsDataTable",
                    ],
                ],
                'trashed' => [
                    'icon' => 'fa fa-fw fa-trash-o',
                    'href_pattern' => ['pattern' => '[arg]/trashed', 'replace' => ['return $object->getShowURL();']],
                    'label_pattern' => [
                        'pattern' => '[arg]',
                        'replace' => ["return trans('utility-comment::attributes.comments.status_options.trashed');"],
                    ],
                    'policies' => ['updateStatus'],
                    'policies_args' => 'trashed',
                    'permissions' => [],
                    'data' => [
                        'action' => "post",
                        'table' => "#CommentsDataTable",
                    ],
                ],
            ],
        ],
    ],
];
