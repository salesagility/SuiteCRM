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
$module_name = 'stic_Work_Experience';
$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'stic_work_experience_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_WORK_EXPERIENCE_CONTACTS_FROM_CONTACTS_TITLE',
                'id' => 'STIC_WORK_EXPERIENCE_CONTACTSCONTACTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_work_experience_contacts_name',
            ),
            'stic_work_experience_accounts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_WORK_EXPERIENCE_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                'id' => 'STIC_WORK_EXPERIENCE_ACCOUNTSACCOUNTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_work_experience_accounts_name',
            ),
            'position' => array(
                'type' => 'varchar',
                'label' => 'LBL_POSITION',
                'width' => '10%',
                'default' => true,
                'name' => 'position',
            ),
            'position_type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_POSITION_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'position_type',
            ),
            'sector' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_SECTOR',
                'width' => '10%',
                'default' => true,
                'name' => 'sector',
            ),
            'start_date' => array(
                'type' => 'date',
                'label' => 'LBL_START_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'start_date',
            ),
            'contract_type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_CONTRACT_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'contract_type',
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
            'stic_work_experience_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_WORK_EXPERIENCE_CONTACTS_FROM_CONTACTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_WORK_EXPERIENCE_CONTACTSCONTACTS_IDA',
                'name' => 'stic_work_experience_contacts_name',
            ),
            'stic_work_experience_accounts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_WORK_EXPERIENCE_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_WORK_EXPERIENCE_ACCOUNTSACCOUNTS_IDA',
                'name' => 'stic_work_experience_accounts_name',
            ),
            'position' => array(
                'type' => 'varchar',
                'label' => 'LBL_POSITION',
                'width' => '10%',
                'default' => true,
                'name' => 'position',
            ),
            'position_type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_POSITION_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'position_type',
            ),
            'sector' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_SECTOR',
                'width' => '10%',
                'default' => true,
                'name' => 'sector',
            ),
            'start_date' => array(
                'type' => 'date',
                'label' => 'LBL_START_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'start_date',
            ),
            'contract_type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_CONTRACT_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'contract_type',
            ),
            'subsector' => array(
                'type' => 'dynamicenum',
                'studio' => 'visible',
                'label' => 'LBL_SUBSECTOR',
                'width' => '10%',
                'default' => true,
                'name' => 'subsector',
            ),
            'workday_type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_WORKDAY_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'workday_type',
            ),
            'schedule' => array(
                'type' => 'varchar',
                'label' => 'LBL_SCHEDULE',
                'width' => '10%',
                'default' => true,
                'name' => 'schedule',
            ),
            'achieved' => array(
                'type' => 'bool',
                'default' => true,
                'label' => 'LBL_ACHIEVED',
                'width' => '10%',
                'name' => 'achieved',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            'created_by' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            'modified_user_id' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
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
