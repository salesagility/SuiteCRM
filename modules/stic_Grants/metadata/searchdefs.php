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
$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'type',
            ),
            'subtype' => array(
                'type' => 'dynamicenum',
                'studio' => 'visible',
                'label' => 'LBL_SUBTYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'subtype',
            ),
            'amount' => array(
                'type' => 'decimal',
                'align' => 'right',
                'label' => 'LBL_AMOUNT',
                'width' => '10%',
                'default' => true,
                'name' => 'amount',
            ),
            'percentage' => array(
                'type' => 'decimal',
                'align' => 'right',
                'label' => 'LBL_PERCENTAGE',
                'width' => '10%',
                'default' => true,
                'name' => 'percentage',
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
            'active' => array(
                'type' => 'bool',
                'label' => 'LBL_ACTIVE',
                'width' => '10%',
                'default' => true,
                'name' => 'active',
            ),
            'stic_grants_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GRANTS_CONTACTS_FROM_CONTACTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_GRANTSS_CONTACTSCONTACTS_IDA',
                'name' => 'stic_grants_contacts_name',
            ),
            'stic_grants_stic_families_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GRANTS_STIC_FAMILIES_FROM_STIC_FAMILIES_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_GRANTS_STIC_FAMILIESSTIC_FAMILIES_IDA',
                'name' => 'stic_grants_stic_families_name',
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
                'default' => true,
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
            'type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'amount',
            ),
            'subtype' => array(
                'type' => 'dynamicenum',
                'studio' => 'visible',
                'label' => 'LBL_SUBTYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'amount',
            ),
            'amount' => array(
                'type' => 'decimal',
                'align' => 'right',
                'label' => 'LBL_AMOUNT',
                'width' => '10%',
                'default' => true,
                'name' => 'amount',
            ),
            'percentage' => array(
                'type' => 'decimal',
                'align' => 'right',
                'label' => 'LBL_PERCENTAGE',
                'width' => '10%',
                'default' => true,
                'name' => 'percentage',
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
            'active' => array(
                'type' => 'bool',
                'label' => 'LBL_ACTIVE',
                'width' => '10%',
                'default' => true,
                'name' => 'active',
            ),
            'stic_grants_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GRANTS_CONTACTS_FROM_CONTACTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_GRANTSS_CONTACTSCONTACTS_IDA',
                'name' => 'stic_grants_contacts_name',
            ),
            'stic_grants_stic_families_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GRANTS_STIC_FAMILIES_FROM_STIC_FAMILIES_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_GRANTS_STIC_FAMILIESSTIC_FAMILIES_IDA',
                'name' => 'stic_grants_stic_families_name',
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
                'default' => true,
            ),
            'periodicity' => array(
                'type' => 'enum',
                'label' => 'LBL_PERIODICITY',
                'width' => '10%',
                'default' => true,
                'name' => 'periodicity',
            ),
            'returned_amount' => array(
                'type' => 'decimal',
                'label' => 'LBL_RETURNED_AMOUNT',
                'width' => '10%',
                'default' => true,
                'name' => 'returned_amount',
            ),
            'renovation_date' => array(
                'type' => 'date',
                'label' => 'LBL_RENOVATION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'renovation_date',
            ),
            'expected_end_date' => array(
                'type' => 'date',
                'label' => 'LBL_EXPECTED_END_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'expected_end_date',
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
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            'stic_grants_project_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GRANTS_PROJECT_FROM_PROJECT_TITLE',
                'id' => 'STIC_GRANTS_PROJECTPROJECT_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_grants_project_name',
            ),
            'stic_grants_opportunities_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GRANTS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
                'id' => 'STIC_GRANTS_OPPORTUNITIESOPPORTUNITIES_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_grants_opportunities_name',
            ),
            'stic_grants_accounts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GRANTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_GRANTS_ACCOUNTSACCOUNTS_IDA',
                'name' => 'stic_grants_accounts_name',
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
