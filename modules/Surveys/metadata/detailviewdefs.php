<?php

$module_name = 'Surveys';
$viewdefs[$module_name] = [
    'DetailView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                    3 => 'FIND_DUPLICATES',
                    4 => [
                        'customCode' => '<input type="submit" class="button" onClick="var _form = document.getElementById(\'formDetailView\');_form.action.value=\'reports\';SUGAR.ajaxUI.submitForm(_form);" value="{$MOD.LBL_VIEW_SURVEY_REPORTS}">',
                    ],
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
                    0 => 'survey_url_display',
                ],
                2 => [
                    0 => [
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ],
                    1 => '',
                ],
                3 => [
                    0 => 'description',
                ],
                4 => [
                    0 => 'survey_questions_display',
                ],
            ],
        ],
    ],
];
