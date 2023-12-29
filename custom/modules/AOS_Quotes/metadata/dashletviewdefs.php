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
$dashletData['AOS_QuotesDashlet']['searchFields'] = array(
    'name' => array(
        'default' => '',
    ),
    'number' => array(
        'default' => '',
    ),
    'stage' => array(
        'default' => '',
    ),
    'approval_status' => array(
        'default' => '',
    ),
    'invoice_status' => array(
        'default' => '',
    ),
    'date_entered' => array(
        'default' => '',
    ),
    'billing_contact' => array(
        'default' => '',
    ),
    'billing_account' => array(
        'default' => '',
    ),
    'total_amount' => array(
        'default' => '',
    ),
    'assigned_user_id' => array(
        'default' => '',
    ),
);
$dashletData['AOS_QuotesDashlet']['columns'] = array(
    'number' => array(
        'width' => '5%',
        'label' => 'LBL_LIST_NUM',
        'default' => true,
        'name' => 'number',
    ),
    'name' => array(
        'width' => '20%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ),
    'stage' => array(
        'width' => '15%',
        'label' => 'LBL_STAGE',
        'default' => true,
        'name' => 'stage',
    ),
    'total_amount' => array(
        'width' => '15%',
        'label' => 'LBL_GRAND_TOTAL',
        'currency_format' => true,
        'default' => true,
        'name' => 'total_amount',
    ),
    'expiration' => array(
        'width' => '15%',
        'label' => 'LBL_EXPIRATION',
        'default' => true,
        'name' => 'expiration',
    ),
    'assigned_user_name' => array(
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => true,
    ),
    'approval_status' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_APPROVAL_STATUS',
        'width' => '10%',
        'default' => false,
        'name' => 'approval_status',
    ),
    'invoice_status' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_INVOICE_STATUS',
        'width' => '10%',
        'name' => 'invoice_status',
    ),
    'billing_account' => array(
        'width' => '20%',
        'label' => 'LBL_BILLING_ACCOUNT',
        'name' => 'billing_account',
        'default' => false,
    ),
    'billing_contact' => array(
        'width' => '15%',
        'label' => 'LBL_BILLING_CONTACT',
        'name' => 'billing_contact',
        'default' => false,
    ),
    'opportunity' => array(
        'width' => '25%',
        'label' => 'LBL_OPPORTUNITY',
        'name' => 'opportunity',
        'default' => false,
    ),
    'date_entered' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'name' => 'date_entered',
        'default' => false,
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
);
