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
    'moduleMain' => 'stic_Training',
    'varName' => 'stic_Training',
    'orderBy' => 'stic_training.name',
    'whereClauses' => array(
        'name' => 'stic_training.name',
        'assigned_user_id' => 'stic_training.assigned_user_id',
        'stic_training_accounts_name' => 'stic_training.stic_training_accounts_name',
        'stic_training_contacts_name' => 'stic_training.stic_training_contacts_name',
        'level' => 'stic_training.level',
        'course_year' => 'stic_training.course_year',
        'status' => 'stic_training.status',
        'scope' => 'stic_training.scope',
        'start_date' => 'stic_training.start_date',
        'end_date' => 'stic_training.end_date',
        'country' => 'stic_training.country',
        'formal' => 'stic_training.formal',
        'accredited' => 'stic_training.accredited',
        'qualification' => 'stic_training.qualification',
        'grant_training' => 'stic_training.grant_training',
        'grant_amount' => 'stic_training.grant_amount',
        'amount' => 'stic_training.amount',
        'stic_training_stic_registrations_name' => 'stic_training.stic_training_stic_registrations_name',
        'description' => 'stic_training.description',
        'date_modified' => 'stic_training.date_modified',
        'date_entered' => 'stic_training.date_entered',
        'modified_user_id' => 'stic_training.modified_user_id',
        'created_by' => 'stic_training.created_by',
    ),
    'searchInputs' => array(
        1 => 'name',
        3 => 'status',
        4 => 'assigned_user_id',
        5 => 'stic_training_accounts_name',
        6 => 'stic_training_contacts_name',
        7 => 'level',
        8 => 'course_year',
        9 => 'scope',
        10 => 'start_date',
        11 => 'end_date',
        12 => 'country',
        13 => 'formal',
        14 => 'accredited',
        15 => 'qualification',
        16 => 'grant_training',
        17 => 'grant_amount',
        18 => 'amount',
        19 => 'stic_training_stic_registrations_name',
        20 => 'description',
        21 => 'date_modified',
        22 => 'date_entered',
        23 => 'modified_user_id',
        24 => 'created_by',
    ),
    'searchdefs' => array(
        'name' => array(
            'name' => 'name',
            'width' => '10%',
        ),
        'assigned_user_id' => array(
            'name' => 'assigned_user_id',
            'label' => 'LBL_ASSIGNED_TO',
            'type' => 'enum',
            'function' => array(
                'name' => 'get_user_array',
                'params' => array(
                    0 => false,
                ),
            ),
            'width' => '10%',
        ),
        'stic_training_accounts_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_STIC_TRAINING_ACCOUNTS_FROM_ACCOUNTS_TITLE',
            'id' => 'STIC_TRAINING_ACCOUNTSACCOUNTS_IDA',
            'width' => '10%',
            'name' => 'stic_training_accounts_name',
        ),
        'stic_training_contacts_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_STIC_TRAINING_CONTACTS_FROM_CONTACTS_TITLE',
            'id' => 'STIC_TRAINING_CONTACTSCONTACTS_IDA',
            'width' => '10%',
            'name' => 'stic_training_contacts_name',
        ),
        'level' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_LEVEL',
            'width' => '10%',
            'name' => 'level',
        ),
        'course_year' => array(
            'type' => 'dynamicenum',
            'studio' => 'visible',
            'label' => 'LBL_COURSE_YEAR',
            'width' => '10%',
            'name' => 'course_year',
        ),
        'status' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
            'width' => '10%',
            'name' => 'status',
        ),
        'scope' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_SCOPE',
            'width' => '10%',
            'name' => 'scope',
        ),
        'start_date' => array(
            'type' => 'datetimecombo',
            'label' => 'LBL_START_DATE',
            'width' => '10%',
            'name' => 'start_date',
        ),
        'end_date' => array(
            'type' => 'decimal',
            'label' => 'LBL_END_DATE',
            'width' => '10%',
            'name' => 'end_date',
        ),
        'country' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_COUNTRY ',
            'width' => '10%',
            'name' => 'country',
        ),
        'formal' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_FORMAL',
            'width' => '10%',
            'name' => 'formal',
        ),
        'accredited' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_ACCREDITED',
            'width' => '10%',
            'name' => 'accredited',
        ),
        'qualification' => array(
            'type' => 'varchar',
            'label' => 'LBL_QUALIFICATION',
            'width' => '10%',
            'name' => 'qualification',
        ),
        'grant_training' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_GRANT_TRAINING',
            'width' => '10%',
            'name' => 'grant_training',
        ),
        'grant_amount' => array(
            'type' => 'decimal',
            'label' => 'LBL_GRANT_AMOUNT',
            'width' => '10%',
            'name' => 'grant_amount',
        ),
        'amount' => array(
            'type' => 'decimal',
            'label' => 'LBL_AMOUNT',
            'width' => '10%',
            'name' => 'amount',
        ),
        'stic_training_stic_registrations_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_STIC_TRAINING_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
            'id' => 'STIC_TRAINING_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDB',
            'width' => '10%',
            'name' => 'stic_training_stic_registrations_name',
        ),
        'description' => array(
            'type' => 'text',
            'label' => 'LBL_DESCRIPTION',
            'sortable' => false,
            'width' => '10%',
            'name' => 'description',
        ),
        'date_modified' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_MODIFIED',
            'width' => '10%',
            'name' => 'date_modified',
        ),
        'date_entered' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_ENTERED',
            'width' => '10%',
            'name' => 'date_entered',
        ),
        'modified_user_id' => array(
            'type' => 'assigned_user_name',
            'label' => 'LBL_MODIFIED',
            'width' => '10%',
            'name' => 'modified_user_id',
        ),
        'created_by' => array(
            'type' => 'assigned_user_name',
            'label' => 'LBL_CREATED',
            'width' => '10%',
            'name' => 'created_by',
        ),
    ),
);
