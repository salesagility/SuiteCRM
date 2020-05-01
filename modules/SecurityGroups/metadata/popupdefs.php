<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$module_name = 'SecurityGroups';
$table_name = 'securitygroups';
$popupMeta = ['moduleMain' => 'SecurityGroup',
    'varName' => $module_name,
    'orderBy' => $table_name . '.name',
    'whereClauses' => ['name' => $table_name . '.name',
    ],
    'searchInputs' => ['name'],
    'listview' => 'modules/' . $module_name . '/metadata/listviewdefs.php',
    'search' => 'modules/' . $module_name . '/metadata/searchdefs.php',
];
