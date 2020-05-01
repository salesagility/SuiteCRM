<?php

$module_name = 'SecurityGroups';
$viewdefs[$module_name]['EditView'] = [
    'templateMeta' => ['maxColumns' => '2',
        'widths' => [
            ['label' => '10', 'field' => '30'],

            ['label' => '10', 'field' => '30']
        ],
    ],

    'panels' => [
        'default' => [
            [
                ['name' => 'name', 'displayParams' => ['required' => true]],
                'assigned_user_name',
            ],

            [
                'noninheritable',
            ],
            [
                'description',
            ],
        ],
    ],
];
