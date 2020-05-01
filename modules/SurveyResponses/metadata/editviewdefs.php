<?php

$module_name = 'SurveyResponses';
$viewdefs[$module_name] = [
    'EditView' => [
        'templateMeta' => [
            'maxColumns' => '2',
            'widths' => [
                0 => [
                    'label' => '10',
                    'field' => '30',
                ],
                1 => [
                    'label' => '10',
                    'field' => '30',
                ],
            ],
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => 'name',
                    1 => 'assigned_user_name',
                ],
                1 => [
                    0 => 'description',
                    1 => [
                        'name' => 'contact_name',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'account_name',
                    ],
                    1 => [
                        'name' => 'survey_name',
                    ],
                ],
                3 => [
                    0 => 'campaign_name',
                ],
            ],
        ],
    ],
];
