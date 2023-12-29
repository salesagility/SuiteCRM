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
    'moduleMain' => 'AOS_Contracts',
    'varName' => 'AOS_Contracts',
    'orderBy' => 'aos_contracts.name',
    'whereClauses' => array(
        'name' => 'aos_contracts.name',
        'status' => 'aos_contracts.status',
        'start_date' => 'aos_contracts.start_date',
        'end_date' => 'aos_contracts.end_date',
        'renewal_reminder_date' => 'aos_contracts.renewal_reminder_date',
    ),
    'searchInputs' => array(
        1 => 'name',
        3 => 'status',
        5 => 'start_date',
        6 => 'end_date',
        7 => 'renewal_reminder_date',
    ),
    'searchdefs' => array(
        'name' => array(
            'type' => 'name',
            'label' => 'LBL_NAME',
            'width' => '10%',
            'name' => 'name',
        ),
        'status' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
            'sortable' => false,
            'width' => '10%',
            'name' => 'status',
        ),
        'start_date' => array(
            'type' => 'date',
            'label' => 'LBL_START_DATE',
            'width' => '10%',
            'name' => 'start_date',
        ),
        'end_date' => array(
            'type' => 'date',
            'label' => 'LBL_END_DATE',
            'width' => '10%',
            'name' => 'end_date',
        ),
        'renewal_reminder_date' => array(
            'type' => 'datetimecombo',
            'label' => 'LBL_RENEWAL_REMINDER_DATE',
            'width' => '10%',
            'name' => 'renewal_reminder_date',
        ),
    ),
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '15%',
            'label' => 'LBL_NAME',
            'default' => true,
            'link' => true,
            'name' => 'name',
        ),
        'REFERENCE_CODE' => array(
            'type' => 'varchar',
            'label' => 'LBL_REFERENCE_CODE ',
            'width' => '10%',
            'default' => true,
            'name' => 'reference_code',
        ),
        'STATUS' => array(
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
            'sortable' => false,
            'width' => '10%',
            'name' => 'status',
        ),
        'TOTAL_CONTRACT_VALUE' => array(
            'label' => 'LBL_TOTAL_CONTRACT_VALUE',
            'currency_format' => true,
            'width' => '10%',
            'default' => true,
            'name' => 'total_contract_value',
        ),
        'TOTAL_AMOUNT' => array(
            'type' => 'currency',
            'label' => 'LBL_GRAND_TOTAL',
            'currency_format' => true,
            'width' => '10%',
            'default' => true,
            'name' => 'total_amount',
        ),
        'START_DATE' => array(
            'type' => 'date',
            'label' => 'LBL_START_DATE',
            'width' => '10%',
            'default' => true,
            'name' => 'start_date',
        ),
        'END_DATE' => array(
            'type' => 'date',
            'label' => 'LBL_END_DATE',
            'width' => '10%',
            'default' => true,
            'name' => 'end_date',
        ),
        'CONTACT' => array(
            'type' => 'relate',
            'studio' => 'visible',
            'label' => 'LBL_CONTACT',
            'id' => 'CONTACT_ID',
            'link' => true,
            'width' => '10%',
            'default' => true,
            'name' => 'contact',
        ),
        'CONTRACT_ACCOUNT' => array(
            'width' => '15%',
            'label' => 'LBL_CONTRACT_ACCOUNT',
            'default' => true,
            'module' => 'Accounts',
            'id' => 'CONTRACT_ACCOUNT_ID',
            'link' => true,
            'related_fields' => array(
                0 => 'contract_account_id',
            ),
            'name' => 'contract_account',
        ),
        'ASSIGNED_USER_NAME' => array(
            'width' => '10%',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'default' => true,
            'module' => 'Users',
            'id' => 'ASSIGNED_USER_ID',
            'link' => true,
            'name' => 'assigned_user_name',
        ),
    ),
);
