<?php

$viewdefs['EmailTemplates']['EditView'] = [
    'templateMeta' => ['maxColumns' => '2',
        'widths' => [
            ['label' => '10', 'field' => '30'],
            ['label' => '10', 'field' => '30']
        ],
    ],
    'panels' => [
        'default' => [
            [
                'name',
                '',
            ],

            [
                'type',
            ],

            [
                [
                    'name' => 'description',
                    'displayParams' => [
                        'rows' => '1',
                        'cols' => '90',
                    ],
                ],
            ],

            [
                [
                    'name' => 'tracker_url',
                    'fields' => [
                        'tracker_url',
                        'url_text',
                    ],
                ],
            ],

            [
                [
                    'name' => 'subject',
                    'displayParams' => [
                        'rows' => '1',
                        'cols' => '90',
                    ],
                ],
            ],

            [
                'text_only',
            ],

            [
                [
                    'name' => 'body_html',
                    'displayParams' => [
                        'rows' => '20',
                        'cols' => '100',
                    ],
                ],
            ],

            [
                [
                    'name' => 'ATTACHMENTS_JAVASCRIPT',
                    'customCode' => '{$fields.attachments_javascript.value} {$fields.attachments.value}',
                    'description' => 'This field was auto generated',
                ],
            ],
        ],
    ]
];
