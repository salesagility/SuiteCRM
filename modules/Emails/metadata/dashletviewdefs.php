<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $current_user;

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105 
// $dashletData['EmailsDashlet']['searchFields'] = array(
//     'date_entered' => array('default' => ''),
//     'date_modified' => array('default' => ''),
//     'assigned_user_id' => array(
//         'type' => 'assigned_user_name',
//         'default' => $current_user->name
//     )
// );
// $dashletData['EmailsDashlet']['columns'] = array(
//     'name' => array(
//         'width' => '40',
//         'label' => 'LBL_LIST_NAME',
//         'link' => true,
//         'default' => true
//     ),
//     'date_entered' => array(
//         'width' => '15',
//         'label' => 'LBL_DATE_ENTERED',
//         'default' => true
//     ),
//     'date_modified' => array(
//         'width' => '15',
//         'label' => 'LBL_DATE_MODIFIED'
//     ),
//     'created_by' => array(
//         'width' => '8',
//         'label' => 'LBL_CREATED'
//     ),
//     'assigned_user_name' => array(
//         'width' => '8',
//         'label' => 'LBL_LIST_ASSIGNED_USER'
//     ),
// );

$dashletData['EmailsDashlet']['searchFields'] = array (
    'date_entered' => 
    array (
      'default' => '',
    ),
    'date_modified' => 
    array (
      'default' => '',
    ),
    'assigned_user_id' => 
    array (
      'type' => 'assigned_user_name',
      'default' => 'Administrator',
    ),
  );
  $dashletData['EmailsDashlet']['columns'] = array (
    'indicator' => 
    array (
      'type' => 'function',
      'studio' => 'visible',
      'label' => 'LBL_INDICATOR',
      'width' => '10%',
      'default' => true,
      'name' => 'indicator',
    ),
    'subject' => 
    array (
      'type' => 'function',
      'studio' => 'visible',
      'label' => 'LBL_SUBJECT',
      'width' => '10%',
      'default' => true,
      'name' => 'subject',
    ),
    'date_sent_received' => 
    array (
      'type' => 'datetime',
      'label' => 'LBL_DATE_SENT_RECEIVED',
      'width' => '10%',
      'default' => true,
      'name' => 'date_sent_received',
    ),
    'category_id' => 
    array (
      'type' => 'enum',
      'label' => 'LBL_CATEGORY',
      'width' => '10%',
      'default' => true,
      'name' => 'category_id',
    ),
    'assigned_user_name' => 
    array (
      'width' => '8%',
      'label' => 'LBL_LIST_ASSIGNED_USER',
      'name' => 'assigned_user_name',
      'default' => true,
    ),
    'type' => 
    array (
      'type' => 'enum',
      'label' => 'LBL_LIST_TYPE',
      'width' => '10%',
      'default' => false,
      'name' => 'type',
    ),
    'from_addr_name' => 
    array (
      'type' => 'varchar',
      'label' => 'from_addr_name',
      'width' => '10%',
      'default' => false,
      'name' => 'from_addr_name',
    ),
    'reply_to_addr' => 
    array (
      'type' => 'varchar',
      'label' => 'reply_to_addr',
      'width' => '10%',
      'default' => false,
      'name' => 'reply_to_addr',
    ),
    'to_addrs_names' => 
    array (
      'type' => 'varchar',
      'label' => 'to_addrs_names',
      'width' => '10%',
      'default' => false,
      'name' => 'to_addrs_names',
    ),
    'cc_addrs_names' => 
    array (
      'type' => 'varchar',
      'label' => 'cc_addrs_names',
      'width' => '10%',
      'default' => false,
      'name' => 'cc_addrs_names',
    ),
    'bcc_addrs_names' => 
    array (
      'type' => 'varchar',
      'label' => 'bcc_addrs_names',
      'width' => '10%',
      'default' => false,
      'name' => 'bcc_addrs_names',
    ),
    'imap_keywords' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_IMAP_KEYWORDS',
      'width' => '10%',
      'default' => false,
      'name' => 'imap_keywords',
    ),
    'emails_email_templates_name' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_EMAIL_TEMPLATE',
      'id' => 'EMAILS_EMAIL_TEMPLATES_IDB',
      'width' => '10%',
      'default' => false,
      'name' => 'emails_email_templates_name',
    ),
    'name' => 
    array (
      'width' => '40%',
      'label' => 'LBL_LIST_NAME',
      'link' => true,
      'default' => false,
      'name' => 'name',
    ),
    'is_imported' => 
    array (
      'type' => 'varchar',
      'label' => 'is_imported',
      'width' => '10%',
      'default' => false,
      'name' => 'is_imported',
    ),
    'has_attachment' => 
    array (
      'type' => 'function',
      'studio' => 'visible',
      'label' => 'LBL_HAS_ATTACHMENT_INDICATOR',
      'width' => '10%',
      'default' => false,
      'name' => 'has_attachment',
    ),
    'is_only_plain_text' => 
    array (
      'type' => 'bool',
      'default' => false,
      'label' => 'is_only_plain_text',
      'width' => '10%',
      'name' => 'is_only_plain_text',
    ),
    'last_synced' => 
    array (
      'type' => 'datetime',
      'label' => 'LBL_LAST_SYNCED',
      'width' => '10%',
      'default' => false,
      'name' => 'last_synced',
    ),
    'status' => 
    array (
      'type' => 'enum',
      'label' => 'LBL_STATUS',
      'width' => '10%',
      'default' => false,
      'name' => 'status',
    ),
    'reply_to_status' => 
    array (
      'type' => 'bool',
      'label' => 'LBL_EMAIL_REPLY_TO_STATUS',
      'width' => '10%',
      'default' => false,
      'name' => 'reply_to_status',
    ),
    'description' => 
    array (
      'type' => 'text',
      'label' => 'description',
      'sortable' => false,
      'width' => '10%',
      'default' => false,
      'name' => 'description',
    ),
    'created_by' => 
    array (
      'width' => '8%',
      'label' => 'LBL_CREATED',
      'name' => 'created_by',
      'default' => false,
    ),
    'date_entered' => 
    array (
      'width' => '15%',
      'label' => 'LBL_DATE_ENTERED',
      'default' => false,
      'name' => 'date_entered',
    ),
    'modified_by_name' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_MODIFIED_NAME',
      'id' => 'MODIFIED_USER_ID',
      'width' => '10%',
      'default' => false,
      'name' => 'modified_by_name',
    ),
    'date_modified' => 
    array (
      'width' => '15%',
      'label' => 'LBL_DATE_MODIFIED',
      'name' => 'date_modified',
      'default' => false,
    ),
);  
// END STIC-Custom