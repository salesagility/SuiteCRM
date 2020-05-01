<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$subpanel_layout = [
    'top_buttons' => [
        ['widget_class' => 'SubPanelTopCreateButton'],
    ],

    'where' => '',

    'list_fields' => [
        'first_name' => [
            'usage' => 'query_only',
        ],
        'last_name' => [
            'usage' => 'query_only',
        ],
        'name' => [
            'vname' => 'LBL_LIST_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'module' => 'Users',
            'width' => '20%',
        ],
        'user_name' => [
            'vname' => 'LBL_LIST_USER_NAME',
            'width' => '20%',
        ],
        'securitygroup_noninher_fields' => [
            'usage' => 'query_only',
        ],
        'securitygroup_noninherit_id' => [
            'usage' => 'query_only',
        ],
        'securitygroup_noninheritable' => [
            'name' => 'securitygroup_noninheritable',
            'vname' => 'LBL_LIST_NONINHERITABLE',
            'width' => '10%',
            'sortable' => false,
            'widget_type' => 'checkbox',
        ],
        'securitygroup_primary_group' => [
            'name' => 'securitygroup_primary_group',
            'vname' => 'LBL_PRIMARY_GROUP',
            'width' => '10%',
            'sortable' => false,
            'widget_type' => 'checkbox',
        ],
        'email1' => [
            'vname' => 'LBL_LIST_EMAIL',
            'width' => '20%',
        ],
        'phone_work' => [
            'name' => 'phone_work',
            'vname' => 'LBL_LIST_PHONE',
            'width' => '10%',
        ],
        'edit_button' => [
            'widget_class' => 'SubPanelEditSecurityGroupUserButton',
            'securitygroup_noninherit_id' => 'securitygroup_noninherit_id',
            'module' => 'SecurityGroups',
            'width' => '5%',
        ],
        'remove_button' => [
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'Users',
            'width' => '4%',
            'linked_field' => 'users',
        ],
    ],
];
