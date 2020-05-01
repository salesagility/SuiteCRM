<?php

$dictionary['securitygroups_acl_roles'] = [
    'table' => 'securitygroups_acl_roles',
    'fields' => [
        ['name' => 'id', 'type' => 'char', 'len' => '36', 'required' => true, 'default' => ''], ['name' => 'securitygroup_id', 'type' => 'char', 'len' => '36'], ['name' => 'role_id', 'type' => 'char', 'len' => '36'], ['name' => 'date_modified', 'type' => 'datetime'], ['name' => 'deleted', 'type' => 'bool', 'len' => '1', 'required' => true, 'default' => '0']
    ],
    'indices' => [
        ['name' => 'securitygroups_acl_rolespk', 'type' => 'primary', 'fields' => ['id']]
    ],
    'relationships' => [
        'securitygroups_acl_roles' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'ACLRoles', 'rhs_table' => 'acl_roles', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_acl_roles', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'role_id',
        ],
    ]
];
