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
$module_name = 'stic_Training';
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'STIC_TRAINING_CONTACTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_TRAINING_CONTACTS_FROM_CONTACTS_TITLE',
        'id' => 'STIC_TRAINING_CONTACTSCONTACTS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'LEVEL' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_LEVEL',
        'width' => '10%',
        'default' => true,
    ),
    'COURSE_YEAR' => array(
        'type' => 'dynamicenum',
        'studio' => 'visible',
        'label' => 'LBL_COURSE_YEAR',
        'width' => '10%',
        'default' => true,
    ),
    'STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'COUNTRY' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'default' => true,
        'label' => 'LBL_COUNTRY ',
        'width' => '10%',
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
    'STIC_TRAINING_STIC_REGISTRATIONS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_TRAINING_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
        'id' => 'STIC_TRAINING_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDB',
        'width' => '10%',
        'default' => false,
    ),
    'STIC_TRAINING_ACCOUNTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_TRAINING_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'STIC_TRAINING_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'AMOUNT' => array(
        'type' => 'decimal',
        'label' => 'LBL_AMOUNT',
        'width' => '10%',
        'default' => false,
    ),
    'GRANT_AMOUNT' => array(
        'type' => 'decimal',
        'label' => 'LBL_GRANT_AMOUNT',
        'width' => '10%',
        'default' => false,
    ),
    'GRANT_TRAINING' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_GRANT_TRAINING',
        'width' => '10%',
        'default' => false,
    ),
    'FORMAL' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_FORMAL',
        'width' => '10%',
        'default' => false,
    ),
    'ACCREDITED' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_ACCREDITED',
        'width' => '10%',
        'default' => false,
    ),
    'QUALIFICATION' => array(
        'type' => 'varchar',
        'label' => 'LBL_QUALIFICATION',
        'width' => '10%',
        'default' => false,
    ),
    'SCOPE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SCOPE',
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
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
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
    'DATE_MODIFIED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
    ),
);
