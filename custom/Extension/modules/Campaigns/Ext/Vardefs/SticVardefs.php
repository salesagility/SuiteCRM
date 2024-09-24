<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

$dictionary["Campaign"]["fields"]["stic_payment_commitments_campaigns"] = array(
    'name' => 'stic_payment_commitments_campaigns',
    'type' => 'link',
    'relationship' => 'stic_payment_commitments_campaigns',
    'source' => 'non-db',
    'module' => 'stic_Payment_Commitments',
    'bean_name' => 'stic_Payment_Commitments',
    'side' => 'right',
    'vname' => 'LBL_STIC_PAYMENT_COMMITMENTS_CAMPAIGNS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
);

// Fields for Campaign type Notification

// parent_name, parent_type and parent_id: The Parent element of the Notification 
$dictionary["Campaign"]["fields"]["parent_name"] = array(
    'name' => 'parent_name',
    'parent_type' => 'record_type_display',
    'type_name' => 'parent_type',
    'id_name' => 'parent_id',
    'vname' => 'LBL_FLEX_RELATE',
    'type' => 'parent',
    'group' => 'parent_name',
    'source' => 'non-db',
    'options' => 'parent_type_display_notifications', // Available Notification parent types
    'inline_edit' => 0,
    'studio' => 'visible',
    'popupHelp' => 'LBL_FLEX_RELATE_HELP',
);
$dictionary["Campaign"]["fields"]['parent_type'] = array(
    'name' => 'parent_type',
    'vname' => 'LBL_PARENT_TYPE',
    'type' => 'parent_type',
    'dbType' => 'varchar',
    'group' => 'parent_name',
    'options' => 'parent_type_display_notifications', // Available Notification parent types
    'len' => 255,
    'studio' => 'hidden',
    'source' => 'custom_fields',
);
$dictionary["Campaign"]["fields"]['parent_id'] = array(
    'name' => 'parent_id',
    'type' => 'id',
    'group' => 'parent_name',
    'reportable' => false,
    'vname' => 'LBL_PARENT_ID',
    'source' => 'custom_fields',
);

// The names of the selected Prospect Lists for the Notification (saved in db)
$dictionary["Campaign"]["fields"]['stic_notification_prospect_list_names_c'] = array(
    'name' => 'stic_notification_prospect_list_names_c',
    'vname' => 'stic_notification_prospect_list_names_c',
    'type' => 'varchar',
    'len' => '255',
    'source' => 'custom_fields',
);

// The related Prospect Lists to the Notification 
// In edit: Filled by user, used to create relationsiphs
// In detail: Filled from relationships
$dictionary["Campaign"]["fields"]['notification_prospect_list_ids'] = array(
    'name' => 'notification_prospect_list_ids',
    'vname' => 'LBL_NOTIFICATION_PROSPECT_LIST_ID',
    'type' => 'multienum',
    'massupdate' => 0,
    'no_default' => false,
    'module' => 'ProspectLists',
    'source' => 'non-db',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => '',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'dynamic_prospect_list_list',
    'dependency' => false,
    'popupHelp' => 'LBL_NOTIFICATION_PROSPECT_LIST_ID_HELP',
);

// These fields are from the EmailMarketing related to the Notification 
// In edit: Filled by user, used to assign in the related EmailMarketing
// In detail: Filled from the related EmailMarketing data
$dictionary["Campaign"]["fields"]['notification_template_id'] = array(
    'name' => 'notification_template_id',
    'vname' => 'LBL_NOTIFICATION_TEMPLATE_ID',
    'type' => 'enum',
    'massupdate' => 0,
    'no_default' => false,
    'source' => 'non-db',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => '',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'dynamic_email_template_list',
    'dependency' => false,
    'popupHelp' => 'LBL_NOTIFICATION_TEMPLATE_ID_HELP',
);
$dictionary["Campaign"]["fields"]['notification_email_template_name'] = array(
    'name' => 'notification_email_template_name',
    'vname' => 'LBL_NOTIFICATION_EMAIL_TEMPLATE_NAME',
    'type' => 'varchar',
    'len' => '255',
    'source' => 'non-db',
);
$dictionary["Campaign"]["fields"]['notification_outbound_email_id'] = array(
    'name' => 'notification_outbound_email_id',
    'vname' => 'LBL_NOTIFICATION_OUTBOUND_EMAIL_ID',
    'type' => 'enum',
    'source' => 'non-db',
    'isnull' => true,
    'options' => 'dynamic_outbound_email_list',
    'popupHelp' => 'LBL_NOTIFICATION_OUTBOUND_EMAIL_ID_HELP',
);
$dictionary["Campaign"]["fields"]['notification_inbound_email_id'] = array(
    'name' => 'notification_inbound_email_id',
    'vname' => 'LBL_NOTIFICATION_INBOUND_EMAIL_ID',
    'type' => 'enum',
    'source' => 'non-db',
    'isnull' => true,
    'options' => 'dynamic_inbound_email_list',
    'popupHelp' => 'LBL_NOTIFICATION_INBOUND_EMAIL_ID_HELP',
);
$dictionary["Campaign"]["fields"]['notification_from_name'] = array(
    'name' => 'notification_from_name',
    'vname' => 'LBL_NOTIFICATION_FROM_NAME',
    'type' => 'varchar',
    'len' => '100',
    'source' => 'non-db',
);
$dictionary["Campaign"]["fields"]['notification_from_addr'] = array(
    'name' => 'notification_from_addr',
    'vname' => 'LBL_NOTIFICATION_FROM_ADDR',
    'type' => 'varchar',
    'source' => 'non-db',
    'len' => '100',
);
$dictionary["Campaign"]["fields"]['notification_reply_to_name'] = array(
    'name' => 'notification_reply_to_name',
    'vname' => 'LBL_NOTIFICATION_REPLY_TO_NAME',
    'type' => 'varchar',
    'source' => 'non-db',
    'len' => '100',
);
$dictionary["Campaign"]["fields"]['notification_reply_to_addr'] = array(
    'name' => 'notification_reply_to_addr',
    'vname' => 'LBL_NOTIFICATION_REPLY_TO_ADDR',
    'type' => 'varchar',
    'source' => 'non-db',
    'len' => '100',
);

$dictionary['Campaign']['fields']['campaign_type']['inline_edit'] = false;

$dictionary['Campaign']['fields']['end_date']['required'] = false;

$dictionary['Campaign']['fields']['budget']['massupdate'] = 0;
$dictionary['Campaign']['fields']['actual_cost']['massupdate'] = 0;
$dictionary['Campaign']['fields']['actual_revenue']['massupdate'] = 0;
$dictionary['Campaign']['fields']['expected_revenue']['massupdate'] = 0;
$dictionary['Campaign']['fields']['expected_cost']['massupdate'] = 0;
$dictionary['Campaign']['fields']['refer_url']['massupdate'] = 0;
$dictionary['Campaign']['fields']['tracker_text']['massupdate'] = 0;
$dictionary['Campaign']['fields']['objective']['massupdate'] = 0;
$dictionary['Campaign']['fields']['content']['massupdate'] = 0;

// Enabling massupdate for core fields
// STIC#981
$dictionary['Campaign']['fields']['start_date']['massupdate'] = 1;
$dictionary['Campaign']['fields']['end_date']['massupdate'] = 1;
$dictionary['Campaign']['fields']['status']['massupdate'] = 1;
$dictionary['Campaign']['fields']['campaign_type']['massupdate'] = 1;
$dictionary['Campaign']['fields']['frequency']['massupdate'] = 1;

$dictionary['Campaign']['unified_search_default_enabled'] = true;
