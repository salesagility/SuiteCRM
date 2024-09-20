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
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'AMOUNT_REQUESTED' => array(
        'type' => 'currency',
        'label' => 'LBL_AMOUNT_REQUESTED',
        'currency_format' => true,
        'width' => '10%',
        'default' => true,
    ),
    'CONTACT' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_CONTACT',
        'id' => 'CONTACT_ID',
        'link' => true,
        'width' => '10%',
        'default' => true,
    ),
    'VALIDATION_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_VALIDATION_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'RESOLUTION_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_RESOLUTION_DATE',
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
    'AMOUNT_AWARDED' => array(
        'type' => 'currency',
        'label' => 'LBL_AMOUNT_AWARDED',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'AMOUNT_RECEIVED' => array(
        'type' => 'currency',
        'label' => 'LBL_AMOUNT_RECEIVED',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'STIC_GROUP_OPPORTUNITIES_OPPORTUNITIES_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_GROUP_OPPORTUNITIES_OPPORTUNITIES_NAME',
        'id' => 'STIC_GROUP_OPPORTUNITIES_OPPORTUNITIESOPPORTUNITIES_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'STIC_GROUP_OPPORTUNITIES_ACCOUNTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_GROUP_OPPORTUNITIES_ACCOUNTS_NAME',
        'id' => 'STIC_GROUP_OPPORTUNITIES_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
    ),
    'JUSTIFICATION_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_JUSTIFICATION_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'ADVANCE_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_ADVANCE_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'PRESENTATION_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_PRESENTATION_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'PAYMENT_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_PAYMENT_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'DOCUMENT_STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DOCUMENT_STATUS',
        'width' => '10%',
        'default' => false,
    ),
    'FOLDER' => array(
        'type' => 'url',
        'label' => 'LBL_FOLDER',
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
    'START_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_MODIFIED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
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
);
