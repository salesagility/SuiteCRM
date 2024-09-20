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
$dashletData['stic_Group_OpportunitiesDashlet']['searchFields'] = array(
    'date_entered' => array(
        'default' => '',
    ),
    'date_modified' => array(
        'default' => '',
    ),
    'status' => array(
        'default' => '',
    ),
    'stic_group_opportunities_accounts_name' => array(
        'default' => '',
    ),
    'stic_group_opportunities_opportunities_name' => array(
        'default' => '',
    ),
    'amount_requested' => array(
        'default' => '',
    ),
    'validation_date' => array(
        'default' => '',
    ),
    'resolution_date' => array(
        'default' => '',
    ),
    'assigned_user_id' => array(
        'default' => '',
    ),
);
$dashletData['stic_Group_OpportunitiesDashlet']['columns'] = array(
    'name' => array(
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
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
        'label' => 'LBL_AMOUNT_REQUESTED',
        'currency_format' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'amount_requested',
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
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => true,
    ),
    'date_modified' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ),
    'created_by' => array(
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ),
    'stic_group_opportunities_opportunities_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_GROUP_OPPORTUNITIES_OPPORTUNITIES_NAME',
        'id' => 'STIC_GROUP_OPPORTUNITIES_OPPORTUNITIESOPPORTUNITIES_IDA',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_group_opportunities_opportunities_name',
    ),
    'stic_group_opportunities_accounts_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_GROUP_OPPORTUNITIES_ACCOUNTS_NAME',
        'id' => 'STIC_GROUP_OPPORTUNITIES_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_group_opportunities_accounts_name',
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
    'contact' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_CONTACT',
        'id' => 'CONTACT_ID',
        'link' => true,
        'width' => '10%',
        'default' => false,
        'name' => 'contact',
    ),
    'folder' => array(
        'type' => 'url',
        'label' => 'LBL_FOLDER',
        'width' => '10%',
        'default' => false,
        'name' => 'folder',
    ),
    'payment_date' => array(
        'type' => 'date',
        'label' => 'LBL_PAYMENT_DATE',
        'width' => '10%',
        'default' => false,
        'name' => 'payment_date',
    ),
    'justification_date' => array(
        'type' => 'date',
        'label' => 'LBL_JUSTIFICATION_DATE',
        'width' => '10%',
        'default' => false,
        'name' => 'justification_date',
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
    'advance_date' => array(
        'type' => 'date',
        'label' => 'LBL_ADVANCE_DATE',
        'width' => '10%',
        'default' => false,
        'name' => 'advance_date',
    ),
    'date_entered' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'name' => 'date_entered',
    ),
    'presentation_date' => array(
        'type' => 'date',
        'label' => 'LBL_PRESENTATION_DATE',
        'width' => '10%',
        'default' => false,
        'name' => 'presentation_date',
    ),
    'start_date' => array(
        'type' => 'date',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => false,
        'name' => 'start_date',
    ),
    'amount_received' => array(
        'type' => 'currency',
        'label' => 'LBL_AMOUNT_RECEIVED',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
        'name' => 'amount_received',
    ),
    'document_status' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DOCUMENT_STATUS',
        'width' => '10%',
        'default' => false,
        'name' => 'document_status',
    ),
    'amount_awarded' => array(
        'type' => 'currency',
        'label' => 'LBL_AMOUNT_AWARDED',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
        'name' => 'amount_awarded',
    ),
);
