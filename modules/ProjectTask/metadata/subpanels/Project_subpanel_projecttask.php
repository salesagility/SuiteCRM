<?php

// created: 2014-06-24 19:37:50
$subpanel_layout['list_fields'] = [
    'name' => [
        'vname' => 'LBL_LIST_NAME',
        'widget_class' => 'SubPanelDetailViewLink',
        'width' => '20%',
        'default' => true,
    ],
    'project_name' => [
        'type' => 'relate',
        'link' => true,
        'vname' => 'LBL_PARENT_NAME',
        'id' => 'PROJECT_ID',
        'width' => '25%',
        'default' => true,
        'widget_class' => 'SubPanelDetailViewLink',
        'target_module' => 'Project',
        'target_record_key' => 'project_id',
    ],
    'date_start' => [
        'vname' => 'LBL_DATE_START',
        'width' => '10%',
        'default' => true,
    ],
    'date_finish' => [
        'vname' => 'LBL_DATE_FINISH',
        'width' => '10%',
        'default' => true,
    ],
    'order_number' => [
        'type' => 'int',
        'default' => true,
        'vname' => 'LBL_ORDER_NUMBER',
        'width' => '10%',
    ],
    'assigned_user_name' => [
        'type' => 'relate',
        'link' => true,
        'vname' => 'LBL_ASSIGNED_USER_NAME',
        'id' => 'ASSIGNED_USER_ID',
        'width' => '10%',
        'default' => true,
        'widget_class' => 'SubPanelDetailViewLink',
        'target_module' => 'Users',
        'target_record_key' => 'assigned_user_id',
    ],
    'priority' => [
        'type' => 'enum',
        'vname' => 'LBL_PRIORITY',
        'width' => '10%',
        'default' => true,
    ],
    'percent_complete' => [
        'type' => 'int',
        'vname' => 'LBL_PERCENT_COMPLETE',
        'width' => '10%',
        'default' => true,
    ],
];
