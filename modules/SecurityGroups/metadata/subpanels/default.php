<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

//$module_name='SecurityGroups';
$subpanel_layout = [
    'top_buttons' => [
        ['widget_class' => 'SubPanelTopSelectButton'],
    ],

    'where' => '',

    'list_fields' => [
        'name' => [
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '9999%',
        ],
        'description' => [
            'vname' => 'LBL_DESCRIPTION',
            'width' => '9999%',
            'sortable' => false,
        ],
        'remove_button' => [
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'SecurityGroups',
            'width' => '5%',
            //'refresh_page'=>true,
        ],
    ],
];
