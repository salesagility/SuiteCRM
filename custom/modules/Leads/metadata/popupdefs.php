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
    'moduleMain' => 'Lead',
    'varName' => 'LEAD',
    'orderBy' => 'last_name, first_name',
    'whereClauses' => array(
        'status' => 'leads.status',
        'assigned_user_id' => 'leads.assigned_user_id',
        'name' => 'leads.name',
        'email' => 'leads.email',
        'phone_mobile' => 'leads.phone_mobile',
        'phone_home' => 'leads.phone_home',
    ),
    'searchInputs' => array(
        3 => 'status',
        5 => 'assigned_user_id',
        6 => 'name',
        7 => 'email',
        8 => 'phone_mobile',
        9 => 'phone_home',
    ),
    'searchdefs' => array(
        'name' => array(
            'type' => 'name',
            'link' => true,
            'label' => 'LBL_NAME',
            'width' => '10%',
            'name' => 'name',
        ),
        'status' => array(
            'name' => 'status',
            'width' => '10%',
        ),
        'email' => array(
            'name' => 'email',
            'width' => '10%',
        ),
        'phone_mobile' => array(
            'type' => 'phone',
            'label' => 'LBL_MOBILE_PHONE',
            'width' => '10%',
            'name' => 'phone_mobile',
        ),
        'phone_home' => array(
            'type' => 'phone',
            'label' => 'LBL_HOME_PHONE',
            'width' => '10%',
            'name' => 'phone_home',
        ),
        'assigned_user_id' => array(
            'name' => 'assigned_user_id',
            'type' => 'enum',
            'label' => 'LBL_ASSIGNED_TO',
            'function' => array(
                'name' => 'get_user_array',
                'params' => array(
                    0 => false,
                ),
            ),
            'width' => '10%',
        ),
    ),
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '30%',
            'label' => 'LBL_LIST_NAME',
            'link' => true,
            'default' => true,
            'related_fields' => array(
                0 => 'first_name',
                1 => 'last_name',
                2 => 'salutation',
            ),
            'name' => 'name',
        ),
        'STATUS' => array(
            'width' => '10%',
            'label' => 'LBL_LIST_STATUS',
            'default' => true,
            'name' => 'status',
        ),
        'EMAIL1' => array(
            'type' => 'varchar',
            'studio' => array(
                'editview' => true,
                'editField' => true,
                'searchview' => false,
                'popupsearch' => false,
            ),
            'label' => 'LBL_EMAIL_ADDRESS',
            'width' => '10%',
            'default' => true,
        ),
        'PHONE_MOBILE' => array(
            'type' => 'phone',
            'label' => 'LBL_MOBILE_PHONE',
            'width' => '10%',
            'default' => true,
        ),
        'PHONE_HOME' => array(
            'type' => 'phone',
            'label' => 'LBL_HOME_PHONE',
            'width' => '10%',
            'default' => true,
        ),
        'ASSIGNED_USER_NAME' => array(
            'width' => '10%',
            'label' => 'LBL_LIST_ASSIGNED_USER',
            'default' => true,
            'name' => 'assigned_user_name',
        ),
    ),
);
