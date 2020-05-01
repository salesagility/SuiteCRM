<?php

$module_name = 'SurveyResponses';
$viewdefs[$module_name] = [
    'DetailView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                    3 => 'FIND_DUPLICATES',
                ],
            ],
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
                    0 => 'date_entered',
                    1 => 'date_modified',
                ],
                2 => [
                    0 => 'description',
                    1 => [
                        'name' => 'contact_name',
                    ],
                ],
                3 => [
                    0 => [
                        'name' => 'account_name',
                    ],
                    1 => [
                        'name' => 'survey_name',
                    ],
                ],
                4 => [
                    0 => 'campaign_name',
                ],
                5 => [
                    0 => [
                        'name' => 'question_responses_display'
                    ],
                ],
            ],
        ],
    ],
];
