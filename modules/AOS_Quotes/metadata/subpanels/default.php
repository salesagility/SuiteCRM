<?php

$module_name = 'AOS_Quotes';
$subpanel_layout = [
    'top_buttons' => [
        0 => [
            'widget_class' => 'SubPanelTopCreateButton',
        ],
        1 => [
            'widget_class' => 'SubPanelTopSelectButton',
            'popup_module' => 'AOS_Quotes',
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
            'width' => '15%',
            'currency_format' => true,
            'vname' => 'LBL_GRAND_TOTAL',
            'default' => true,
        ],
        'expiration' => [
            'width' => '15%',
            'vname' => 'LBL_EXPIRATION',
            'default' => true,
        ],
        'assigned_user_name' => [
            'link' => 'assigned_user_link',
            'type' => 'relate',
            'vname' => 'LBL_ASSIGNED_USER',
            'width' => '15%',
            'default' => true,
        ],
        'currency_id' => [
            'usage' => 'query_only',
        ],
        'edit_button' => [
            'widget_class' => 'SubPanelEditButton',
            'module' => 'AOS_Quotes',
            'width' => '4%',
            'default' => true,
        ],
        'remove_button' => [
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'AOS_Quotes',
            'width' => '5%',
            'default' => true,
        ],
    ],
];
