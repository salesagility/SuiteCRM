<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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
// $listViewDefs ['Leads'] =
// array(
//   'NAME' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_LIST_NAME',
//     'link' => true,
//     'orderBy' => 'name',
//     'default' => true,
//     'related_fields' =>
//     array(
//       0 => 'first_name',
//       1 => 'last_name',
//       2 => 'salutation',
//     ),
//   ),
//   'STATUS' =>
//   array(
//     'width' => '7%',
//     'label' => 'LBL_LIST_STATUS',
//     'default' => true,
//   ),
//   'ACCOUNT_NAME' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_LIST_ACCOUNT_NAME',
//     'default' => true,
//     'related_fields' =>
//     array(
//       0 => 'account_id',
//     ),
//   ),
//   'PHONE_WORK' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_LIST_PHONE',
//     'default' => true,
//   ),
//   'EMAIL1' =>
//   array(
//     'width' => '16%',
//     'label' => 'LBL_LIST_EMAIL_ADDRESS',
//     'sortable' => false,
//     'customCode' => '{$EMAIL1_LINK}',
//     'default' => true,
//   ),
//   'ASSIGNED_USER_NAME' =>
//   array(
//     'width' => '5%',
//     'label' => 'LBL_LIST_ASSIGNED_USER',
//     'module' => 'Employees',
//     'id' => 'ASSIGNED_USER_ID',
//     'default' => true,
//   ),
//   'TITLE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_TITLE',
//     'default' => false,
//   ),
//   'REFERED_BY' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_REFERED_BY',
//     'default' => false,
//   ),
//   'LEAD_SOURCE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_LEAD_SOURCE',
//     'default' => false,
//   ),
//   'DEPARTMENT' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_DEPARTMENT',
//     'default' => false,
//   ),
//   'DO_NOT_CALL' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_DO_NOT_CALL',
//     'default' => false,
//   ),
//   'PHONE_HOME' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_HOME_PHONE',
//     'default' => false,
//   ),
//   'PHONE_MOBILE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_MOBILE_PHONE',
//     'default' => false,
//   ),
//   'PHONE_OTHER' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_OTHER_PHONE',
//     'default' => false,
//   ),
//   'PHONE_FAX' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_FAX_PHONE',
//     'default' => false,
//   ),
//   'PRIMARY_ADDRESS_COUNTRY' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
//     'default' => false,
//   ),
//   'PRIMARY_ADDRESS_STREET' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_PRIMARY_ADDRESS_STREET',
//     'default' => false,
//   ),
//   'PRIMARY_ADDRESS_CITY' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_PRIMARY_ADDRESS_CITY',
//     'default' => false,
//   ),
//   'PRIMARY_ADDRESS_STATE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_PRIMARY_ADDRESS_STATE',
//     'default' => false,
//   ),
//   'PRIMARY_ADDRESS_POSTALCODE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
//     'default' => false,
//   ),
//   'ALT_ADDRESS_COUNTRY' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_ALT_ADDRESS_COUNTRY',
//     'default' => false,
//   ),
//   'ALT_ADDRESS_STREET' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_ALT_ADDRESS_STREET',
//     'default' => false,
//   ),
//   'ALT_ADDRESS_CITY' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_ALT_ADDRESS_CITY',
//     'default' => false,
//   ),
//   'ALT_ADDRESS_STATE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_ALT_ADDRESS_STATE',
//     'default' => false,
//   ),
//   'ALT_ADDRESS_POSTALCODE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_ALT_ADDRESS_POSTALCODE',
//     'default' => false,
//   ),
//   'CREATED_BY' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_CREATED',
//     'default' => false,
//   ),
//   'MODIFIED_BY_NAME' =>
//   array(
//     'width' => '5%',
//     'label' => 'LBL_MODIFIED',
//     'default' => false,
//   ),
//   'DATE_ENTERED' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_DATE_ENTERED',
//     'default' => true,
//   ),
// );

$listViewDefs['Leads'] = array (
  'NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'orderBy' => 'name',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'first_name',
      1 => 'last_name',
      2 => 'salutation',
    ),
  ),
  'STATUS' => 
  array (
    'width' => '7%',
    'label' => 'LBL_LIST_STATUS',
    'default' => true,
  ),
  'EMAIL1' => 
  array (
    'width' => '16%',
    'label' => 'LBL_LIST_EMAIL_ADDRESS',
    'sortable' => false,
    'customCode' => '{$EMAIL1_LINK}',
    'default' => true,
  ),
  'PHONE_MOBILE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_MOBILE_PHONE',
    'default' => true,
  ),
  'PHONE_HOME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_HOME_PHONE',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '5%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'FIRST_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_FIRST_NAME',
    'width' => '10%',
    'default' => false,
  ),
  'LAST_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LAST_NAME',
    'width' => '10%',
    'default' => false,
  ),
  'STIC_IDENTIFICATION_TYPE_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_IDENTIFICATION_TYPE',
    'width' => '10%',
  ),
  'STIC_IDENTIFICATION_NUMBER_C' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_IDENTIFICATION_NUMBER',
    'width' => '10%',
  ),
  'STIC_LANGUAGE_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_LANGUAGE',
    'width' => '10%',
  ),
  'STIC_GENDER_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_GENDER',
    'width' => '10%',
  ),
  'STIC_ACQUISITION_CHANNEL_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_ACQUISITION_CHANNEL',
    'width' => '10%',
  ),
  'STIC_REFERRAL_AGENT_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_REFERRAL_AGENT',
    'width' => '10%',
  ),
  'LEAD_SOURCE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LEAD_SOURCE',
    'default' => false,
  ),
  'ACCOUNT_NAME' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'default' => false,
    'related_fields' => 
    array (
      0 => 'account_id',
    ),
  ),
  'STIC_EMPLOYMENT_STATUS_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_EMPLOYMENT_STATUS',
    'width' => '10%',
  ),
  'STIC_PROFESSIONAL_SECTOR_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_PROFESSIONAL_SECTOR',
    'width' => '10%',
  ),
  'STIC_PROFESSIONAL_SECTOR_OTHER_C' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_PROFESSIONAL_SECTOR_OTHER',
    'width' => '10%',
  ),
  'TITLE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_TITLE',
    'default' => false,
  ),
  'DEPARTMENT' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DEPARTMENT',
    'default' => false,
  ),
  'PRIMARY_ADDRESS_POSTALCODE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
    'default' => false,
  ),
  'STIC_PRIMARY_ADDRESS_TYPE_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_PRIMARY_ADDRESS_TYPE',
    'width' => '10%',
  ),
  'STIC_PRIMARY_ADDRESS_COUNTY_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_PRIMARY_ADDRESS_COUNTY',
    'width' => '10%',
  ),
  'STIC_PRIMARY_ADDRESS_REGION_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_PRIMARY_ADDRESS_REGION',
    'width' => '10%',
  ),
  'PRIMARY_ADDRESS_CITY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRIMARY_ADDRESS_CITY',
    'default' => false,
  ),
  'PRIMARY_ADDRESS_COUNTRY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
    'default' => false,
  ),
  'PRIMARY_ADDRESS_STREET' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRIMARY_ADDRESS_STREET',
    'default' => false,
  ),
  'PRIMARY_ADDRESS_STATE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRIMARY_ADDRESS_STATE',
    'default' => false,
  ),
  'DO_NOT_CALL' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DO_NOT_CALL',
    'default' => false,
  ),
  'STIC_DO_NOT_SEND_POSTAL_MAIL_C' => 
  array (
    'type' => 'bool',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_DO_NOT_SEND_POSTAL_MAIL',
    'width' => '10%',
  ),
  'STIC_POSTAL_MAIL_RETURN_REASON_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_POSTAL_MAIL_RETURN_REASON',
    'width' => '10%',
  ),
  'LAWFUL_BASIS' => 
  array (
    'type' => 'multienum',
    'label' => 'LBL_LAWFUL_BASIS',
    'width' => '10%',
    'default' => false,
  ),
  'LAWFUL_BASIS_SOURCE' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_LAWFUL_BASIS_SOURCE',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_REVIEWED' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DATE_REVIEWED',
    'width' => '10%',
    'default' => false,
  ),
  'CAMPAIGN_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CAMPAIGN',
    'id' => 'CAMPAIGN_ID',
    'width' => '10%',
    'default' => false,
  ),
  'CREATED_BY' => 
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
  'MODIFIED_BY_NAME' => 
  array (
    'width' => '5%',
    'label' => 'LBL_MODIFIED',
    'default' => false,
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => false,
  ),
);
// END STIC-Custom