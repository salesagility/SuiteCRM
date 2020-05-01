<?php

$module_name = 'AOS_Contracts';
$subpanel_layout = [
    'top_buttons' => [
        0 => [
            'widget_class' => 'SubPanelTopCreateButton',
        ],
        1 => [
            'widget_class' => 'SubPanelTopSelectButton',
            'popup_module' => 'AOS_Contracts',
        ],
    ],
    'where' => '',
    'list_fields' => [
        'name' => [
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '25%',
            'default' => true,
        ],
        'contract_account' => [
            'type' => 'date',
            'vname' => 'LBL_CONTRACT_ACCOUNT',
            'width' => '20%',
            'default' => true,
        ],
        'total_contract_value' => [
            'type' => 'currency',
            'vname' => 'LBL_TOTAL_CONTRACT_VALUE',
            'currency_format' => true,
            'width' => '15%',
            'default' => true,
        ],
        'status' => [
            'type' => 'date',
            'vname' => 'LBL_STATUS',
            'width' => '15%',
            'default' => true,
        ],
        'assigned_user_name' => [
            'link' => 'assigned_user_link',
            'type' => 'relate',
            'vname' => 'LBL_ASSIGNED_TO_NAME',
            'width' => '15%',
            'default' => true,
        ],
        'currency_id' => [
            'usage' => 'query_only',
        ],
        'edit_button' => [
            'widget_class' => 'SubPanelEditButton',
            'module' => 'AOS_Contracts',
            'width' => '4%',
            'default' => true,
        ],
        'remove_button' => [
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'AOS_Contracts',
            'width' => '5%',
            'default' => true,
        ],
    ],
];
