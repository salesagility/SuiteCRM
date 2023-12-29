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
    'moduleMain' => 'AOS_Quotes',
    'varName' => 'AOS_Quotes',
    'orderBy' => 'aos_quotes.name',
    'whereClauses' => array(
        'name' => 'aos_quotes.name',
        'number' => 'aos_quotes.number',
        'stage' => 'aos_quotes.stage',
        'approval_status' => 'aos_quotes.approval_status',
        'invoice_status' => 'aos_quotes.invoice_status',
        'billing_contact' => 'aos_quotes.billing_contact',
        'billing_account' => 'aos_quotes.billing_account',
        'total_amount' => 'aos_quotes.total_amount',
        'expiration' => 'aos_quotes.expiration',
        'term' => 'aos_quotes.term',
        'assigned_user_id' => 'aos_quotes.assigned_user_id',
    ),
    'searchInputs' => array(
        0 => 'name',
        4 => 'number',
        5 => 'stage',
        6 => 'approval_status',
        7 => 'invoice_status',
        8 => 'billing_contact',
        9 => 'billing_account',
        10 => 'total_amount',
        11 => 'expiration',
        12 => 'term',
        13 => 'assigned_user_id',
    ),
    'searchdefs' => array(
        'number' => array(
            'name' => 'number',
            'width' => '10%',
        ),
        'name' => array(
            'name' => 'name',
            'width' => '10%',
        ),
        'stage' => array(
            'name' => 'stage',
            'width' => '10%',
        ),
        'approval_status' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_APPROVAL_STATUS',
            'width' => '10%',
            'name' => 'approval_status',
        ),
        'invoice_status' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_INVOICE_STATUS',
            'width' => '10%',
            'name' => 'invoice_status',
        ),
        'billing_contact' => array(
            'name' => 'billing_contact',
            'width' => '10%',
        ),
        'billing_account' => array(
            'name' => 'billing_account',
            'width' => '10%',
        ),
        'total_amount' => array(
            'name' => 'total_amount',
            'width' => '10%',
        ),
        'expiration' => array(
            'name' => 'expiration',
            'width' => '10%',
        ),
        'term' => array(
            'name' => 'term',
            'width' => '10%',
        ),
        'assigned_user_id' => array(
            'name' => 'assigned_user_id',
            'type' => 'enum',
            'label' => 'LBL_ASSIGNED_TO',
            'function' => array(
                'name' => 'get_user_array',
                'params' => array(
                    0 => false,
                ),
            ),
            'width' => '10%',
        ),
    ),
);
