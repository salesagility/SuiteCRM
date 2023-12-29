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
// created: 2020-07-04 10:28:56
$searchdefs['Opportunities'] = array(
    'templateMeta' => array(
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
    'layout' => array(
        'basic_search' => array(
            0 => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            1 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_STATUS',
                'width' => '10%',
                'name' => 'stic_status_c',
            ),
            2 => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_ACCOUNT_NAME',
                'id' => 'ACCOUNT_ID',
                'name' => 'account_name',
                'default' => true,
                'width' => '10%',
            ),
            3 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_TYPE',
                'width' => '10%',
                'name' => 'stic_type_c',
            ),
            4 => array(
                'type' => 'currency',
                'default' => true,
                'label' => 'LBL_AMOUNT',
                'currency_format' => true,
                'width' => '10%',
                'name' => 'amount',
            ),
            5 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_TARGET',
                'width' => '10%',
                'name' => 'stic_target_c',
            ),
            6 => array(
                'type' => 'date',
                'default' => true,
                'label' => 'LBL_STIC_PRESENTATION_DATE',
                'width' => '10%',
                'name' => 'stic_presentation_date_c',
            ),
            7 => array(
                'type' => 'date',
                'default' => true,
                'label' => 'LBL_STIC_RESOLUTION_DATE',
                'width' => '10%',
                'name' => 'stic_resolution_date_c',
            ),
            8 => array(
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
            9 => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            10 => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
        'advanced_search' => array(
            0 => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            1 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_STATUS',
                'width' => '10%',
                'name' => 'stic_status_c',
            ),
            2 => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_ACCOUNT_NAME',
                'id' => 'ACCOUNT_ID',
                'name' => 'account_name',
                'default' => true,
                'width' => '10%',
            ),
            3 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_TYPE',
                'width' => '10%',
                'name' => 'stic_type_c',
            ),
            4 => array(
                'type' => 'currency',
                'default' => true,
                'label' => 'LBL_AMOUNT',
                'currency_format' => true,
                'width' => '10%',
                'name' => 'amount',
            ),
            5 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_TARGET',
                'width' => '10%',
                'name' => 'stic_target_c',
            ),
            6 => array(
                'type' => 'date',
                'default' => true,
                'label' => 'LBL_STIC_PRESENTATION_DATE',
                'width' => '10%',
                'name' => 'stic_presentation_date_c',
            ),
            7 => array(
                'type' => 'date',
                'default' => true,
                'label' => 'LBL_STIC_RESOLUTION_DATE',
                'width' => '10%',
                'name' => 'stic_resolution_date_c',
            ),
            8 => array(
                'type' => 'date',
                'default' => true,
                'label' => 'LBL_STIC_PAYMENT_DATE',
                'width' => '10%',
                'name' => 'stic_payment_date_c',
            ),
            9 => array(
                'type' => 'date',
                'default' => true,
                'label' => 'LBL_STIC_JUSTIFICATION_DATE',
                'width' => '10%',
                'name' => 'stic_justification_date_c',
            ),
            10 => array(
                'type' => 'date',
                'default' => true,
                'label' => 'LBL_STIC_ADVANCE_DATE',
                'width' => '10%',
                'name' => 'stic_advance_date_c',
            ),
            11 => array(
                'type' => 'currency',
                'default' => true,
                'label' => 'LBL_STIC_AMOUNT_RECEIVED',
                'currency_format' => true,
                'width' => '10%',
                'name' => 'stic_amount_received_c',
            ),
            12 => array(
                'type' => 'currency',
                'default' => true,
                'label' => 'LBL_STIC_AMOUNT_AWARDED',
                'currency_format' => true,
                'width' => '10%',
                'name' => 'stic_amount_awarded_c',
            ),
            13 => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_PROJECT_OPPORTUNITIES_1_FROM_PROJECT_TITLE',
                'id' => 'PROJECT_OPPORTUNITIES_1PROJECT_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'project_opportunities_1_name',
            ),
            14 => array(
                'type' => 'multienum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_DOCUMENTATION_TO_DELIVER',
                'width' => '10%',
                'name' => 'stic_documentation_to_deliver_c',
            ),
            15 => array(
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
            16 => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            17 => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            18 => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            19 => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            20 => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
            21 => array(
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'favorites_only',
            ),
        ),
    ),
);
