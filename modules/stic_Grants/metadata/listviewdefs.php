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
$module_name = 'stic_Grants';
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'TYPE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
    ),
    'SUBTYPE' => array(
        'type' => 'dynamicenum',
        'studio' => 'visible',
        'label' => 'LBL_SUBTYPE',
        'width' => '10%',
        'default' => true,
    ),
    'AMOUNT' => array(
        'type' => 'decimal',
        'label' => 'LBL_AMOUNT',
        'width' => '10%',
        'default' => true,
    ),
    'PERCENTAGE' => array(
        'type' => 'decimal',
        'label' => 'LBL_PERCENTAGE',
        'width' => '10%',
        'default' => true,
    ),
    'START_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'END_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_END_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'ACTIVE' => array(
        'type' => 'bool',
        'default' => true,
        'label' => 'LBL_ACTIVE',
        'width' => '10%',
    ),
    'STIC_GRANTS_CONTACTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_GRANTS_CONTACTS_FROM_CONTACTS_TITLE',
        'id' => 'STIC_GRANTS_CONTACTSCONTACTS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'STIC_GRANTS_STIC_FAMILIES_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_GRANTS_STIC_FAMILIES_FROM_STIC_FAMILIES_TITLE',
        'id' => 'STIC_GRANTS_STIC_FAMILIESSTIC_FAMILIES_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
    'PERIODICITY' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_PERIODICITY',
        'width' => '10%',
        'default' => false,
    ),
    'RETURNED_AMOUNT' => array(
        'type' => 'decimal',
        'label' => 'LBL_RETURNED_AMOUNT',
        'width' => '10%',
        'default' => false,
    ),
    'RENOVATION_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_RENOVATION_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'EXPECTED_END_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_EXPECTED_END_DATE',
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
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
    ),
    'MODIFIED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
    ),
    'CREATED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_MODIFIED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => false,
    ),
    'STIC_GRANTS_PROJECT_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_GRANTS_PROJECT_FROM_PROJECT_TITLE',
        'id' => 'STIC_GRANTS_PROJECTPROJECT_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'STIC_GRANTS_OPPORTUNITIES_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_GRANTS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
        'id' => 'STIC_GRANTS_OPPORTUNITIESOPPORTUNITIES_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'STIC_GRANTS_ACCOUNTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_GRANTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'STIC_GRANTS_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => false,
    ),
);
