<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$layout_defs['AOR_Reports'] = [
    'subpanel_setup' => [
        'aor_scheduled_reports_aor_reports' => [
            'order' => 100,
            'module' => 'AOR_Scheduled_Reports',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'AOR_Scheduled_Reports',
            'get_subpanel_data' => 'aor_scheduled_reports',
            'top_buttons' => [
                0 => [
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                ],
                1 => [
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                ],
            ],
        ],
        'securitygroups' => [
            'top_buttons' => [['widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'SecurityGroups', 'mode' => 'MultiSelect']],
            'order' => 900,
            'sort_by' => 'name',
            'sort_order' => 'asc',
            'module' => 'SecurityGroups',
            'refresh_page' => 1,
            'subpanel_name' => 'default',
            'get_subpanel_data' => 'SecurityGroups',
            'add_subpanel_data' => 'securitygroup_id',
            'title_key' => 'LBL_SECURITYGROUPS_SUBPANEL_TITLE',
        ],
    ],
];
