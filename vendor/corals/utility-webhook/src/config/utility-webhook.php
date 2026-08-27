<?php

return [
    'models' => [
        'webhook' => [
            'presenter' => \Corals\Utility\Webhook\Transformers\WebhookPresenter::class,
            'resource_url' => 'utilities/webhooks',
            'events' => [],
            'actions' => [
                'edit' => [],
                'process' => [
                    'icon' => 'fa fa-fw fa-send',
                    'href_pattern' => ['pattern' => '[arg]/process', 'replace' => ['return $object->getShowURL();']],
                    'label_pattern' => ['pattern' => '[arg]', 'replace' => ["return trans('utility-webhook::labels.webhook.process');"]],
                    'policies' => ['process'],
                    'data' => [
                        'action' => 'post',
                        'table' => '.dataTableBuilder',
                    ],
                ],
            ],
        ],
    ],
];
