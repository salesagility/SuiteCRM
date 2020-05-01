<?php

$dictionary['securitygroups_records'] = [
    'table' => 'securitygroups_records',
    'fields' => [
        ['name' => 'id', 'type' => 'char', 'len' => '36', 'required' => true, 'default' => ''], ['name' => 'securitygroup_id', 'type' => 'char', 'len' => '36'], ['name' => 'record_id', 'type' => 'char', 'len' => '36'], ['name' => 'module', 'type' => 'char', 'len' => '36'], ['name' => 'date_modified', 'type' => 'datetime'], ['name' => 'modified_user_id', 'type' => 'char', 'len' => '36'], ['name' => 'created_by', 'type' => 'char', 'len' => '36'], ['name' => 'deleted', 'type' => 'bool', 'len' => '1', 'required' => true, 'default' => '0']
    ],
    'indices' => [
        ['name' => 'securitygroups_recordspk', 'type' => 'primary', 'fields' => ['id']],
        ['name' => 'idx_securitygroups_records_mod', 'type' => 'index', 'fields' => ['module', 'deleted', 'record_id', 'securitygroup_id']],
        ['name' => 'idx_securitygroups_records_del', 'type' => 'index', 'fields' => ['deleted', 'record_id', 'module', 'securitygroup_id']],
    ],
    'relationships' => [
        'securitygroups_accounts' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Accounts', 'rhs_table' => 'accounts', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Accounts'],
        'securitygroups_bugs' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Bugs', 'rhs_table' => 'bugs', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Bugs'],
        'securitygroups_calls' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Calls', 'rhs_table' => 'calls', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Calls'],
        'securitygroups_campaigns' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Campaigns', 'rhs_table' => 'campaigns', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Campaigns'],
        'securitygroups_cases' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Cases', 'rhs_table' => 'cases', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Cases'],
        'securitygroups_contacts' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Contacts', 'rhs_table' => 'contacts', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Contacts'],
        'securitygroups_documents' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Documents', 'rhs_table' => 'documents', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Documents'],
        'securitygroups_emails' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Emails', 'rhs_table' => 'emails', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Emails'],
        'securitygroups_emailtemplates' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'EmailTemplates', 'rhs_table' => 'email_templates', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'EmailTemplates'],
        'securitygroups_leads' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Leads', 'rhs_table' => 'leads', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Leads'],
        'securitygroups_meetings' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Meetings', 'rhs_table' => 'meetings', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Meetings'],
        'securitygroups_notes' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Notes', 'rhs_table' => 'notes', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Notes'],
        'securitygroups_opportunities' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Opportunities', 'rhs_table' => 'opportunities', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Opportunities'],
        'securitygroups_project' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Project', 'rhs_table' => 'project', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Project'],
        'securitygroups_project_task' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'ProjectTask', 'rhs_table' => 'project_task', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'ProjectTask'],
        'securitygroups_prospect_lists' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'ProspectLists', 'rhs_table' => 'prospect_lists', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'ProspectLists'],
        'securitygroups_prospects' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Prospects', 'rhs_table' => 'prospects', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Prospects'],
        'securitygroups_tasks' => [
            'lhs_module' => 'SecurityGroups', 'lhs_table' => 'securitygroups', 'lhs_key' => 'id',
            'rhs_module' => 'Tasks', 'rhs_table' => 'tasks', 'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'securitygroups_records', 'join_key_lhs' => 'securitygroup_id', 'join_key_rhs' => 'record_id',
            'relationship_role_column' => 'module', 'relationship_role_column_value' => 'Tasks'],
    ]
];
