<?php

$module_name = 'AOS_Invoices';
$subpanel_layout = [
    'top_buttons' => [
        0 => [
            'widget_class' => 'SubPanelTopCreateButton',
        ],
        1 => [
            'widget_class' => 'SubPanelTopSelectButton',
            'popup_module' => 'AOS_Invoices',
        ],
    ],
    'where' => '',
    'list_fields' => [
        'number' => [
            'width' => '5%',
            'vname' => 'LBL_LIST_NUM',
            'default' => true,
        ],
        'name' => [
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '25%',
            'default' => true,
        ],
        'billing_account' => [
            'width' => '20%',
            'vname' => 'LBL_BILLING_ACCOUNT',
            'default' => true,
        ],
        'total_amount' => [
            'type' => 'currency',
            'vname' => 'LBL_GRAND_TOTAL',
            'currency_format' => true,
            'width' => '15%',
            'default' => true,
        ],
        'status' => [
            'width' => '15%',
            'vname' => 'LBL_STATUS',
            'default' => true,
        ],
        'assigned_user_name' => [
            'name' => 'assigned_user_name',
            'vname' => 'LBL_ASSIGNED_USER',
            'width' => '15%',
            'default' => true,
        ],
        'currency_id' => [
            'usage' => 'query_only',
        ],
        'edit_button' => [
            'widget_class' => 'SubPanelEditButton',
            'module' => 'AOS_Invoices',
            'width' => '4%',
            'default' => true,
        ],
        'remove_button' => [
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'AOS_Invoices',
            'width' => '5%',
            'default' => true,
        ],
    ],
];
