<?php

$module_name = 'jjwg_Maps';
$subpanel_layout = [
    'top_buttons' => [
        0 => [
            'widget_class' => 'SubPanelTopCreateButton',
        ],
        1 => [
            'widget_class' => 'SubPanelTopSelectButton',
            'popup_module' => 'jjwg_Maps',
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
        'module_type' => [
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'vname' => 'LBL_MODULE_TYPE',
            'sortable' => false,
            'width' => '10%',
        ],
        'date_modified' => [
            'vname' => 'LBL_DATE_MODIFIED',
            'width' => '45%',
            'default' => true,
        ],
        'edit_button' => [
            'widget_class' => 'SubPanelEditButton',
            'module' => 'jjwg_Maps',
            'width' => '4%',
            'default' => true,
        ],
        'remove_button' => [
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'jjwg_Maps',
            'width' => '5%',
            'default' => true,
        ],
    ],
];
