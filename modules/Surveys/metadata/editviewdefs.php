<?php
$module_name = 'Surveys';
$viewdefs [$module_name] = array(
    'EditView' => array(
        'templateMeta' => array(
            'maxColumns'          => '2',
            'widths'              => array(
                0 => array(
                    'label' => '10',
                    'field' => '30',
                ),
                1 => array(
                    'label' => '10',
                    'field' => '30',
                ),
            ),
            'useTabs'             => false,
            'tabDefs'             => array(
                'DEFAULT' => array(
                    'newTab'       => false,
                    'panelDefault' => 'expanded',
                ),
            ),
            'syncDetailEditViews' => true,
        ),
        'panels'       => array(
            'default' => array(
                0 => array(
                    0 => 'name',
                    1 => 'assigned_user_name',
                ),
                1 => array(
                    0 => array(
                        'name'   => 'status',
                        'studio' => 'visible',
                        'label'  => 'LBL_STATUS',
                    ),
                    1 => '',
                ),
                2 => array(
                    0 => 'description',
                ),
                3 => array(
                    0 => 'survey_questions_display',
                ),
                4 => array(
                    0 => 'submit_text',
                ),
                5 => array(
                    0 => 'satisfied_text',
                ),
                6 => array(
                    0 => 'neither_text',
                ),
                7 => array(
                    0 => 'dissatisfied_text',
                ),
            ),
        ),
    ),
);
