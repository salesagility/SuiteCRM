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
$listViewDefs['Notes'] =
array(
    'NAME' => array(
        'width' => '40%',
        'label' => 'LBL_LIST_SUBJECT',
        'link' => true,
        'default' => true,
    ),
    'FILENAME' => array(
        'width' => '20%',
        'label' => 'LBL_LIST_FILENAME',
        'default' => true,
        'type' => 'file',
        'related_fields' => array(
            0 => 'file_url',
            1 => 'id',
        ),
        'displayParams' => array(
            'module' => 'Notes',
        ),
    ),
    'PARENT_NAME' => array(
        'width' => '20%',
        'label' => 'LBL_LIST_RELATED_TO',
        'dynamic_module' => 'PARENT_TYPE',
        'id' => 'PARENT_ID',
        'link' => true,
        'default' => true,
        'sortable' => false,
        'ACLTag' => 'PARENT',
        'related_fields' => array(
            0 => 'parent_id',
            1 => 'parent_type',
        ),
    ),
    'CONTACT_NAME' => array(
        'width' => '20%',
        'label' => 'LBL_LIST_CONTACT',
        'link' => true,
        'id' => 'CONTACT_ID',
        'module' => 'Contacts',
        'default' => true,
        'ACLTag' => 'CONTACT',
        'related_fields' => array(
            0 => 'contact_id',
        ),
    ),
    'ASSIGNED_USER_NAME' => array(
        'link' => true,
        'type' => 'relate',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'id' => 'ASSIGNED_USER_ID',
        'width' => '10%',
        'default' => true,
    ),
    'EMBED_FLAG' => array(
        'type' => 'bool',
        'default' => false,
        'label' => 'LBL_EMBED_FLAG',
        'width' => '10%',
    ),
    'PORTAL_FLAG' => array(
        'type' => 'bool',
        'label' => 'LBL_PORTAL_FLAG',
        'width' => '10%',
        'default' => false,
    ),
    'FILE_URL' => array(
        'type' => 'function',
        'label' => 'LBL_FILE_URL',
        'width' => '10%',
        'default' => false,
    ),
    'FILE_MIME_TYPE' => array(
        'type' => 'varchar',
        'label' => 'LBL_FILE_MIME_TYPE',
        'width' => '10%',
        'default' => false,
    ),
    'CONTACT_PHONE' => array(
        'type' => 'phone',
        'label' => 'LBL_PHONE',
        'width' => '10%',
        'default' => false,
    ),
    'DESCRIPTION' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'CREATED_BY_NAME' => array(
        'type' => 'relate',
        'label' => 'LBL_CREATED_BY',
        'width' => '10%',
        'default' => false,
        'related_fields' => array(
            0 => 'created_by',
        ),
    ),
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
    ),
    'MODIFIED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_BY',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_MODIFIED' => array(
        'width' => '20%',
        'label' => 'LBL_DATE_MODIFIED',
        'link' => false,
        'default' => false,
    ),
);
