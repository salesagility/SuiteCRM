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
