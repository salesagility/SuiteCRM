<?php

$module_name = 'jjwg_Areas';
$viewdefs[$module_name]['QuickCreate'] = [
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
                'assigned_user_name',
            ],
        ],
    ],
];
