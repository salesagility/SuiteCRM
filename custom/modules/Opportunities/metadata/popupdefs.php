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
$popupMeta = array (
    'moduleMain' => 'Opportunity',
    'varName' => 'OPPORTUNITY',
    'orderBy' => 'name',
    'whereClauses' => array (
  'name' => 'opportunities.name',
  'account_name' => 'accounts.name',
),
    'searchInputs' => array (
  0 => 'name',
  1 => 'account_name',
),
    'searchdefs' => array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'stic_type_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_STIC_TYPE',
        'width' => '10%',
        'name' => 'stic_type_c',
      ),
      'stic_status_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_STIC_STATUS',
        'width' => '10%',
        'name' => 'stic_status_c',
      ),
      'account_name' => 
      array (
        'name' => 'account_name',
        'default' => true,
        'width' => '10%',
      ),
      'stic_target_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_STIC_TARGET',
        'width' => '10%',
        'name' => 'stic_target_c',
      ),
      'stic_presentation_date_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_STIC_PRESENTATION_DATE',
        'width' => '10%',
        'name' => 'stic_presentation_date_c',
      ),
      'stic_resolution_date_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_STIC_RESOLUTION_DATE',
        'width' => '10%',
        'name' => 'stic_resolution_date_c',
      ),
      'stic_payment_date_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_STIC_PAYMENT_DATE',
        'width' => '10%',
        'name' => 'stic_payment_date_c',
      ),
      'stic_justification_date_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_STIC_JUSTIFICATION_DATE',
        'width' => '10%',
        'name' => 'stic_justification_date_c',
      ),
      'stic_advance_date_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_STIC_ADVANCE_DATE',
        'width' => '10%',
        'name' => 'stic_advance_date_c',
      ),
      'stic_amount_received_c' => 
      array (
        'type' => 'currency',
        'default' => true,
        'label' => 'LBL_STIC_AMOUNT_RECEIVED',
        'currency_format' => true,
        'width' => '10%',
        'name' => 'stic_amount_received_c',
      ),
      'stic_amount_awarded_c' => 
      array (
        'type' => 'currency',
        'default' => true,
        'label' => 'LBL_STIC_AMOUNT_AWARDED',
        'currency_format' => true,
        'width' => '10%',
        'name' => 'stic_amount_awarded_c',
      ),
      'project_opportunities_1_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_PROJECT_OPPORTUNITIES_1_FROM_PROJECT_TITLE',
        'id' => 'PROJECT_OPPORTUNITIES_1PROJECT_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'project_opportunities_1_name',
      ),
      'stic_documentation_to_deliver_c' => 
      array (
        'type' => 'multienum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_STIC_DOCUMENTATION_TO_DELIVER',
        'width' => '10%',
        'name' => 'stic_documentation_to_deliver_c',
      ),
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_TO',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'default' => true,
        'width' => '10%',
      ),
      'created_by' => 
      array (
        'type' => 'assigned_user_name',
        'label' => 'LBL_CREATED',
        'width' => '10%',
        'default' => true,
        'name' => 'created_by',
      ),
      'date_entered' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
      ),
      'modified_user_id' => 
      array (
        'type' => 'assigned_user_name',
        'label' => 'LBL_MODIFIED',
        'width' => '10%',
        'default' => true,
        'name' => 'modified_user_id',
      ),
      'date_modified' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_modified',
      ),
      'current_user_only' => 
      array (
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
        'name' => 'current_user_only',
      ),
      'favorites_only' => 
      array (
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
        'name' => 'favorites_only',
      ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => '30%',
    'label' => 'LBL_LIST_OPPORTUNITY_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'STIC_TYPE_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STIC_TYPE',
    'width' => '10%',
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
    'default' => true,
    'sortable' => true,
    'ACLTag' => 'ACCOUNT',
    'name' => 'account_name',
  ),
  'STIC_TARGET_C' => 
  array (
    'type' => 'enum',
    'default' => true,
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
    'default' => true,
    'name' => 'assigned_user_name',
  ),
),
);
