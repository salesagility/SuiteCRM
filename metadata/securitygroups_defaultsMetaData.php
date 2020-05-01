<?php

$dictionary['securitygroups_default'] = [
    'table' => 'securitygroups_default',
    'fields' => [
        ['name' => 'id', 'type' => 'char', 'len' => '36', 'required' => true, 'default' => ''], ['name' => 'securitygroup_id', 'type' => 'char', 'len' => '36'], ['name' => 'module', 'type' => 'varchar', 'len' => '50'], ['name' => 'date_modified', 'type' => 'datetime'], ['name' => 'deleted', 'type' => 'bool', 'len' => '1', 'required' => true, 'default' => '0']
    ],
    'indices' => [
        ['name' => 'securitygroups_defaultpk', 'type' => 'primary', 'fields' => ['id']]
    ],
    'relationships' => [
    ]
];
