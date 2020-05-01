<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$subpanel_layout = [
    'top_buttons' => [
        ['widget_class' => 'SubPanelTopCreateButton'],
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
        'edit_button' => [
            'widget_class' => 'SubPanelEditButton',
            'module' => 'SecurityGroups',
            'width' => '5%',
        ],
        'remove_button' => [
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'SecurityGroups',
            'width' => '5%',
            'refresh_page' => true,
        ],
    ],
];
