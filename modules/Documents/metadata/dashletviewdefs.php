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
$dashletData['DocumentsDashlet']['searchFields'] = array (
    'date_entered' => 
    array (
      'default' => '',
    ),
    'filename' => 
    array (
      'default' => '',
    ),
    'status_id' => 
    array (
      'default' => '',
    ),
    'active_date' => 
    array (
      'default' => '',
    ),
    'stic_shared_document_link_c' => 
    array (
      'default' => '',
    ),
    'assigned_user_id' => 
    array (
      'default' => '',
    ),
  );
  $dashletData['DocumentsDashlet']['columns'] = array (
    'document_name' => 
    array (
      'width' => '40%',
      'label' => 'LBL_NAME',
      'link' => true,
      'default' => true,
      'name' => 'document_name',
    ),
    'filename' => 
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
      'related_fields' => 
      array (
        0 => 'document_revision_id',
        1 => 'doc_id',
        2 => 'doc_type',
        3 => 'doc_url',
      ),
      'name' => 'filename',
    ),
    'status_id' => 
    array (
      'width' => '8%',
      'label' => 'LBL_STATUS',
      'default' => true,
      'name' => 'status_id',
    ),
    'category_id' => 
    array (
      'width' => '8%',
      'label' => 'LBL_CATEGORY',
      'default' => false,
      'name' => 'category_id',
    ),
    'stic_shared_document_link_c' => 
    array (
      'type' => 'url',
      'default' => true,
      'label' => 'LBL_STIC_SHARED_DOCUMENT_LINK',
      'width' => '10%',
      'name' => 'stic_shared_document_link_c',
    ),
    'assigned_user_name' => 
    array (
      'width' => '8%',
      'label' => 'LBL_LIST_ASSIGNED_USER',
      'name' => 'assigned_user_name',
      'default' => true,
    ),
    'contract_status' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_CONTRACT_STATUS',
      'width' => '10%',
      'default' => false,
    ),
    'latest_revision_name' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_LASTEST_REVISION_NAME',
      'width' => '10%',
      'default' => false,
    ),
    'stic_sessions_documents_name' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_STIC_SESSIONS_DOCUMENTS_FROM_STIC_SESSIONS_TITLE',
      'id' => 'STIC_SESSIONS_DOCUMENTSSTIC_SESSIONS_IDA',
      'width' => '10%',
      'default' => false,
    ),
    'selected_revision_filename' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_SELECTED_REVISION_FILENAME',
      'width' => '10%',
      'default' => false,
    ),
    'latest_revision_id' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_LATEST_REVISION_ID',
      'width' => '10%',
      'default' => false,
    ),
    'selected_revision_id' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_SELECTED_REVISION_ID',
      'width' => '10%',
      'default' => false,
    ),
    'linked_id' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_LINKED_ID',
      'width' => '10%',
      'default' => false,
    ),
    'contract_name' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_CONTRACT_NAME',
      'width' => '10%',
      'default' => false,
    ),
    'selected_revision_name' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_SELECTED_REVISION_NAME',
      'width' => '10%',
      'default' => false,
    ),
    'related_doc_rev_number' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_DET_RELATED_DOCUMENT_VERSION',
      'width' => '10%',
      'default' => false,
    ),
    'related_doc_name' => 
    array (
      'type' => 'relate',
      'label' => 'LBL_DET_RELATED_DOCUMENT',
      'id' => 'RELATED_DOC_ID',
      'link' => true,
      'width' => '10%',
      'default' => false,
    ),
    'last_rev_create_date' => 
    array (
      'type' => 'date',
      'link' => 'revisions',
      'label' => 'LBL_LAST_REV_CREATE_DATE',
      'width' => '10%',
      'default' => false,
    ),
    'last_rev_created_name' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_LAST_REV_CREATOR',
      'width' => '10%',
      'default' => false,
    ),
    'latest_revision' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_LATEST_REVISION',
      'width' => '10%',
      'default' => false,
    ),
    'revision' => 
    array (
      'type' => 'varchar',
      'default' => false,
      'label' => 'LBL_DOC_VERSION',
      'width' => '10%',
    ),
    'document_revision_id' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_LATEST_REVISION',
      'width' => '10%',
      'default' => false,
    ),
    'status' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_DOC_STATUS',
      'width' => '10%',
      'default' => false,
    ),
    'description' => 
    array (
      'type' => 'text',
      'label' => 'LBL_DESCRIPTION',
      'sortable' => false,
      'width' => '10%',
      'default' => false,
    ),
    'created_by_name' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_CREATED',
      'id' => 'CREATED_BY',
      'width' => '10%',
      'default' => false,
    ),
    'modified_by_name' => 
    array (
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_MODIFIED_NAME',
      'id' => 'MODIFIED_USER_ID',
      'width' => '10%',
      'default' => false,
    ),
    'name' => 
    array (
      'type' => 'varchar',
      'label' => 'LBL_NAME',
      'width' => '10%',
      'default' => false,
    ),
    'subcategory_id' => 
    array (
      'width' => '8%',
      'label' => 'LBL_SUBCATEGORY',
      'default' => false,
      'name' => 'subcategory_id',
    ),
    'is_template' => 
    array (
      'width' => '8%',
      'label' => 'LBL_IS_TEMPLATE',
      'default' => false,
      'name' => 'is_template',
    ),
    'exp_date' => 
    array (
      'width' => '8%',
      'label' => 'LBL_EXPIRATION_DATE',
      'default' => false,
      'name' => 'exp_date',
    ),
    'date_entered' => 
    array (
      'width' => '15%',
      'label' => 'LBL_DATE_ENTERED',
      'name' => 'date_entered',
      'default' => false,
    ),
    'template_type' => 
    array (
      'width' => '8%',
      'label' => 'LBL_TEMPLATE_TYPE',
      'default' => false,
      'name' => 'template_type',
    ),
    'date_modified' => 
    array (
      'width' => '15%',
      'label' => 'LBL_DATE_MODIFIED',
      'name' => 'date_modified',
      'default' => false,
    ),
    'created_by' => 
    array (
      'width' => '8%',
      'label' => 'LBL_CREATED',
      'name' => 'created_by',
      'default' => false,
    ),
    'active_date' => 
    array (
      'width' => '8%',
      'label' => 'LBL_ACTIVE_DATE',
      'default' => false,
      'name' => 'active_date',
    ),
);
// END STIC-Custom  