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
$module_name = 'stic_Group_Opportunities';
$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'stic_group_opportunities_accounts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GROUP_OPPORTUNITIES_ACCOUNTS_NAME',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_GROUP_OPPORTUNITIES_ACCOUNTSACCOUNTS_IDA',
                'name' => 'stic_group_opportunities_accounts_name',
            ),
            'stic_group_opportunities_opportunities_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GROUP_OPPORTUNITIES_OPPORTUNITIES_NAME',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_GROUP_OPPORTUNITIES_OPPORTUNITIESOPPORTUNITIES_IDA',
                'name' => 'stic_group_opportunities_opportunities_name',
            ),
            'status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'status',
            ),
            'amount_requested' => array(
                'type' => 'currency',
                'studio' => 'visible',
                'label' => 'LBL_AMOUNT_REQUESTED',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'amount_requested',
            ),
            'contact' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_CONTACT',
                'id' => 'CONTACT_ID',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'contact',
            ),
            'validation_date' => array(
                'type' => 'date',
                'label' => 'LBL_VALIDATION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'validation_date',
            ),
            'resolution_date' => array(
                'type' => 'date',
                'label' => 'LBL_RESOLUTION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'resolution_date',
            ),
            'assigned_user_name' => array(
                'width' => '9%',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'module' => 'Employees',
                'id' => 'ASSIGNED_USER_ID',
                'default' => true,
                'name' => 'assigned_user_name',
            ),
            'current_user_only' => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
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
            'stic_group_opportunities_accounts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GROUP_OPPORTUNITIES_ACCOUNTS_NAME',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_GROUP_OPPORTUNITIES_ACCOUNTSACCOUNTS_IDA',
                'name' => 'stic_group_opportunities_accounts_name',
            ),
            'stic_group_opportunities_opportunities_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_GROUP_OPPORTUNITIES_OPPORTUNITIES_NAME',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_GROUP_OPPORTUNITIES_OPPORTUNITIESOPPORTUNITIES_IDA',
                'name' => 'stic_group_opportunities_opportunities_name',
            ),
            'status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'status',
            ),
            'document_status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_DOCUMENT_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'document_status',
            ),
            'amount_requested' => array(
                'type' => 'currency',
                'label' => 'LBL_AMOUNT_REQUESTED',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'amount_requested',
            ),
            'amount_awarded' => array(
                'type' => 'currency',
                'label' => 'LBL_AMOUNT_AWARDED',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'amount_awarded',
            ),
            'amount_received' => array(
                'type' => 'currency',
                'label' => 'LBL_AMOUNT_RECEIVED',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'amount_received',
            ),
            'contact' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_CONTACT',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'id' => 'CONTACT_ID',
                'name' => 'contact',
            ),
            'start_date' => array(
                'type' => 'date',
                'label' => 'LBL_START_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'start_date',
            ),
            'validation_date' => array(
                'type' => 'date',
                'label' => 'LBL_VALIDATION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'validation_date',
            ),
            'presentation_date' => array(
                'type' => 'date',
                'label' => 'LBL_PRESENTATION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'presentation_date',
            ),
            'resolution_date' => array(
                'type' => 'date',
                'label' => 'LBL_RESOLUTION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'resolution_date',
            ),
            'advance_date' => array(
                'type' => 'date',
                'label' => 'LBL_ADVANCE_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'advance_date',
            ),
            'justification_date' => array(
                'type' => 'date',
                'label' => 'LBL_JUSTIFICATION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'justification_date',
            ),
            'payment_date' => array(
                'type' => 'date',
                'label' => 'LBL_PAYMENT_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'payment_date',
            ),
            'folder' => array(
                'type' => 'url',
                'label' => 'LBL_FOLDER',
                'width' => '10%',
                'default' => true,
                'name' => 'folder',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
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
            'modified_user_id' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
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
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
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
