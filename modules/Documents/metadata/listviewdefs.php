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
// $listViewDefs['Documents'] = array(
//   'DOCUMENT_NAME' =>
//   array(
//     'width' => '20%',
//     'label' => 'LBL_NAME',
//     'link' => true,
//     'default' => true,
//     'bold' => true,
//   ),
//   'FILENAME' =>
//   array(
//     'width' => '20%',
//     'label' => 'LBL_FILENAME',
//     'link' => true,
//     'default' => true,
//     'bold' => false,
//     'displayParams' => array( 'module' => 'Documents', ),
//     'sortable' => false,
//     'related_fields' =>
//     array(
//         0 => 'document_revision_id',
//         1 => 'doc_id',
//         2 => 'doc_type',
//         3 => 'doc_url',
//     ),
//   ),
//   'CATEGORY_ID' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_LIST_CATEGORY',
//     'default' => true,
//   ),
//   'SUBCATEGORY_ID' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_LIST_SUBCATEGORY',
//     'default' => true,
//   ),
//   'LAST_REV_CREATE_DATE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_LIST_LAST_REV_DATE',
//     'default' => true,
//     'sortable' => false,
//     'related_fields' =>
//     array(
//       0 => 'document_revision_id',
//     ),
//   ),
//   'EXP_DATE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_LIST_EXP_DATE',
//     'default' => true,
//   ),
//   'ASSIGNED_USER_NAME' =>
//   array(
//     'width' => '10',
//     'label' => 'LBL_LIST_ASSIGNED_USER',
//     'module' => 'Employees',
//     'id' => 'ASSIGNED_USER_ID',
//     'default' => true),
//   'MODIFIED_BY_NAME' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_MODIFIED_USER',
//     'module' => 'Users',
//     'id' => 'USERS_ID',
//     'default' => false,
//     'sortable' => false,
//     'related_fields' =>
//     array(
//       0 => 'modified_user_id',
//     ),
//     ),
//   'DATE_ENTERED' => array(
//     'width' => '10%',
//     'label' => 'LBL_DATE_ENTERED',
//     'default' => true,
//   )
// );

$listViewDefs['Documents'] = array (
  'DOCUMENT_NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_NAME',
    'link' => true,
    'default' => true,
    'bold' => true,
  ),
  'FILENAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_FILENAME',
    'link' => true,
    'default' => true,
    'bold' => false,
    'displayParams' => 
    array (
      'module' => 'Documents',
    ),
    'sortable' => false,
    'related_fields' => 
    array (
      0 => 'document_revision_id',
      1 => 'doc_id',
      2 => 'doc_type',
      3 => 'doc_url',
    ),
  ),
  'STATUS_ID' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_DOC_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'STIC_SHARED_DOCUMENT_LINK_C' => 
  array (
    'type' => 'url',
    'default' => true,
    'label' => 'LBL_STIC_SHARED_DOCUMENT_LINK',
    'width' => '10%',
  ),
  'CATEGORY_ID' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_CATEGORY',
    'default' => false,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_DOC_STATUS',
    'width' => '10%',
    'default' => false,
  ),
  'STIC_SESSIONS_DOCUMENTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_SESSIONS_DOCUMENTS_FROM_STIC_SESSIONS_TITLE',
    'id' => 'STIC_SESSIONS_DOCUMENTSSTIC_SESSIONS_IDA',
    'width' => '10%',
    'default' => false,
  ),
  'SELECTED_REVISION_FILENAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SELECTED_REVISION_FILENAME',
    'width' => '10%',
    'default' => false,
  ),
  'LATEST_REVISION_ID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LATEST_REVISION_ID',
    'width' => '10%',
    'default' => false,
  ),
  'SELECTED_REVISION_ID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SELECTED_REVISION_ID',
    'width' => '10%',
    'default' => false,
  ),
  'SUBCATEGORY_ID' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_SUBCATEGORY',
    'default' => false,
  ),
  'LINKED_ID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LINKED_ID',
    'width' => '10%',
    'default' => false,
  ),
  'LAST_REV_CREATE_DATE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_LAST_REV_DATE',
    'default' => false,
    'sortable' => false,
    'related_fields' => 
    array (
      0 => 'document_revision_id',
    ),
  ),
  'CONTRACT_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CONTRACT_NAME',
    'width' => '10%',
    'default' => false,
  ),
  'EXP_DATE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_EXP_DATE',
    'default' => false,
  ),
  'CONTRACT_STATUS' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CONTRACT_STATUS',
    'width' => '10%',
    'default' => false,
  ),
  'SELECTED_REVISION_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SELECTED_REVISION_NAME',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
  ),
  'LATEST_REVISION_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LASTEST_REVISION_NAME',
    'width' => '10%',
    'default' => false,
  ),
  'TEMPLATE_TYPE' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_TEMPLATE_TYPE',
    'width' => '10%',
    'default' => false,
  ),
  'IS_TEMPLATE' => 
  array (
    'type' => 'bool',
    'default' => false,
    'label' => 'LBL_IS_TEMPLATE',
    'width' => '10%',
  ),
  'RELATED_DOC_REV_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_DET_RELATED_DOCUMENT_VERSION',
    'width' => '10%',
    'default' => false,
  ),
  'RELATED_DOC_NAME' => 
  array (
    'type' => 'relate',
    'label' => 'LBL_DET_RELATED_DOCUMENT',
    'id' => 'RELATED_DOC_ID',
    'link' => true,
    'width' => '10%',
    'default' => false,
  ),
  'LATEST_REVISION' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LATEST_REVISION',
    'width' => '10%',
    'default' => false,
  ),
  'LAST_REV_CREATED_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LAST_REV_CREATOR',
    'width' => '10%',
    'default' => false,
  ),
  'REVISION' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'label' => 'LBL_DOC_VERSION',
    'width' => '10%',
  ),
  'DOCUMENT_REVISION_ID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LATEST_REVISION',
    'width' => '10%',
    'default' => false,
  ),
  'ACTIVE_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DOC_ACTIVE_DATE',
    'width' => '10%',
    'default' => false,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
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
    'width' => '10%',
    'label' => 'LBL_MODIFIED_USER',
    'module' => 'Users',
    'id' => 'USERS_ID',
    'default' => false,
    'sortable' => false,
    'related_fields' => 
    array (
      0 => 'modified_user_id',
    ),
  ),
);
// END STIC-Custom