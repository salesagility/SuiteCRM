<?php

$module_name = 'TemplateSectionLine';
$subpanel_layout = [
    'top_buttons' => [
        0 => [
            'widget_class' => 'SubPanelTopCreateButton',
        ],
        1 => [
            'widget_class' => 'SubPanelTopSelectButton',
            'popup_module' => 'TemplateSectionLine',
        ],
    ],
    'where' => '',
    'list_fields' => [
        'grp' => [
            'type' => 'varchar',
            'vname' => 'LBL_GRP',
            'width' => '10%',
            'default' => true,
        ],
        'name' => [
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '45%',
            'default' => true,
        ],
        'description' => [
            'type' => 'text',
            'vname' => 'LBL_DESCRIPTION',
            'sortable' => false,
            'width' => '10%',
            'default' => true,
        ],
        'edit_button' => [
            'vname' => 'LBL_EDIT_BUTTON',
            'widget_class' => 'SubPanelEditButton',
            'module' => 'TemplateSectionLine',
            'width' => '4%',
            'default' => true,
        ],
        'remove_button' => [
            'vname' => 'LBL_REMOVE',
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'TemplateSectionLine',
            'width' => '5%',
            'default' => true,
        ],
    ],
];
