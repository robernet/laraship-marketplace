<?php

return [
    'models' => [
        'tag' => [
            'presenter' => \Corals\Utility\Tag\Transformers\TagPresenter::class,
            'resource_url' => 'utilities/tags',
            'translatable' => ['name'],
        ],
    ],
];
