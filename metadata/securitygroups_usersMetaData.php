<?php

$dictionary['securitygroups_users'] = [
    'table' => 'securitygroups_users',
    'fields' => [
        [
            'name' => 'id',
            'type' => 'varchar',
            'len' => 36,
        ],
        [
            'name' => 'date_modified',
            'type' => 'datetime',
        ],
        [
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => true,
        ],
        [
            'name' => 'securitygroup_id',
            'type' => 'varchar',
            'len' => 36,
        ],
        [
            'name' => 'user_id',
            'type' => 'varchar',
            'len' => 36,
        ],
        [
            'name' => 'primary_group',
            'vname' => 'LBL_PRIMARY_GROUP',
            'type' => 'bool',
            'reportable' => false,
            'comment' => 'Drives which custom layout to show if a user is a member of more than 1 group'
        ],
        [
            'name' => 'noninheritable',
            'vname' => 'LBL_NONINHERITABLE',
            'type' => 'bool',
            'reportable' => false,
            'default' => '0',
            'comment' => 'Indicator for whether a group can be inherited by a record'
        ],
    ],
    'indices' => [
        [
            'name' => 'securitygroups_usersspk',
            'type' => 'primary',
            'fields' => [
                0 => 'id',
            ],
        ],
        [
            'name' => 'securitygroups_users_idxa',
            'type' => 'index',
            'fields' => [
                0 => 'securitygroup_id',
            ],
        ],
        [
            'name' => 'securitygroups_users_idxb',
            'type' => 'index',
            'fields' => [
                0 => 'user_id',
            ],
        ],
        [
            'name' => 'securitygroups_users_idxc',
            'type' => 'index',
            'fields' => ['user_id', 'deleted', 'securitygroup_id', 'id'],
        ],
        [
            'name' => 'securitygroups_users_idxd',
            'type' => 'index',
            'fields' => ['user_id', 'deleted', 'securitygroup_id'],
        ],
    ],
    'relationships' => [
        'securitygroups_users' => [
            'lhs_module' => 'SecurityGroups',
            'lhs_table' => 'securitygroups',
            'lhs_key' => 'id',
            'rhs_module' => 'Users',
            'rhs_table' => 'users',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_users',
            'join_key_lhs' => 'securitygroup_id',
            'join_key_rhs' => 'user_id',
        ],
    ],
];
