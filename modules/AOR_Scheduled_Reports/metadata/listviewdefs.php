<?php

$module_name = 'AOR_Scheduled_Reports';
$OBJECT_NAME = 'AOR_SCHEDULED_REPORTS';
$listViewDefs[$module_name] =
[
    'NAME' => [
        'width' => '40%',
        'label' => 'LBL_NAME',
        'link' => true,
        'default' => true,
    ],
    'AOR_REPORT_NAME' => [
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_AOR_REPORT_NAME',
        'id' => 'AOR_REPORT_ID',
        'width' => '10%',
        'default' => true,
    ],
    'STATUS' => [
        'type' => 'enum',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
    ],
    'DATE_MODIFIED' => [
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => false,
    ],
    'ASSIGNED_USER_NAME' => [
        'link' => true,
        'type' => 'relate',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'id' => 'ASSIGNED_USER_ID',
        'width' => '10%',
        'default' => false,
    ],
    'DATE_ENTERED' => [
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
    ],
];
