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
$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
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
            'status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'status',
            ),
            'country' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'default' => true,
                'label' => 'LBL_COUNTRY ',
                'width' => '10%',
                'name' => 'country',
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
                'default' => true,
                'width' => '10%',
            ),
            'current_user_only' => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
        'advanced_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
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
                'default' => true,
                'width' => '10%',
            ),
            'stic_training_accounts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_TRAINING_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                'id' => 'STIC_TRAINING_ACCOUNTSACCOUNTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_training_accounts_name',
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
            'status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'status',
            ),
            'scope' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_SCOPE',
                'width' => '10%',
                'default' => true,
                'name' => 'scope',
            ),
            'country' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'default' => true,
                'label' => 'LBL_COUNTRY ',
                'width' => '10%',
                'name' => 'country',
            ),
            'formal' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_FORMAL',
                'width' => '10%',
                'default' => true,
                'name' => 'formal',
            ),
            'accredited' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_ACCREDITED',
                'width' => '10%',
                'default' => true,
                'name' => 'accredited',
            ),
            'qualification' => array(
                'type' => 'varchar',
                'label' => 'LBL_QUALIFICATION',
                'width' => '10%',
                'default' => true,
                'name' => 'qualification',
            ),
            'start_date' => array(
                'type' => 'date',
                'label' => 'LBL_START_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'start_date',
            ),
            'end_date' => array(
                'type' => 'date',
                'label' => 'LBL_END_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'end_date',
            ),

            'grant_training' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_GRANT_TRAINING',
                'width' => '10%',
                'default' => true,
                'name' => 'grant_training',
            ),
            'grant_amount' => array(
                'type' => 'decimal',
                'label' => 'LBL_GRANT_AMOUNT',
                'width' => '10%',
                'default' => true,
                'name' => 'grant_amount',
            ),
            'amount' => array(
                'type' => 'decimal',
                'label' => 'LBL_AMOUNT',
                'width' => '10%',
                'default' => true,
                'name' => 'amount',
            ),
            'stic_training_stic_registrations_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_TRAINING_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
                'id' => 'STIC_TRAINING_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDB',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_training_stic_registrations_name',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            'modified_user_id' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            'created_by' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            'current_user_only' => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
    ),
    'templateMeta' => array(
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
);
