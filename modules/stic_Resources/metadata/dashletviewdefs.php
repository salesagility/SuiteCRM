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
$dashletData['stic_ResourcesDashlet']['searchFields'] = array(
    'name' => array(
        'default' => '',
    ),
    'code' => array(
        'default' => '',
    ),
    'status' => array(
        'default' => '',
    ),
    'type' => array(
        'default' => '',
    ),
    'hourly_rate' => array(
        'default' => '',
    ),
    'daily_rate' => array(
        'default' => '',
    ),
    'assigned_user_name' => array(
        'default' => '',
    ),
    'owner_contact' => array(
        'default' => '',
    ),
    'owner_account' => array(
        'default' => '',
    ),
    'description' => array(
        'default' => '',
    ),
    'created_by_name' => array(
        'default' => '',
    ),
    'date_entered' => array(
        'default' => '',
    ),
    'modified_by_name' => array(
        'default' => '',
    ),
    'date_modified' => array(
        'default' => '',
    ),
    'assigned_user_id' => array(
        'default' => '',
    ),
);
$dashletData['stic_ResourcesDashlet']['columns'] = array(
    'name' => array(
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ),
    'status' => array(
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
    ),
    'code' => array(
        'type' => 'varchar',
        'label' => 'LBL_CODE',
        'width' => '10%',
        'default' => true,
        'name' => 'code',
    ),
    'type' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'type',
    ),
    'color' => array(
        'type' => 'ColorPicker',
        'studio' => 'visible',
        'label' => 'LBL_COLOR',
        'width' => '10%',
        'default' => true,
        'name' => 'color',
    ),
    'hourly_rate' => array(
        'type' => 'decimal',
        'label' => 'LBL_HOURLY_RATE',
        'width' => '10%',
        'default' => true,
        'name' => 'hourly_rate',
    ),
    'daily_rate' => array(
        'type' => 'decimal',
        'label' => 'LBL_DAILY_RATE',
        'width' => '10%',
        'default' => true,
        'name' => 'daily_rate',
    ),
    'assigned_user_name' => array(
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => true,
    ),
    'owner_contact' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_OWNER_CONTACT',
        'id' => 'CONTACT_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'owner_account' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_OWNER_ACCOUNT',
        'id' => 'ACCOUNT_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'description' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
        'name' => 'description',
    ),
    'created_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
        'name' => 'created_by_name',
    ),
    'date_entered' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'name' => 'date_entered',
    ),
    'date_modified' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ),
    'modified_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
        'name' => 'modified_by_name',
    ),
);
