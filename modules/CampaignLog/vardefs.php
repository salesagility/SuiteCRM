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

$dictionary['CampaignLog'] = ['audited' => false,
    'comment' => 'Tracks items of interest that occurred after you send an email campaign',
    'table' => 'campaign_log',

    'fields' => [
        'id' => [
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => true,
            'comment' => 'Unique identifier'
        ],
        'campaign_id' => [
            'name' => 'campaign_id',
            'vname' => 'LBL_CAMPAIGN_ID',
            'type' => 'id',
            'comment' => 'Campaign identifier',
            'reportable' => false,
        ],
        'target_tracker_key' => [
            'name' => 'target_tracker_key',
            'vname' => 'LBL_TARGET_TRACKER_KEY',
            'type' => 'varchar',
            'len' => '36',
            'comment' => 'Identifier of Tracker URL',
            'reportable' => false,
        ],
        'target_id' => [
            'name' => 'target_id',
            'vname' => 'LBL_TARGET_ID',
            'type' => 'varchar',
            'len' => '36',
            'comment' => 'Identifier of target record',
            'reportable' => false,
        ],
        'target_type' => [
            'name' => 'target_type',
            'vname' => 'LBL_TARGET_TYPE',
            'type' => 'varchar',
            'len' => 100,
            'comment' => 'Descriptor of the target record type (e.g., Contact, Lead)'
        ],
        'activity_type' => [
            'name' => 'activity_type',
            'vname' => 'LBL_ACTIVITY_TYPE',
            'type' => 'enum',
            'options' => 'campainglog_activity_type_dom',
            'len' => 100,
            'comment' => 'The activity that occurred (e.g., Viewed Message, Bounced, Opted out)'
        ],
        'activity_date' => [
            'name' => 'activity_date',
            'vname' => 'LBL_ACTIVITY_DATE',
            'type' => 'datetime',
            'comment' => 'The date the activity occurred'
        ],
        'related_id' => [
            'name' => 'related_id',
            'vname' => 'LBL_RELATED_ID',
            'type' => 'varchar',
            'len' => '36',
            'reportable' => false,
        ],
        'related_type' => [
            'name' => 'related_type',
            'vname' => 'LBL_RELATED_TYPE',
            'type' => 'varchar',
            'len' => 100,
        ],
        'archived' => [
            'name' => 'archived',
            'vname' => 'LBL_ARCHIVED',
            'type' => 'bool',
            'reportable' => false,
            'default' => '0',
            'comment' => 'Indicates if item has been archived'
        ],
        'hits' => [
            'name' => 'hits',
            'vname' => 'LBL_HITS',
            'type' => 'int',
            'default' => '0',
            'reportable' => true,
            'comment' => 'Number of times the item has been invoked (e.g., multiple click-thrus)'
        ],
        'list_id' => [
            'name' => 'list_id',
            'vname' => 'LBL_LIST_ID',
            'type' => 'id',
            'reportable' => false,
            'len' => '36',
            'comment' => 'The target list from which item originated'
        ],
        'deleted' => [
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'reportable' => false,
            'comment' => 'Record deletion indicator'
        ],
        'recipient_name' => [
            'name' => 'recipient_name',
            'type' => 'varchar',
            'len' => '255',
            'source' => 'non-db',
        ],
        'recipient_email' => [
            'name' => 'recipient_email',
            'type' => 'varchar',
            'len' => '255',
            'source' => 'non-db',
        ],
        'marketing_name' => [
            'name' => 'marketing_name',
            'type' => 'varchar',
            'len' => '255',
            'source' => 'non-db',
        ],
        'campaign_name1' => [
            'name' => 'campaign_name1',
            'rname' => 'name',
            'id_name' => 'campaign_id',
            'vname' => 'LBL_CAMPAIGN_NAME',
            'type' => 'relate',
            'table' => 'campaigns',
            'isnull' => 'true',
            'module' => 'Campaigns',
            'dbType' => 'varchar',
            'link' => 'campaign',
            'len' => '255',
            'source' => 'non-db',
        ],
        'campaign_name' => [
            'name' => 'campaign_name',
            'type' => 'varchar',
            'len' => '255',
            'source' => 'non-db',
        ],
        'campaign_objective' => [
            'name' => 'campaign_objective',
            'type' => 'varchar',
            'len' => '255',
            'source' => 'non-db',
        ],
        'campaign_content' => [
            'name' => 'campaign_content',
            'type' => 'varchar',
            'len' => '255',
            'source' => 'non-db',
        ],
        'campaign' => [
            'name' => 'campaign',
            'type' => 'link',
            'relationship' => 'campaign_campaignlog',
            'source' => 'non-db',
            'vname' => 'LBL_CAMPAIGNS',
        ],
        'related_name' => [
            'source' => 'function',
            'function_name' => 'get_related_name',
            'function_class' => 'CampaignLog',
            'function_params' => ['related_id', 'related_type'],
            'function_params_source' => 'this',  //valid values are 'parent' or 'this' default is parent.
            'type' => 'function',
            'vname' => 'LBL_RELATED_NAME',
            'name' => 'related_name',
            'reportable' => false,
        ],
        'date_modified' => [
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
        ],
        'more_information' => [
            'name' => 'more_information',
            'vname' => 'LBL_MORE_INFO',
            'type' => 'varchar',
            'len' => '100',
        ],
        'marketing_id' => [
            'name' => 'marketing_id',
            'vname' => 'LBL_MARKETING_ID',
            'type' => 'id',
            'reportable' => false,
            'comment' => 'ID of marketing email this entry is associated with',
        ],
        'created_contact' => [
            'name' => 'created_contact',
            'vname' => 'LBL_CREATED_CONTACT',
            'type' => 'link',
            'relationship' => 'campaignlog_contact',
            'source' => 'non-db',
        ],
        'created_lead' => [
            'name' => 'created_lead',
            'vname' => 'LBL_CREATED_LEAD',
            'type' => 'link',
            'relationship' => 'campaignlog_lead',
            'source' => 'non-db',
        ],
        'created_opportunities' => [
            'name' => 'created_opportunities',
            'vname' => 'LBL_CREATED_OPPORTUNITY',
            'type' => 'link',
            'relationship' => 'campaignlog_created_opportunities',
            'source' => 'non-db',
        ],
        'targeted_user' => [
            'name' => 'targeted_user',
            'vname' => 'LBL_TARGETED_USER',
            'type' => 'link',
            'relationship' => 'campaignlog_targeted_users',
            'source' => 'non-db',
        ],
        'sent_email' => [
            'name' => 'sent_email',
            'vname' => 'LBL_SENT_EMAIL',
            'type' => 'link',
            'relationship' => 'campaignlog_sent_emails',
            'source' => 'non-db',
        ],
    ],
    'indices' => [
        [
            'name' => 'campaign_log_pk',

            'type' => 'primary',
            'fields' => ['id']
        ],
        [
            'name' => 'idx_camp_tracker',

            'type' => 'index',
            'fields' => ['target_tracker_key']
        ],

        [
            'name' => 'idx_camp_campaign_id',

            'type' => 'index',
            'fields' => ['campaign_id']
        ],

        [
            'name' => 'idx_camp_more_info',

            'type' => 'index',
            'fields' => ['more_information']
        ],
        [
            'name' => 'idx_target_id',

            'type' => 'index',
            'fields' => ['target_id']
        ],
        [
            'name' => 'idx_target_id_deleted',

            'type' => 'index',
            'fields' => ['target_id', 'deleted']
        ],
    ],
    'relationships' => [
        'campaignlog_contact' => ['lhs_module' => 'CampaignLog',
            'lhs_table' => 'campaign_log',
            'lhs_key' => 'related_id',
            'rhs_module' => 'Contacts',
            'rhs_table' => 'contacts',
            'rhs_key' => 'id',
            'relationship_type' => 'one-to-many'],
        'campaignlog_lead' => ['lhs_module' => 'CampaignLog',
            'lhs_table' => 'campaign_log',
            'lhs_key' => 'related_id',
            'rhs_module' => 'Leads',
            'rhs_table' => 'leads',
            'rhs_key' => 'id',
            'relationship_type' => 'one-to-many'],
        'campaignlog_created_opportunities' => [
            'lhs_module' => 'CampaignLog',
            'lhs_table' => 'campaign_log',
            'lhs_key' => 'related_id',
            'rhs_module' => 'Opportunities',
            'rhs_table' => 'opportunities',
            'rhs_key' => 'id',
            'relationship_type' => 'one-to-many'
        ],
        'campaignlog_targeted_users' => [
            'lhs_module' => 'CampaignLog',
            'lhs_table' => 'campaign_log',
            'lhs_key' => 'target_id',
            'rhs_module' => 'Users',
            'rhs_table' => 'users',
            'rhs_key' => 'id',
            'relationship_type' => 'one-to-many'
        ],
        'campaignlog_sent_emails' => [
            'lhs_module' => 'CampaignLog',
            'lhs_table' => 'campaign_log',
            'lhs_key' => 'related_id',
            'rhs_module' => 'Emails',
            'rhs_table' => 'emails',
            'rhs_key' => 'id',
            'relationship_type' => 'one-to-many'
        ],
    ]
];
