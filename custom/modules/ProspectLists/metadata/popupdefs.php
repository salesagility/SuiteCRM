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
$popupMeta = array(
    'moduleMain' => 'ProspectList',
    'varName' => 'PROSPECTLIST',
    'orderBy' => 'name',
    'whereClauses' => array(
        'list_type' => 'prospect_lists.list_type',
        0 => 'prospectlists.0',
        'current_user_only' => 'prospectlists.current_user_only',
        'assigned_user_name' => 'prospectlists.assigned_user_name',
    ),
    'searchInputs' => array(

    ),
    'searchdefs' => array(
        'assigned_user_name' => array(
            'link' => true,
            'type' => 'relate',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'name' => 'assigned_user_name',
        ),
        0 => array(
            'name' => 'name',
            'label' => 'LBL_PROSPECT_LIST_NAME',
            'width' => '10%',
        ),
        'list_type' => array(
            'name' => 'list_type',
            'label' => 'LBL_LIST_TYPE',
            'type' => 'enum',
            'width' => '10%',
        ),
        'current_user_only' => array(
            'name' => 'current_user_only',
            'label' => 'LBL_CURRENT_USER_FILTER',
            'type' => 'bool',
            'width' => '10%',
        ),
    ),
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '25',
            'label' => 'LBL_LIST_PROSPECT_LIST_NAME',
            'link' => true,
            'default' => true,
        ),
        'LIST_TYPE' => array(
            'width' => '15',
            'label' => 'LBL_LIST_TYPE_LIST_NAME',
            'default' => true,
        ),
        'DESCRIPTION' => array(
            'width' => '50',
            'label' => 'LBL_LIST_DESCRIPTION',
            'default' => true,
        ),
        'ASSIGNED_USER_NAME' => array(
            'width' => '10',
            'label' => 'LBL_LIST_ASSIGNED_USER',
            'module' => 'Employees',
            'default' => true,
        ),
    ),
);
