<?php

$module_name = 'AM_TaskTemplates';
$subpanel_layout = [
    'top_buttons' => [
        0 => [
            'widget_class' => 'SubPanelTopCreateButton',
        ],
        1 => [
            'widget_class' => 'SubPanelTopSelectButton',
            'popup_module' => 'AM_TaskTemplates',
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
        'duration' => [
            'type' => 'int',
            'vname' => 'LBL_DURATION',
            'width' => '10%',
            'default' => true,
        ],
        'priority' => [
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'vname' => 'LBL_PRIORITY',
            'width' => '10%',
        ],
        'status' => [
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'vname' => 'LBL_STATUS',
            'width' => '10%',
        ],
        'relationship_type' => [
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'vname' => 'LBL_RELATIONSHIP_TYPE',
            'width' => '10%',
        ],
        'date_modified' => [
            'vname' => 'LBL_DATE_MODIFIED',
            'width' => '45%',
            'default' => true,
        ],
        'edit_button' => [
            'vname' => 'LBL_EDIT_BUTTON',
            'widget_class' => 'SubPanelEditButton',
            'module' => 'AM_TaskTemplates',
            'width' => '4%',
            'default' => true,
        ],
        'remove_button' => [
            'vname' => 'LBL_REMOVE',
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'AM_TaskTemplates',
            'width' => '5%',
            'default' => true,
        ],
    ],
];
