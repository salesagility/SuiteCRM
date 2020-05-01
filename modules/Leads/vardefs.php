<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

$dictionary['Lead'] = ['table' => 'leads', 'audited' => true, 'unified_search' => true, 'full_text_search' => true, 'unified_search_default_enabled' => true, 'duplicate_merge' => true,
    'comment' => 'Leads are persons of interest early in a sales cycle', 'fields' => [
        'converted' => [
            'name' => 'converted',
            'vname' => 'LBL_CONVERTED',
            'type' => 'bool',
            'default' => '0',
            'comment' => 'Has Lead been converted to a Contact (and other Sugar objects)'
        ],
        'refered_by' => [
            'name' => 'refered_by',
            'vname' => 'LBL_REFERED_BY',
            'type' => 'varchar',
            'len' => '100',
            'comment' => 'Identifies who refered the lead',
            'merge_filter' => 'enabled',
        ],
        'lead_source' => [
            'name' => 'lead_source',
            'vname' => 'LBL_LEAD_SOURCE',
            'type' => 'enum',
            'options' => 'lead_source_dom',
            'len' => '100',
            'audited' => true,
            'comment' => 'Lead source (ex: Web, print)',
            'merge_filter' => 'enabled',
        ],
        'lead_source_description' => [
            'name' => 'lead_source_description',
            'vname' => 'LBL_LEAD_SOURCE_DESCRIPTION',
            'type' => 'text',
            'group' => 'lead_source',
            'comment' => 'Description of the lead source'
        ],
        'status' => [
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'len' => '100',
            'options' => 'lead_status_dom',
            'audited' => true,
            'comment' => 'Status of the lead',
            'merge_filter' => 'enabled',
        ],
        'status_description' => [
            'name' => 'status_description',
            'vname' => 'LBL_STATUS_DESCRIPTION',
            'type' => 'text',
            'group' => 'status',
            'comment' => 'Description of the status of the lead'
        ],
        'department' => [
            'name' => 'department',
            'vname' => 'LBL_DEPARTMENT',
            'type' => 'varchar',
            'len' => '100',
            'comment' => 'Department the lead belongs to',
            'merge_filter' => 'enabled',
        ],
        'reports_to_id' => [
            'name' => 'reports_to_id',
            'vname' => 'LBL_REPORTS_TO_ID',
            'type' => 'id',
            'reportable' => false,
            'comment' => 'ID of Contact the Lead reports to'
        ],
        'report_to_name' => [
            'name' => 'report_to_name',
            'rname' => 'name',
            'id_name' => 'reports_to_id',
            'vname' => 'LBL_REPORTS_TO',
            'type' => 'relate',
            'table' => 'contacts',
            'isnull' => 'true',
            'module' => 'Contacts',
            'dbType' => 'varchar',
            'len' => 'id',
            'source' => 'non-db',
            'reportable' => false,
            'massupdate' => false,
        ],
        'reports_to_link' => [
            'name' => 'reports_to_link',
            'type' => 'link',
            'relationship' => 'lead_direct_reports',
            'link_type' => 'one',
            'side' => 'right',
            'source' => 'non-db',
            'vname' => 'LBL_REPORTS_TO',
            'reportable' => false
        ],
        'reportees' => [
            'name' => 'reportees',
            'type' => 'link',
            'relationship' => 'lead_direct_reports',
            'link_type' => 'many',
            'side' => 'left',
            'source' => 'non-db',
            'vname' => 'LBL_REPORTS_TO',
            'reportable' => false
        ],
        'contacts' => [
            'name' => 'contacts',
            'type' => 'link',
            'relationship' => 'contact_leads',
            'module' => 'Contacts',
            'source' => 'non-db',
            'vname' => 'LBL_CONTACTS',
            'reportable' => false
        ],
        'account_name' => [
            'name' => 'account_name',
            'vname' => 'LBL_ACCOUNT_NAME',
            'type' => 'varchar',
            'len' => '255',
            'unified_search' => true,
            'full_text_search' => 1,
            'comment' => 'Account name for lead',
        ],

        'accounts' => [
            'name' => 'accounts',
            'type' => 'link',
            'relationship' => 'account_leads',
            'link_type' => 'one',
            'source' => 'non-db',
            'vname' => 'LBL_ACCOUNT',
            'duplicate_merge' => 'disabled',
        ],

        'account_description' => [
            'name' => 'account_description',
            'vname' => 'LBL_ACCOUNT_DESCRIPTION',
            'type' => 'text',
            'group' => 'account_name',
            'unified_search' => true,
            'full_text_search' => 1,
            'comment' => 'Description of lead account'
        ],
        'contact_id' => [
            'name' => 'contact_id',
            'type' => 'id',
            'reportable' => false,
            'vname' => 'LBL_CONTACT_ID',
            'comment' => 'If converted, Contact ID resulting from the conversion'
        ],
        'contact' => [
            'name' => 'contact',
            'type' => 'link',
            'link_type' => 'one',
            'relationship' => 'contact_leads',
            'source' => 'non-db',
            'vname' => 'LBL_LEADS',
            'reportable' => false,
        ],
        'account_id' => [
            'name' => 'account_id',
            'type' => 'id',
            'reportable' => false,
            'vname' => 'LBL_ACCOUNT_ID',
            'comment' => 'If converted, Account ID resulting from the conversion'
        ],
        'opportunity_id' => [
            'name' => 'opportunity_id',
            'type' => 'id',
            'reportable' => false,
            'vname' => 'LBL_OPPORTUNITY_ID',
            'comment' => 'If converted, Opportunity ID resulting from the conversion'
        ],
        'opportunity' => [
            'name' => 'opportunity',
            'type' => 'link',
            'link_type' => 'one',
            'relationship' => 'opportunity_leads',
            'source' => 'non-db',
            'vname' => 'LBL_OPPORTUNITIES',
        ],
        'opportunity_name' => [
            'name' => 'opportunity_name',
            'vname' => 'LBL_OPPORTUNITY_NAME',
            'type' => 'varchar',
            'len' => '255',
            'comment' => 'Opportunity name associated with lead'
        ],
        'opportunity_amount' => [
            'name' => 'opportunity_amount',
            'vname' => 'LBL_OPPORTUNITY_AMOUNT',
            'type' => 'varchar',
            'group' => 'opportunity_name',
            'len' => '50',
            'comment' => 'Amount of the opportunity'
        ],
        'campaign_id' => [
            'name' => 'campaign_id',
            'type' => 'id',
            'reportable' => false,
            'vname' => 'LBL_CAMPAIGN_ID',
            'comment' => 'Campaign that generated lead'
        ],

        'campaign_name' => [
            'name' => 'campaign_name',
            'rname' => 'name',
            'id_name' => 'campaign_id',
            'vname' => 'LBL_CAMPAIGN',
            'type' => 'relate',
            'link' => 'campaign_leads',
            'table' => 'campaigns',
            'isnull' => 'true',
            'module' => 'Campaigns',
            'source' => 'non-db',
            'additionalFields' => ['id' => 'campaign_id']
        ],
        'campaign_leads' => [
            'name' => 'campaign_leads',
            'type' => 'link',
            'vname' => 'LBL_CAMPAIGN_LEAD',
            'relationship' => 'campaign_leads',
            'source' => 'non-db',
        ],
        'c_accept_status_fields' => [
            'name' => 'c_accept_status_fields',
            'rname' => 'id',
            'relationship_fields' => ['id' => 'accept_status_id', 'accept_status' => 'accept_status_name'],
            'vname' => 'LBL_LIST_ACCEPT_STATUS',
            'type' => 'relate',
            'link' => 'calls',
            'link_type' => 'relationship_info',
            'source' => 'non-db',
            'importable' => 'false',
            'duplicate_merge' => 'disabled',
            'studio' => false,
        ],
        'm_accept_status_fields' => [
            'name' => 'm_accept_status_fields',
            'rname' => 'id',
            'relationship_fields' => ['id' => 'accept_status_id', 'accept_status' => 'accept_status_name'],
            'vname' => 'LBL_LIST_ACCEPT_STATUS',
            'type' => 'relate',
            'link' => 'meetings',
            'link_type' => 'relationship_info',
            'source' => 'non-db',
            'importable' => 'false',
            'hideacl' => true,
            'duplicate_merge' => 'disabled',
            'studio' => false,
        ],
        'accept_status_id' => [
            'name' => 'accept_status_id',
            'type' => 'varchar',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_ACCEPT_STATUS',
            'studio' => ['listview' => false],
        ],
        'accept_status_name' => [
            'massupdate' => false,
            'name' => 'accept_status_name',
            'type' => 'enum',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_ACCEPT_STATUS',
            'options' => 'dom_meeting_accept_status',
            'importable' => 'false',
        ],
        'webtolead_email1' => [
            'name' => 'webtolead_email1',
            'vname' => 'LBL_EMAIL_ADDRESS',
            'type' => 'email',
            'len' => '100',
            'source' => 'non-db',
            'comment' => 'Main email address of lead',
            'importable' => 'false',
            'studio' => 'false',
        ],
        'webtolead_email2' => [
            'name' => 'webtolead_email2',
            'vname' => 'LBL_OTHER_EMAIL_ADDRESS',
            'type' => 'email',
            'len' => '100',
            'source' => 'non-db',
            'comment' => 'Secondary email address of lead',
            'importable' => 'false',
            'studio' => 'false',
        ],
        'webtolead_email_opt_out' => [
            'name' => 'webtolead_email_opt_out',
            'vname' => 'LBL_EMAIL_OPT_OUT',
            'type' => 'bool',
            'source' => 'non-db',
            'comment' => 'Indicator signaling if lead elects to opt out of email campaigns',
            'importable' => 'false',
            'massupdate' => false,
            'studio' => 'false',
        ],
        'webtolead_invalid_email' => [
            'name' => 'webtolead_invalid_email',
            'vname' => 'LBL_INVALID_EMAIL',
            'type' => 'bool',
            'source' => 'non-db',
            'comment' => 'Indicator that email address for lead is invalid',
            'importable' => 'false',
            'massupdate' => false,
            'studio' => 'false',
        ],
        'birthdate' => [
            'name' => 'birthdate',
            'vname' => 'LBL_BIRTHDATE',
            'massupdate' => false,
            'type' => 'date',
            'comment' => 'The birthdate of the contact'
        ],

        'portal_name' => [
            'name' => 'portal_name',
            'vname' => 'LBL_PORTAL_NAME',
            'type' => 'varchar',
            'len' => '255',
            'group' => 'portal',
            'comment' => 'Portal user name when lead created via lead portal',
            'studio' => 'false',
        ],
        'portal_app' => [
            'name' => 'portal_app',
            'vname' => 'LBL_PORTAL_APP',
            'type' => 'varchar',
            'group' => 'portal',
            'len' => '255',
            'comment' => 'Portal application that resulted in created of lead',
            'studio' => 'false',
        ],
        'website' => [
            'name' => 'website',
            'vname' => 'LBL_WEBSITE',
            'type' => 'url',
            'dbType' => 'varchar',
            'len' => 255,
            'link_target' => '_blank',
            'comment' => 'URL of website for the company',
        ],

        'tasks' => [
            'name' => 'tasks',
            'type' => 'link',
            'relationship' => 'lead_tasks',
            'source' => 'non-db',
            'vname' => 'LBL_TASKS',
        ],
        'notes' => [
            'name' => 'notes',
            'type' => 'link',
            'relationship' => 'lead_notes',
            'source' => 'non-db',
            'vname' => 'LBL_NOTES',
        ],
        'meetings' => [
            'name' => 'meetings',
            'type' => 'link',
            'relationship' => 'meetings_leads',
            'source' => 'non-db',
            'vname' => 'LBL_MEETINGS',
        ],
        'calls' => [
            'name' => 'calls',
            'type' => 'link',
            'relationship' => 'calls_leads',
            'source' => 'non-db',
            'vname' => 'LBL_CALLS',
        ],
        'oldmeetings' => [
            'name' => 'oldmeetings',
            'type' => 'link',
            'relationship' => 'lead_meetings',
            'source' => 'non-db',
            'vname' => 'LBL_MEETINGS',
        ],
        'oldcalls' => [
            'name' => 'oldcalls',
            'type' => 'link',
            'relationship' => 'lead_calls',
            'source' => 'non-db',
            'vname' => 'LBL_CALLS',
        ],
        'emails' => [
            'name' => 'emails',
            'type' => 'link',
            'relationship' => 'emails_leads_rel',
            'source' => 'non-db',
            'unified_search' => true,
            'vname' => 'LBL_EMAILS',
        ],
        'email_addresses' => [
            'name' => 'email_addresses',
            'type' => 'link',
            'relationship' => 'leads_email_addresses',
            'module' => 'EmailAddress',
            'source' => 'non-db',
            'vname' => 'LBL_EMAIL_ADDRESSES',
            'reportable' => false,
            'rel_fields' => ['primary_address' => ['type' => 'bool']],
        ],
        'email_addresses_primary' => [
            'name' => 'email_addresses_primary',
            'type' => 'link',
            'relationship' => 'leads_email_addresses_primary',
            'source' => 'non-db',
            'vname' => 'LBL_EMAIL_ADDRESS_PRIMARY',
            'duplicate_merge' => 'disabled',
        ],
        'campaigns' => [
            'name' => 'campaigns',
            'type' => 'link',
            'relationship' => 'lead_campaign_log',
            'module' => 'CampaignLog',
            'bean_name' => 'CampaignLog',
            'source' => 'non-db',
            'vname' => 'LBL_CAMPAIGNLOG',
        ],
        'prospect_lists' => [
            'name' => 'prospect_lists',
            'type' => 'link',
            'relationship' => 'prospect_list_leads',
            'module' => 'ProspectLists',
            'source' => 'non-db',
            'vname' => 'LBL_PROSPECT_LIST',
        ],
        'fp_events_leads_1' => [
            'name' => 'fp_events_leads_1',
            'type' => 'link',
            'relationship' => 'fp_events_leads_1',
            'source' => 'non-db',
            'vname' => 'LBL_FP_EVENTS_LEADS_1_FROM_FP_EVENTS_TITLE',
        ],
        'e_invite_status_fields' => [
            'name' => 'e_invite_status_fields',
            'rname' => 'id',
            'relationship_fields' => [
                'id' => 'event_invite_id',
                'invite_status' => 'event_status_name',
            ],
            'vname' => 'LBL_CONT_INVITE_STATUS',
            'type' => 'relate',
            'link' => 'fp_events_leads_1',
            'link_type' => 'relationship_info',
            'join_link_name' => 'fp_events_leads_1',
            'source' => 'non-db',
            'importable' => 'false',
            'duplicate_merge' => 'disabled',
            'studio' => false,
        ],
        'event_status_name' => [
            'massupdate' => false,
            'name' => 'event_status_name',
            'type' => 'enum',
            'studio' => 'false',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_INVITE_STATUS_EVENT',
            'options' => 'fp_event_invite_status_dom',
            'importable' => 'false',
        ],
        'event_invite_id' => [
            'name' => 'event_invite_id',
            'type' => 'varchar',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_INVITE_STATUS',
            'studio' => [
                'listview' => false,
            ],
        ],
        'e_accept_status_fields' => [
            'name' => 'e_accept_status_fields',
            'rname' => 'id',
            'relationship_fields' => [
                'id' => 'event_status_id',
                'accept_status' => 'event_accept_status',
            ],
            'vname' => 'LBL_CONT_ACCEPT_STATUS',
            'type' => 'relate',
            'link' => 'fp_events_leads_1',
            'link_type' => 'relationship_info',
            'join_link_name' => 'fp_events_leads_1',
            'source' => 'non-db',
            'importable' => 'false',
            'duplicate_merge' => 'disabled',
            'studio' => false,
        ],
        'event_accept_status' => [
            'massupdate' => false,
            'name' => 'event_accept_status',
            'type' => 'enum',
            'studio' => 'false',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_ACCEPT_STATUS_EVENT',
            'options' => 'fp_event_status_dom',
            'importable' => 'false',
        ],
        'event_status_id' => [
            'name' => 'event_status_id',
            'type' => 'varchar',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_ACCEPT_STATUS',
            'studio' => [
                'listview' => false,
            ],
        ],
    ], 'indices' => [
        ['name' => 'idx_lead_acct_name_first', 'type' => 'index', 'fields' => ['account_name', 'deleted']],
        ['name' => 'idx_lead_last_first', 'type' => 'index', 'fields' => ['last_name', 'first_name', 'deleted']],
        ['name' => 'idx_lead_del_stat', 'type' => 'index', 'fields' => ['last_name', 'status', 'deleted', 'first_name']],
        ['name' => 'idx_lead_opp_del', 'type' => 'index', 'fields' => ['opportunity_id', 'deleted']],
        ['name' => 'idx_leads_acct_del', 'type' => 'index', 'fields' => ['account_id', 'deleted']],
        ['name' => 'idx_del_user', 'type' => 'index', 'fields' => ['deleted', 'assigned_user_id']],
        ['name' => 'idx_lead_assigned', 'type' => 'index', 'fields' => ['assigned_user_id']],
        ['name' => 'idx_lead_contact', 'type' => 'index', 'fields' => ['contact_id']],
        ['name' => 'idx_reports_to', 'type' => 'index', 'fields' => ['reports_to_id']],
        ['name' => 'idx_lead_phone_work', 'type' => 'index', 'fields' => ['phone_work']],
        ['name' => 'idx_leads_id_del', 'type' => 'index', 'fields' => ['id', 'deleted']],
    ], 'relationships' => [
        'lead_direct_reports' => ['lhs_module' => 'Leads', 'lhs_table' => 'leads', 'lhs_key' => 'id',
            'rhs_module' => 'Leads', 'rhs_table' => 'leads', 'rhs_key' => 'reports_to_id',
            'relationship_type' => 'one-to-many'],
        'lead_tasks' => ['lhs_module' => 'Leads', 'lhs_table' => 'leads', 'lhs_key' => 'id',
            'rhs_module' => 'Tasks', 'rhs_table' => 'tasks', 'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many', 'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Leads'], 'lead_notes' => ['lhs_module' => 'Leads', 'lhs_table' => 'leads', 'lhs_key' => 'id',
                'rhs_module' => 'Notes', 'rhs_table' => 'notes', 'rhs_key' => 'parent_id',
                'relationship_type' => 'one-to-many', 'relationship_role_column' => 'parent_type',
                'relationship_role_column_value' => 'Leads'], 'lead_meetings' => ['lhs_module' => 'Leads', 'lhs_table' => 'leads', 'lhs_key' => 'id',
                    'rhs_module' => 'Meetings', 'rhs_table' => 'meetings', 'rhs_key' => 'parent_id',
                    'relationship_type' => 'one-to-many', 'relationship_role_column' => 'parent_type',
                    'relationship_role_column_value' => 'Leads'], 'lead_calls' => ['lhs_module' => 'Leads', 'lhs_table' => 'leads', 'lhs_key' => 'id',
                        'rhs_module' => 'Calls', 'rhs_table' => 'calls', 'rhs_key' => 'parent_id',
                        'relationship_type' => 'one-to-many', 'relationship_role_column' => 'parent_type',
                        'relationship_role_column_value' => 'Leads'], 'lead_emails' => ['lhs_module' => 'Leads', 'lhs_table' => 'leads', 'lhs_key' => 'id',
                            'rhs_module' => 'Emails', 'rhs_table' => 'emails', 'rhs_key' => 'parent_id',
                            'relationship_type' => 'one-to-many', 'relationship_role_column' => 'parent_type',
                            'relationship_role_column_value' => 'Leads'],
        'lead_campaign_log' => [
            'lhs_module' => 'Leads',
            'lhs_table' => 'leads',
            'lhs_key' => 'id',
            'rhs_module' => 'CampaignLog',
            'rhs_table' => 'campaign_log',
            'rhs_key' => 'target_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'target_type',
            'relationship_role_column_value' => 'Leads'
        ]
    ]
    //This enables optimistic locking for Saves From EditView
    , 'optimistic_locking' => true,
];

VardefManager::createVardef('Leads', 'Lead', ['default', 'assignable', 'security_groups',
    'person']);
