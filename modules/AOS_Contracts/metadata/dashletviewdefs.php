<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
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
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

global $current_user;

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $dashletData['AOS_ContractsDashlet']['searchFields'] =
// array(
// 'status' =>
//     array(
//         'default' => ''
//         ),
// 'end_date' =>
//     array(
//         'default' => ''
//         ),
// 'assigned_user_id' =>
//     array(
//         'type' => 'assigned_user_name',
//         'default' => $current_user->name
//         )
//     );
    
// $dashletData['AOS_ContractsDashlet']['columns'] =
// array(
// 'name' =>
//     array(
//         'width'   => '25',
//         'label'   => 'LBL_LIST_NAME',
//         'link'    => true,
//         'default' => true
//         ),
// 'status' =>
//     array(
//         'width'   => '12',
//         'label'   => 'LBL_STATUS',
//         'default' => true
//         ),
// 'total_contract_value'=>
//     array(
//         'width'   => '12',
//         'label'   => 'LBL_TOTAL_CONTRACT_VALUE',
//         'currency_format' => true,
//         'default' => true
//         ),
// 'start_date' =>
//     array(
//         'width'   => '12',
//         'label'   => 'LBL_START_DATE'
//         ),
// 'end_date' =>
//     array(
//         'width'   => '12',
//         'label'   => 'LBL_END_DATE',
//         'default' => true
//         ),
// 'renewal_reminder_date'=>
//     array(
//         'width'   => '15',
//         'label'   => 'LBL_RENEWAL_REMINDER_DATE'
//         ),
// 'assigned_user_name' =>
//     array(
//         'width'   => '12',
//         'label'   => 'LBL_ASSIGNED_TO_NAME'
//         ),
// 'created_by' =>
//     array(
//         'width'   => '8',
//         'label'   => 'LBL_CREATED'
//         ),
// 'date_entered' =>
//     array(
//         'width'   => '15',
//         'label'   => 'LBL_DATE_ENTERED'
//         ),
// 'date_modified' =>
//     array(
//         'width'   => '15',
//         'label'   => 'LBL_DATE_MODIFIED'
//         ),
//     );

$dashletData['AOS_ContractsDashlet']['searchFields'] = array(
    'status' => array(
        'default' => '',
    ),
    'renewal_reminder_date' => array(
        'default' => '',
    ),
    'end_date' => array(
        'default' => '',
    ),
    'assigned_user_id' => array(
        'default' => '',
    ),
);
$dashletData['AOS_ContractsDashlet']['columns'] = array(
    'name' => array(
        'width' => '25%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ),
    'status' => array(
        'width' => '12%',
        'label' => 'LBL_STATUS',
        'default' => true,
        'name' => 'status',
    ),
    'total_contract_value' => array(
        'width' => '12%',
        'label' => 'LBL_TOTAL_CONTRACT_VALUE',
        'currency_format' => true,
        'default' => true,
        'name' => 'total_contract_value',
    ),
    'end_date' => array(
        'width' => '12%',
        'label' => 'LBL_END_DATE',
        'default' => true,
        'name' => 'end_date',
    ),
    'reference_code' => array(
        'type' => 'varchar',
        'label' => 'LBL_REFERENCE_CODE ',
        'width' => '10%',
        'default' => false,
    ),
    'contract_type' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_CONTRACT_TYPE',
        'width' => '10%',
    ),
    'description' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'contract_account' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_CONTRACT_ACCOUNT',
        'id' => 'CONTRACT_ACCOUNT_ID',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'opportunity' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_OPPORTUNITY',
        'id' => 'OPPORTUNITY_ID',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'contact' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_CONTACT',
        'id' => 'CONTACT_ID',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'currency_id' => array(
        'type' => 'id',
        'studio' => 'visible',
        'label' => 'LBL_CURRENCY',
        'width' => '10%',
        'default' => false,
    ),
    'tax_amount' => array(
        'type' => 'currency',
        'label' => 'LBL_TAX_AMOUNT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'discount_amount' => array(
        'type' => 'currency',
        'label' => 'LBL_DISCOUNT_AMOUNT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'shipping_tax_amt' => array(
        'type' => 'currency',
        'label' => 'LBL_SHIPPING_TAX_AMT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'shipping_tax' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SHIPPING_TAX',
        'width' => '10%',
        'default' => false,
    ),
    'shipping_amount' => array(
        'type' => 'currency',
        'label' => 'LBL_SHIPPING_AMOUNT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'subtotal_amount' => array(
        'type' => 'currency',
        'label' => 'LBL_SUBTOTAL_AMOUNT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'total_amt' => array(
        'type' => 'currency',
        'label' => 'LBL_TOTAL_AMT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'total_amount' => array(
        'type' => 'currency',
        'label' => 'LBL_GRAND_TOTAL',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'start_date' => array(
        'width' => '12%',
        'label' => 'LBL_START_DATE',
        'name' => 'start_date',
        'default' => false,
    ),
    'company_signed_date' => array(
        'type' => 'date',
        'label' => 'LBL_COMPANY_SIGNED_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'customer_signed_date' => array(
        'type' => 'date',
        'label' => 'LBL_CUSTOMER_SIGNED_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'renewal_reminder_date' => array(
        'width' => '15%',
        'label' => 'LBL_RENEWAL_REMINDER_DATE',
        'name' => 'renewal_reminder_date',
        'default' => false,
    ),
    'assigned_user_name' => array(
        'width' => '12%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'name' => 'assigned_user_name',
        'default' => false,
    ),
    'created_by' => array(
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ),
    'created_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
    ),
    'date_entered' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'name' => 'date_entered',
        'default' => false,
    ),
    'modified_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
    ),
    'date_modified' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ),
);
// END STIC-Custom