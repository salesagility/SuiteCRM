<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
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


$dictionary['Opportunity'] = array('table' => 'opportunities', 'audited' => true, 'unified_search' => true, 'full_text_search' => true, 'unified_search_default_enabled' => true, 'duplicate_merge' => true,
    'comment' => 'An opportunity is the target of selling activities',
    'fields' => array(
        'name' =>
            array(
                'name' => 'name',
                'vname' => 'LBL_OPPORTUNITY_NAME',
                'type' => 'name',
                'dbType' => 'varchar',
                'len' => '50',
                'unified_search' => true,
                'full_text_search' => array('boost' => 3),
                'comment' => 'Name of the opportunity',
                'merge_filter' => 'selected',
                'importable' => 'required',
                'required' => true,
            ),
        'opportunity_type' =>
            array(
                'name' => 'opportunity_type',
                'vname' => 'LBL_TYPE',
                'type' => 'enum',
                'options' => 'opportunity_type_dom',
                'len' => '255',
                'audited' => true,
                'comment' => 'Type of opportunity (ex: Existing, New)',
                'merge_filter' => 'enabled',
            ),
        'account_name' =>
            array(
                'name' => 'account_name',
                'rname' => 'name',
                'id_name' => 'account_id',
                'vname' => 'LBL_ACCOUNT_NAME',
                'type' => 'relate',
                'table' => 'accounts',
                'join_name' => 'accounts',
                'isnull' => 'true',
                'module' => 'Accounts',
                'dbType' => 'varchar',
                'link' => 'accounts',
                'len' => '255',
                'source' => 'non-db',
                'unified_search' => true,
                'required' => true,
                'importable' => 'required',
                'required' => true,
            ),
        'account_id' =>
            array(
                'name' => 'account_id',
                'vname' => 'LBL_ACCOUNT_ID',
                'type' => 'id',
                'source' => 'non-db',
                'audited' => true,
            ),
        'campaign_id' =>
            array(
                'name' => 'campaign_id',
                'comment' => 'Campaign that generated lead',
                'vname' => 'LBL_CAMPAIGN_ID',
                'rname' => 'id',
                'type' => 'id',
                'dbType' => 'id',
                'table' => 'campaigns',
                'isnull' => 'true',
                'module' => 'Campaigns',
                //'dbType' => 'char',
                'reportable' => false,
                'massupdate' => false,
                'duplicate_merge' => 'disabled',
            ),
        'campaign_name' =>
            array(
                'name' => 'campaign_name',
                'rname' => 'name',
                'id_name' => 'campaign_id',
                'vname' => 'LBL_CAMPAIGN',
                'type' => 'relate',
                'link' => 'campaign_opportunities',
                'isnull' => 'true',
                'table' => 'campaigns',
                'module' => 'Campaigns',
                'source' => 'non-db',
                'additionalFields' => array('id' => 'campaign_id')
            ),
        'campaign_opportunities' =>
            array(
                'name' => 'campaign_opportunities',
                'type' => 'link',
                'vname' => 'LBL_CAMPAIGN_OPPORTUNITY',
                'relationship' => 'campaign_opportunities',
                'source' => 'non-db',
            ),
        'lead_source' =>
            array(
                'name' => 'lead_source',
                'vname' => 'LBL_LEAD_SOURCE',
                'type' => 'enum',
                'options' => 'lead_source_dom',
                'len' => '50',
                'comment' => 'Source of the opportunity',
                'merge_filter' => 'enabled',
            ),
        'amount' =>
            array(
                'name' => 'amount',
                'vname' => 'LBL_AMOUNT',
                //'function'=>array('vname'=>'getCurrencyType'),
                'type' => 'currency',
//    'disable_num_format' => true,
                'dbType' => 'double',
                'comment' => 'Unconverted amount of the opportunity',
                'importable' => 'required',
                'duplicate_merge' => '1',
                'required' => true,
                'options' => 'numeric_range_search_dom',
                'enable_range_search' => true,
            ),
        'amount_usdollar' =>
            array(
                'name' => 'amount_usdollar',
                'vname' => 'LBL_AMOUNT_USDOLLAR',
                'type' => 'currency',
                'group' => 'amount',
                'dbType' => 'double',
                'disable_num_format' => true,
                'duplicate_merge' => '0',
                'audited' => true,
                'comment' => 'Formatted amount of the opportunity',
                'studio' => array(
                    'editview' => false,
                    'detailview' => false,
                    'quickcreate' => false,
                ),
            ),
        'currency_id' =>
            array(
                'name' => 'currency_id',
                'type' => 'id',
                'group' => 'currency_id',
                'vname' => 'LBL_CURRENCY',
                'function' => array('name' => 'getCurrencyDropDown', 'returns' => 'html', 'onListView' => true),
                'reportable' => false,
                'comment' => 'Currency used for display purposes'
            ),
        'currency_name' =>
            array(
                'name' => 'currency_name',
                'rname' => 'name',
                'id_name' => 'currency_id',
                'vname' => 'LBL_CURRENCY_NAME',
                'type' => 'relate',
                'isnull' => 'true',
                'table' => 'currencies',
                'module' => 'Currencies',
                'source' => 'non-db',
                'function' => array('name' => 'getCurrencyNameDropDown', 'returns' => 'html'),
                'studio' => 'false',
                'duplicate_merge' => 'disabled',
            ),
        'currency_symbol' =>
            array(
                'name' => 'currency_symbol',
                'rname' => 'symbol',
                'id_name' => 'currency_id',
                'vname' => 'LBL_CURRENCY_SYMBOL',
                'type' => 'relate',
                'isnull' => 'true',
                'table' => 'currencies',
                'module' => 'Currencies',
                'source' => 'non-db',
                'function' => array('name' => 'getCurrencySymbolDropDown', 'returns' => 'html'),
                'studio' => 'false',
                'duplicate_merge' => 'disabled',
            ),
        'date_closed' =>
            array(
                'name' => 'date_closed',
                'vname' => 'LBL_DATE_CLOSED',
                'type' => 'date',
                'audited' => true,
                'comment' => 'Expected or actual date the oppportunity will close',
                'importable' => 'required',
                'required' => true,
                'enable_range_search' => true,
                'options' => 'date_range_search_dom',
            ),
        'next_step' =>
            array(
                'name' => 'next_step',
                'vname' => 'LBL_NEXT_STEP',
                'type' => 'varchar',
                'len' => '100',
                'comment' => 'The next step in the sales process',
                'merge_filter' => 'enabled',
            ),
        'sales_stage' =>
            array(
                'name' => 'sales_stage',
                'vname' => 'LBL_SALES_STAGE',
                'type' => 'enum',
                'options' => 'sales_stage_dom',
                'len' => '255',
                'audited' => true,
                'comment' => 'Indication of progression towards closure',
                'merge_filter' => 'enabled',
                'importable' => 'required',
                'required' => true,
            ),
        'probability' =>
            array(
                'name' => 'probability',
                'vname' => 'LBL_PROBABILITY',
                'type' => 'int',
                'dbType' => 'double',
                'audited' => true,
                'comment' => 'The probability of closure',
                'validation' => array('type' => 'range', 'min' => 0, 'max' => 100),
                'merge_filter' => 'enabled',
            ),
        'accounts' =>
            array(
                'name' => 'accounts',
                'type' => 'link',
                'relationship' => 'accounts_opportunities',
                'source' => 'non-db',
                'link_type' => 'one',
                'module' => 'Accounts',
                'bean_name' => 'Account',
                'vname' => 'LBL_ACCOUNTS',
            ),
        'contacts' =>
            array(
                'name' => 'contacts',
                'type' => 'link',
                'relationship' => 'opportunities_contacts',
                'source' => 'non-db',
                'module' => 'Contacts',
                'bean_name' => 'Contact',
                'rel_fields' => array('contact_role' => array('type' => 'enum', 'options' => 'opportunity_relationship_type_dom')),
                'vname' => 'LBL_CONTACTS',
                'hide_history_contacts_emails' => true,
            ),
        'tasks' =>
            array(
                'name' => 'tasks',
                'type' => 'link',
                'relationship' => 'opportunity_tasks',
                'source' => 'non-db',
                'vname' => 'LBL_TASKS',
            ),
        'notes' =>
            array(
                'name' => 'notes',
                'type' => 'link',
                'relationship' => 'opportunity_notes',
                'source' => 'non-db',
                'vname' => 'LBL_NOTES',
            ),
        'meetings' =>
            array(
                'name' => 'meetings',
                'type' => 'link',
                'relationship' => 'opportunity_meetings',
                'source' => 'non-db',
                'vname' => 'LBL_MEETINGS',
            ),
        'calls' =>
            array(
                'name' => 'calls',
                'type' => 'link',
                'relationship' => 'opportunity_calls',
                'source' => 'non-db',
                'vname' => 'LBL_CALLS',
            ),
        'emails' =>
            array(
                'name' => 'emails',
                'type' => 'link',
                'relationship' => 'emails_opportunities_rel',/* reldef in emails */
                'source' => 'non-db',
                'vname' => 'LBL_EMAILS',
            ),
        'documents' =>
            array(
                'name' => 'documents',
                'type' => 'link',
                'relationship' => 'documents_opportunities',
                'source' => 'non-db',
                'vname' => 'LBL_DOCUMENTS_SUBPANEL_TITLE',
            ),

        'project' =>
            array(
                'name' => 'project',
                'type' => 'link',
                'relationship' => 'projects_opportunities',
                'source' => 'non-db',
                'vname' => 'LBL_PROJECTS',
            ),
        'leads' =>
            array(
                'name' => 'leads',
                'type' => 'link',
                'relationship' => 'opportunity_leads',
                'source' => 'non-db',
                'vname' => 'LBL_LEADS',
            ),

        'campaigns' => array(
            'name' => 'campaigns',
            'type' => 'link',
            'relationship' => 'opportunities_campaign',
            'module' => 'CampaignLog',
            'bean_name' => 'CampaignLog',
            'source' => 'non-db',
            'vname' => 'LBL_CAMPAIGNS',
            'reportable' => false
        ),

        'campaign_link' => array(
            'name' => 'campaign_link',
            'type' => 'link',
            'relationship' => 'opportunities_campaign',
            'vname' => 'LBL_CAMPAIGNS',
            'link_type' => 'one',
            'module' => 'Campaigns',
            'bean_name' => 'Campaign',
            'source' => 'non-db',
            'reportable' => false
        ),
        'currencies' =>
            array(
                'name' => 'currencies',
                'type' => 'link',
                'relationship' => 'opportunity_currencies',
                'source' => 'non-db',
                'vname' => 'LBL_CURRENCIES',
            ),
        'aos_quotes' =>
            array(
                'name' => 'aos_quotes',
                'vname' => 'LBL_AOS_QUOTES',
                'type' => 'link',
                'relationship' => 'opportunity_aos_quotes',
                'module' => 'AOS_Quotes',
                'bean_name' => 'AOS_Quotes',
                'source' => 'non-db',
            ),
        'aos_contracts' =>
            array(
                'name' => 'aos_contracts',
                'vname' => 'LBL_AOS_CONTRACTS',
                'type' => 'link',
                'relationship' => 'opportunity_aos_contracts',
                'module' => 'AOS_Contracts',
                'bean_name' => 'AOS_Contracts',
                'source' => 'non-db',
            ),
    ),
    'indices' => array(
        array(
            'name' => 'idx_opp_name',
            'type' => 'index',
            'fields' => array('name'),
        ),
        array(
            'name' => 'idx_opp_assigned',
            'type' => 'index',
            'fields' => array('assigned_user_id'),
        ),
        array(
            'name' => 'idx_opp_id_deleted',
            'type' => 'index',
            'fields' => array('id', 'deleted'),
        ),
    ),

    'relationships' => array(
        'opportunity_calls' => array('lhs_module' => 'Opportunities', 'lhs_table' => 'opportunities', 'lhs_key' => 'id',
            'rhs_module' => 'Calls', 'rhs_table' => 'calls', 'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many', 'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Opportunities')
    , 'opportunity_meetings' => array('lhs_module' => 'Opportunities', 'lhs_table' => 'opportunities', 'lhs_key' => 'id',
            'rhs_module' => 'Meetings', 'rhs_table' => 'meetings', 'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many', 'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Opportunities')
    , 'opportunity_tasks' => array('lhs_module' => 'Opportunities', 'lhs_table' => 'opportunities', 'lhs_key' => 'id',
            'rhs_module' => 'Tasks', 'rhs_table' => 'tasks', 'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many', 'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Opportunities')
    , 'opportunity_notes' => array('lhs_module' => 'Opportunities', 'lhs_table' => 'opportunities', 'lhs_key' => 'id',
            'rhs_module' => 'Notes', 'rhs_table' => 'notes', 'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many', 'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Opportunities')
    , 'opportunity_emails' => array('lhs_module' => 'Opportunities', 'lhs_table' => 'opportunities', 'lhs_key' => 'id',
            'rhs_module' => 'Emails', 'rhs_table' => 'emails', 'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many', 'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Opportunities')
    , 'opportunity_leads' => array('lhs_module' => 'Opportunities', 'lhs_table' => 'opportunities', 'lhs_key' => 'id',
            'rhs_module' => 'Leads', 'rhs_table' => 'leads', 'rhs_key' => 'opportunity_id',
            'relationship_type' => 'one-to-many')
    , 'opportunity_currencies' => array('lhs_module' => 'Opportunities', 'lhs_table' => 'opportunities', 'lhs_key' => 'currency_id',
            'rhs_module' => 'Currencies', 'rhs_table' => 'currencies', 'rhs_key' => 'id',
            'relationship_type' => 'one-to-many')
    , 'opportunities_assigned_user' =>
            array('lhs_module' => 'Users', 'lhs_table' => 'users', 'lhs_key' => 'id',
                'rhs_module' => 'Opportunities', 'rhs_table' => 'opportunities', 'rhs_key' => 'assigned_user_id',
                'relationship_type' => 'one-to-many')

    , 'opportunities_modified_user' =>
            array('lhs_module' => 'Users', 'lhs_table' => 'users', 'lhs_key' => 'id',
                'rhs_module' => 'Opportunities', 'rhs_table' => 'opportunities', 'rhs_key' => 'modified_user_id',
                'relationship_type' => 'one-to-many')

    , 'opportunities_created_by' =>
            array('lhs_module' => 'Users', 'lhs_table' => 'users', 'lhs_key' => 'id',
                'rhs_module' => 'Opportunities', 'rhs_table' => 'opportunities', 'rhs_key' => 'created_by',
                'relationship_type' => 'one-to-many'),
        'opportunities_campaign' =>
            array('lhs_module' => 'Campaigns', 'lhs_table' => 'campaigns', 'lhs_key' => 'id',
                'rhs_module' => 'Opportunities', 'rhs_table' => 'opportunities', 'rhs_key' => 'campaign_id',
                'relationship_type' => 'one-to-many'),
        'opportunity_aos_quotes' =>
            array(
                'lhs_module' => 'Opportunities',
                'lhs_table' => 'opportunities',
                'lhs_key' => 'id',
                'rhs_module' => 'AOS_Quotes',
                'rhs_table' => 'aos_quotes',
                'rhs_key' => 'opportunity_id',
                'relationship_type' => 'one-to-many',
            ),
        'opportunity_aos_contracts' =>
            array(
                'lhs_module' => 'Opportunities',
                'lhs_table' => 'opportunities',
                'lhs_key' => 'id',
                'rhs_module' => 'AOS_Contracts',
                'rhs_table' => 'aos_contracts',
                'rhs_key' => 'opportunity_id',
                'relationship_type' => 'one-to-many',
            ),
    )
//This enables optimistic locking for Saves From EditView
, 'optimistic_locking' => true,
);
VardefManager::createVardef('Opportunities', 'Opportunity', array('default', 'assignable', 'security_groups',
));
