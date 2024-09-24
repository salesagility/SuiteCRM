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

// STIC-Custom - JBL - 20240515 - Notify new Opportunities: New Campaign type (Notification)
// https://github.com/SinergiaTIC/SinergiaCRM/pull/44
$viewdefs['Campaigns']['QuickCreate'] = array (
  'templateMeta' => 
  array (
    'maxColumns' => '2',
    'widths' => 
    array (
      0 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
      1 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
    ),
    'useTabs' => false,
    'tabDefs' => 
    array (
      'LBL_CAMPAIGN_INFORMATION' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'lbl_campaign_information' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'name',
        ),
        1 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'campaign_type',
        ),
        1 => 
        array (
          'name' => 'status',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'start_date',
          'displayParams' => 
          array (
            'required' => false,
            'showFormats' => true,
          ),
        ),
        1 =>
        array (),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'content',
          'displayParams' => 
          array (
            'rows' => 2,
            'cols' => 80,
          ),
        ),
      ),
    ),
    'lbl_notification_information_panel' =>
    array (
      0 => array(
        0 => array(
          'name' => 'notification_prospect_list_ids',
          'label' => 'LBL_NOTIFICATION_PROSPECT_LIST_ID',
        ),
        1 => array(
          'name' => 'notification_template_id',
          'label' => 'LBL_NOTIFICATION_TEMPLATE_ID',
        ),
      ),
      1 => array(
        0 => array(
          'name' => 'notification_outbound_email_id',
          'label' => 'LBL_NOTIFICATION_OUTBOUND_EMAIL_ID',
        ),
        1 => array(
          'name' => 'notification_inbound_email_id',
          'label' => 'LBL_NOTIFICATION_INBOUND_EMAIL_ID',
        ),
      ),
      2 => array(
        0 => array(
          'name' => 'notification_from_name',
          'label' => 'LBL_NOTIFICATION_FROM_NAME',
        ),
        1 => array(
          'name' => 'notification_from_addr',
          'label' => 'LBL_NOTIFICATION_FROM_ADDR',
        ),
      ),
      3 => array(
        0 => array(
          'name' => 'notification_reply_to_name',
          'label' => 'LBL_NOTIFICATION_REPLY_TO_NAME',
        ),
        1 => array(
          'name' => 'notification_reply_to_addr',
          'label' => 'LBL_NOTIFICATION_REPLY_TO_ADDR',
        ),
      ),
    ),
  ),
);
// END STIC-Custom
