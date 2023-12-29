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
    'moduleMain' => 'Contact',
    'varName' => 'CONTACT',
    'orderBy' => 'contacts.first_name, contacts.last_name',
    'whereClauses' => array(
        'account_name' => 'accounts.name',
        'name' => 'contacts.name',
        'stic_relationship_type_c' => 'contacts_cstm.stic_relationship_type_c',
        'phone_mobile' => 'contacts.phone_mobile',
        'phone_home' => 'contacts.phone_home',
        'email' => 'contacts.email',
        'assigned_user_id' => 'contacts.assigned_user_id',
    ),
    'searchInputs' => array(
        2 => 'account_name',
        3 => 'email',
        4 => 'name',
        5 => 'stic_relationship_type_c',
        6 => 'phone_mobile',
        7 => 'phone_home',
        8 => 'assigned_user_id',
    ),
    'searchdefs' => array(
        'name' => array(
            'type' => 'name',
            'link' => true,
            'label' => 'LBL_NAME',
            'width' => '10%',
            'name' => 'name',
        ),
        'stic_relationship_type_c' => array(
            'type' => 'multienum',
            'studio' => 'visible',
            'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
            'width' => '10%',
            'name' => 'stic_relationship_type_c',
        ),
        'account_name' => array(
            'name' => 'account_name',
            'type' => 'varchar',
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
        'email' => array(
            'name' => 'email',
            'width' => '10%',
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
            'width' => '20%',
            'label' => 'LBL_LIST_NAME',
            'link' => true,
            'default' => true,
            'related_fields' => array(
                0 => 'first_name',
                1 => 'last_name',
                2 => 'salutation',
                3 => 'account_name',
                4 => 'account_id',
            ),
            'name' => 'name',
        ),
        'STIC_RELATIONSHIP_TYPE_C' => array(
            'type' => 'multienum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
            'width' => '10%',
            'name' => 'stic_relationship_type_c',
        ),
        'ACCOUNT_NAME' => array(
            'width' => '25%',
            'label' => 'LBL_LIST_ACCOUNT_NAME',
            'module' => 'Accounts',
            'id' => 'ACCOUNT_ID',
            'default' => true,
            'sortable' => true,
            'ACLTag' => 'ACCOUNT',
            'related_fields' => array(
                0 => 'account_id',
            ),
            'name' => 'account_name',
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
        'ASSIGNED_USER_NAME' => array(
            'link' => true,
            'type' => 'relate',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'default' => true,
        ),
    ),
);
