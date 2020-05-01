<?php

$module_name = 'AM_ProjectTemplates';
$listViewDefs[$module_name] =
[
    'NAME' => [
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ],
    'STATUS' => [
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
    ],
    'PRIORITY' => [
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_PRIORITY',
        'width' => '10%',
    ],
    'ASSIGNED_USER_NAME' => [
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ],
];
