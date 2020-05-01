<?php

$module_name = 'Surveys';
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
            'useTabs' => false,
            'tabDefs' => [
                'DEFAULT' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
            'syncDetailEditViews' => true,
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => 'name',
                    1 => 'assigned_user_name',
                ],
                1 => [
                    0 => [
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ],
                    1 => '',
                ],
                2 => [
                    0 => 'description',
                ],
                3 => [
                    0 => 'survey_questions_display',
                ],
                4 => [
                    0 => 'submit_text',
                ],
                5 => [
                    0 => 'satisfied_text',
                ],
                6 => [
                    0 => 'neither_text',
                ],
                7 => [
                    0 => 'dissatisfied_text',
                ],
            ],
        ],
    ],
];
