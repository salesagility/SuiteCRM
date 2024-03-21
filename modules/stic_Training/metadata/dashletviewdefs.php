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
$dashletData['stic_TrainingDashlet']['searchFields'] = array(
    'name' => array(
        'default' => '',
    ),
    'stic_training_contacts_name' => array(
        'default' => '',
    ),
    'level' => array(
        'default' => '',
    ),
    'course_year' => array(
        'default' => '',
    ),
    'start_date' => array(
        'default' => '',
    ),
    'status' => array(
        'default' => '',
    ),
    'scope' => array(
        'default' => '',
    ),
    'country' => array(
        'default' => '',
    ),
    'stic_training_accounts_name' => array(
        'default' => '',
    ),
    'date_entered' => array(
        'default' => '',
    ),
    'date_modified' => array(
        'default' => '',
    ),
    'assigned_user_id' => array(
        'default' => '',
    ),
);
$dashletData['stic_TrainingDashlet']['columns'] = array(
    'name' => array(
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ),
    'stic_training_contacts_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_TRAINING_CONTACTS_FROM_CONTACTS_TITLE',
        'id' => 'STIC_TRAINING_CONTACTSCONTACTS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'stic_training_contacts_name',
    ),
    'level' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_LEVEL',
        'width' => '10%',
        'default' => true,
        'name' => 'level',
    ),
    'course_year' => array(
        'type' => 'dynamicenum',
        'studio' => 'visible',
        'label' => 'LBL_COURSE_YEAR',
        'width' => '10%',
        'default' => true,
        'name' => 'course_year',
    ),
    'scope' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SCOPE',
        'width' => '10%',
        'default' => true,
        'name' => 'scope',
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
    'status' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => false,
        'name' => 'status',
    ),
    'date_entered' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'name' => 'date_entered',
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
    'qualification' => array(
        'type' => 'varchar',
        'label' => 'LBL_QUALIFICATION',
        'width' => '10%',
        'default' => false,
        'name' => 'qualification',
    ),
    'formal' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_FORMAL',
        'width' => '10%',
        'default' => false,
        'name' => 'formal',
    ),
    'accredited' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_ACCREDITED',
        'width' => '10%',
        'default' => false,
        'name' => 'accredited',
    ),
    'country' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'default' => false,
        'label' => 'LBL_COUNTRY ',
        'width' => '10%',
        'name' => 'country',
    ),
    'grant_training' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_GRANT_TRAINING',
        'width' => '10%',
        'default' => false,
        'name' => 'grant_training',
    ),
    'grant_amount' => array(
        'type' => 'decimal',
        'label' => 'LBL_GRANT_AMOUNT',
        'width' => '10%',
        'default' => false,
        'name' => 'grant_amount',
    ),
    'amount' => array(
        'type' => 'decimal',
        'label' => 'LBL_AMOUNT',
        'width' => '10%',
        'default' => false,
        'name' => 'amount',
    ),
    'created_by' => array(
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ),
    'assigned_user_name' => array(
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
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
    'stic_training_accounts_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_TRAINING_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'STIC_TRAINING_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_training_accounts_name',
    ),
    'stic_training_stic_registrations_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_TRAINING_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
        'id' => 'STIC_TRAINING_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDB',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_training_stic_registrations_name',
    ),
);
