<?php

$module_name = 'jjwg_Areas';
$subpanel_layout = [
    'top_buttons' => [
        0 => [
            'widget_class' => 'SubPanelTopCreateButton',
        ],
        1 => [
            'widget_class' => 'SubPanelTopSelectButton',
            'popup_module' => 'jjwg_Areas',
        ],
    ],
    'where' => '',
    'list_fields' => [
        'name' => [
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '45%',
            'default' => true,
        ],
        'city' => [
            'type' => 'varchar',
            'vname' => 'LBL_CITY',
            'width' => '10%',
            'default' => true,
        ],
        'state' => [
            'type' => 'varchar',
            'vname' => 'LBL_STATE',
            'width' => '10%',
            'default' => true,
        ],
        'country' => [
            'type' => 'varchar',
            'vname' => 'LBL_COUNTRY',
            'width' => '10%',
            'default' => true,
        ],
        'date_modified' => [
            'vname' => 'LBL_DATE_MODIFIED',
            'width' => '45%',
            'default' => true,
        ],
        'assigned_user_name' => [
            'link' => 'assigned_user_link',
            'type' => 'relate',
            'vname' => 'LBL_ASSIGNED_TO_NAME',
            'width' => '10%',
            'default' => true,
        ],
        'edit_button' => [
            'widget_class' => 'SubPanelEditButton',
            'module' => 'jjwg_Areas',
            'width' => '4%',
            'default' => true,
        ],
        'remove_button' => [
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'jjwg_Areas',
            'width' => '5%',
            'default' => true,
        ],
    ],
];
