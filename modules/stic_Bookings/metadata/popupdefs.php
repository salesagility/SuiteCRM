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
    'moduleMain' => 'stic_Bookings',
    'varName' => 'stic_Bookings',
    'orderBy' => 'stic_bookings.name',
    'whereClauses' => array(
        'name' => 'stic_bookings.name',
        'start_date' => 'stic_bookings.start_date',
        'end_date' => 'stic_bookings.end_date',
        'parent_name' => 'stic_bookings.parent_name',
        'assigned_user_name' => 'stic_bookings.assigned_user_name',
        'description' => 'stic_bookings.description',
        'created_by_name' => 'stic_bookings.created_by_name',
        'date_entered' => 'stic_bookings.date_entered',
        'modified_by_name' => 'stic_bookings.modified_by_name',
        'date_modified' => 'stic_bookings.date_modified',
        'stic_bookings_accounts_name' => 'stic_bookings.stic_bookings_accounts_name',
        'stic_bookings_contacts_name' => 'stic_bookings.stic_bookings_contacts_name',
    ),
    'searchInputs' => array(
        1 => 'name',
        2 => 'code',
        3 => 'status',
        4 => 'start_date',
        5 => 'end_date',
        6 => 'parent_name',
        7 => 'assigned_user_name',
        8 => 'description',
        9 => 'created_by_name',
        10 => 'date_entered',
        11 => 'modified_by_name',
        12 => 'date_modified',
        13 => 'stic_bookings_accounts_name',
        14 => 'stic_bookings_contacts_name',
    ),
    'searchdefs' => array(
        'name' => array(
            'type' => 'name',
            'link' => true,
            'label' => 'LBL_NAME',
            'width' => '10%',
            'name' => 'name',
        ),
        'code' => array(
            'label' => 'LBL_CODE',
            'width' => '10%',
            'name' => 'code',
        ),
        'status' => array(
            'label' => 'LBL_STATUS',
            'width' => '10%',
            'name' => 'status',
        ),
        'start_date' => array(
            'type' => 'datetimecombo',
            'label' => 'LBL_START_DATE',
            'width' => '10%',
            'name' => 'start_date',
        ),
        'end_date' => array(
            'type' => 'datetimecombo',
            'label' => 'LBL_END_DATE',
            'width' => '10%',
            'name' => 'end_date',
        ),
        'stic_bookings_accounts_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_STIC_BOOKINGS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
            'id' => 'STIC_BOOKINGS_ACCOUNTSACCOUNTS_IDA',
            'width' => '10%',
            'name' => 'stic_bookings_accounts_name',
        ),
        'stic_bookings_contacts_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_STIC_BOOKINGS_CONTACTS_FROM_CONTACTS_TITLE',
            'id' => 'STIC_BOOKINGS_CONTACTSCONTACTS_IDA',
            'width' => '10%',
            'name' => 'stic_bookings_contacts_name',
        ),
        'description' => array(
            'type' => 'text',
            'label' => 'LBL_DESCRIPTION',
            'sortable' => false,
            'width' => '10%',
            'name' => 'description',
        ),
        'created_by_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_CREATED',
            'id' => 'CREATED_BY',
            'width' => '10%',
            'name' => 'created_by_name',
        ),
        'date_entered' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_ENTERED',
            'width' => '10%',
            'name' => 'date_entered',
        ),
        'modified_by_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_MODIFIED_NAME',
            'id' => 'MODIFIED_USER_ID',
            'width' => '10%',
            'name' => 'modified_by_name',
        ),
        'date_modified' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_MODIFIED',
            'width' => '10%',
            'name' => 'date_modified',
        ),
        'assigned_user_name' => array(
            'link' => true,
            'type' => 'relate',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'name' => 'assigned_user_name',
        ),
    ),
    'listviewdefs' => array(
        'NAME' => array(
            'type' => 'name',
            'link' => true,
            'label' => 'LBL_NAME',
            'width' => '10%',
            'default' => true,
            'name' => 'name',
        ),
        'CODE' => array(
            'label' => 'LBL_CODE',
            'width' => '10%',
            'default' => true,
            'name' => 'code',
        ),
        'STATUS' => array(
            'label' => 'LBL_STATUS',
            'width' => '10%',
            'default' => true,
            'name' => 'status',
        ),
        'START_DATE' => array(
            'type' => 'datetimecombo',
            'label' => 'LBL_START_DATE',
            'width' => '10%',
            'default' => true,
            'name' => 'start_date',
        ),
        'END_DATE' => array(
            'type' => 'datetimecombo',
            'label' => 'LBL_END_DATE',
            'width' => '10%',
            'default' => true,
            'name' => 'end_date',
        ),
        'STIC_BOOKINGS_CONTACTS_NAME' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_STIC_BOOKINGS_CONTACTS_FROM_CONTACTS_TITLE',
            'id' => 'STIC_BOOKINGS_CONTACTSCONTACTS_IDA',
            'width' => '10%',
            'default' => true,
        ),
        'STIC_BOOKINGS_ACCOUNTS_NAME' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_STIC_BOOKINGS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
            'id' => 'STIC_BOOKINGS_ACCOUNTSACCOUNTS_IDA',
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
            'name' => 'assigned_user_name',
        ),
    ),
);
