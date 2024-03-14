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

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105 
$dashletData['OpportunitiesDashlet']['searchFields'] = array(
    'name' => 
      array (
        'default' => '',
      ),
      'stic_type_c' => 
      array (
        'default' => '',
      ),
      'stic_status_c' => 
      array (
        'default' => '',
      ),
      'account_name' => 
      array (
        'default' => '',
      ),
      'stic_target_c' => 
      array (
        'default' => '',
      ),
      'stic_presentation_date_c' => 
      array (
        'default' => '',
      ),
      'stic_resolution_date_c' => 
      array (
        'default' => '',
      ),
      'assigned_user_id' => 
      array (
        'default' => '',
      ),
);
$dashletData['OpportunitiesDashlet']['columns'] = array(
    'NAME' => 
    array (
      'width' => '30%',
      'label' => 'LBL_LIST_OPPORTUNITY_NAME',
      'link' => true,
      'default' => true,
    ),
    'STIC_STATUS_C' => 
    array (
      'type' => 'enum',
      'default' => true,
      'studio' => 'visible',
      'label' => 'LBL_STIC_STATUS',
      'width' => '10%',
    ),
    'ACCOUNT_NAME' => 
    array (
      'width' => '20%',
      'label' => 'LBL_LIST_ACCOUNT_NAME',
      'id' => 'ACCOUNT_ID',
      'module' => 'Accounts',
      'link' => true,
      'default' => true,
      'sortable' => true,
      'ACLTag' => 'ACCOUNT',
      'contextMenu' => 
      array (
        'objectType' => 'sugarAccount',
        'metaData' => 
        array (
          'return_module' => 'Contacts',
          'return_action' => 'ListView',
          'module' => 'Accounts',
          'parent_id' => '{$ACCOUNT_ID}',
          'parent_name' => '{$ACCOUNT_NAME}',
          'account_id' => '{$ACCOUNT_ID}',
          'account_name' => '{$ACCOUNT_NAME}',
        ),
      ),
      'related_fields' => 
      array (
        0 => 'account_id',
      ),
    ),
    'STIC_TYPE_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_TYPE',
      'width' => '10%',
    ),
    'STIC_TARGET_C' => 
    array (
      'type' => 'enum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_TARGET',
      'width' => '10%',
    ),
    'STIC_PRESENTATION_DATE_C' => 
    array (
      'type' => 'date',
      'default' => true,
      'label' => 'LBL_STIC_PRESENTATION_DATE',
      'width' => '10%',
    ),
    'STIC_RESOLUTION_DATE_C' => 
    array (
      'type' => 'date',
      'default' => true,
      'label' => 'LBL_STIC_RESOLUTION_DATE',
      'width' => '10%',
    ),
    'ASSIGNED_USER_NAME' => 
    array (
      'width' => '5%',
      'label' => 'LBL_LIST_ASSIGNED_USER',
      'module' => 'Employees',
      'id' => 'ASSIGNED_USER_ID',
      'default' => true,
    ),
    'STIC_AMOUNT_AWARDED_C' => 
    array (
      'type' => 'currency',
      'default' => false,
      'label' => 'LBL_STIC_AMOUNT_AWARDED',
      'currency_format' => true,
      'width' => '10%',
    ),
    'STIC_AMOUNT_RECEIVED_C' => 
    array (
      'type' => 'currency',
      'default' => false,
      'label' => 'LBL_STIC_AMOUNT_RECEIVED',
      'currency_format' => true,
      'width' => '10%',
    ),
    'STIC_JUSTIFICATION_DATE_C' => 
    array (
      'type' => 'date',
      'default' => false,
      'label' => 'LBL_STIC_JUSTIFICATION_DATE',
      'width' => '10%',
    ),
    'STIC_ADVANCE_DATE_C' => 
    array (
      'type' => 'date',
      'default' => false,
      'label' => 'LBL_STIC_ADVANCE_DATE',
      'width' => '10%',
    ),
    'STIC_PAYMENT_DATE_C' => 
    array (
      'type' => 'date',
      'default' => false,
      'label' => 'LBL_STIC_PAYMENT_DATE',
      'width' => '10%',
    ),
    'STIC_DOCUMENTATION_TO_DELIVER_C' => 
    array (
      'type' => 'multienum',
      'default' => false,
      'studio' => 'visible',
      'label' => 'LBL_STIC_DOCUMENTATION_TO_DELIVER',
      'width' => '10%',
    ),
    'PROJECT_OPPORTUNITIES_1_NAME' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_PROJECT_OPPORTUNITIES_1_FROM_PROJECT_TITLE',
      'id' => 'PROJECT_OPPORTUNITIES_1PROJECT_IDA',
      'width' => '10%',
      'default' => false,
    ),
    'CREATED_BY_NAME' => 
    array (
      'width' => '10%',
      'label' => 'LBL_CREATED',
      'default' => false,
    ),
    'DATE_ENTERED' => 
    array (
      'width' => '10%',
      'label' => 'LBL_DATE_ENTERED',
      'default' => false,
    ),
    'DATE_MODIFIED' => 
    array (
      'type' => 'datetime',
      'label' => 'LBL_DATE_MODIFIED',
      'width' => '10%',
      'default' => false,
    ),
    'MODIFIED_BY_NAME' => 
    array (
      'width' => '5%',
      'label' => 'LBL_MODIFIED',
      'default' => false,
    ),
);
// END STIC-Custom