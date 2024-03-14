<?php
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

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $module_name = 'AOS_Contracts';
//   $searchdefs[$module_name] = array(
//                     'templateMeta' => array(
//                             'maxColumns' => '3',
//                             'maxColumnsBasic' => '4',
//                             'widths' => array('label' => '10', 'field' => '30'),
//                            ),
//                     'layout' => array(
//                         'basic_search' => array(
//                             'name',
//                             array('name'=>'current_user_only', 'label'=>'LBL_CURRENT_USER_FILTER', 'type'=>'bool'),
//                             array('name' => 'favorites_only','label' => 'LBL_FAVORITES_FILTER','type' => 'bool',),

//                             ),
//                         'advanced_search' => array(
//                             'name',
//                             'contract_account',
//                             'opportunity',
//                             'start_date',
//                             'end_date',
//                             'total_contract_value',
//                             'status',
//                             'contract_type',
//                             array('name' => 'assigned_user_id', 'label' => 'LBL_ASSIGNED_TO_NAME', 'type' => 'enum', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
                            
//                         ),
//                     ),
//                );

$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'reference_code' => array(
                'type' => 'varchar',
                'label' => 'LBL_REFERENCE_CODE ',
                'width' => '10%',
                'default' => true,
                'name' => 'reference_code',
            ),
            'status' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'name' => 'status',
            ),
            'total_contract_value' => array(
                'type' => 'currency',
                'label' => 'LBL_TOTAL_CONTRACT_VALUE',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'total_contract_value',
            ),
            'total_amount' => array(
                'type' => 'currency',
                'label' => 'LBL_GRAND_TOTAL',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'total_amount',
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
            'contract_account' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_CONTRACT_ACCOUNT',
                'id' => 'CONTRACT_ACCOUNT_ID',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'contract_account',
            ),
            'assigned_user_id' => array(
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO_NAME',
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
            'reference_code' => array(
                'type' => 'varchar',
                'label' => 'LBL_REFERENCE_CODE ',
                'width' => '10%',
                'default' => true,
                'name' => 'reference_code',
            ),
            'status' => array(
                'name' => 'status',
                'default' => true,
                'width' => '10%',
            ),
            'contract_type' => array(
                'name' => 'contract_type',
                'default' => true,
                'width' => '10%',
            ),
            'currency_id' => array(
                'type' => 'id',
                'studio' => 'visible',
                'label' => 'LBL_CURRENCY',
                'width' => '10%',
                'default' => true,
                'name' => 'currency_id',
            ),
            'total_contract_value' => array(
                'name' => 'total_contract_value',
                'default' => true,
                'width' => '10%',
            ),
            'tax_amount' => array(
                'type' => 'currency',
                'label' => 'LBL_TAX_AMOUNT',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'tax_amount',
            ),
            'shipping_amount' => array(
                'type' => 'currency',
                'label' => 'LBL_SHIPPING_AMOUNT',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_amount',
            ),
            'shipping_tax' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_SHIPPING_TAX',
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_tax',
            ),
            'shipping_tax_amt' => array(
                'type' => 'currency',
                'label' => 'LBL_SHIPPING_TAX_AMT',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_tax_amt',
            ),
            'discount_amount' => array(
                'type' => 'currency',
                'label' => 'LBL_DISCOUNT_AMOUNT',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'discount_amount',
            ),
            'subtotal_amount' => array(
                'type' => 'currency',
                'label' => 'LBL_SUBTOTAL_AMOUNT',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'subtotal_amount',
            ),
            'total_amt' => array(
                'type' => 'currency',
                'label' => 'LBL_TOTAL_AMT',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'total_amt',
            ),
            'total_amount' => array(
                'type' => 'currency',
                'label' => 'LBL_GRAND_TOTAL',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'total_amount',
            ),
            'customer_signed_date' => array(
                'type' => 'date',
                'label' => 'LBL_CUSTOMER_SIGNED_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'customer_signed_date',
            ),
            'company_signed_date' => array(
                'type' => 'date',
                'label' => 'LBL_COMPANY_SIGNED_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'company_signed_date',
            ),
            'start_date' => array(
                'name' => 'start_date',
                'default' => true,
                'width' => '10%',
            ),
            'end_date' => array(
                'name' => 'end_date',
                'default' => true,
                'width' => '10%',
            ),
            'renewal_reminder_date' => array(
                'type' => 'datetimecombo',
                'label' => 'LBL_RENEWAL_REMINDER_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'renewal_reminder_date',
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
            'contract_account' => array(
                'name' => 'contract_account',
                'default' => true,
                'width' => '10%',
            ),
            'opportunity' => array(
                'name' => 'opportunity',
                'default' => true,
                'width' => '10%',
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
                'label' => 'LBL_ASSIGNED_TO_NAME',
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
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'favorites_only',
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
// END STIC-Custom