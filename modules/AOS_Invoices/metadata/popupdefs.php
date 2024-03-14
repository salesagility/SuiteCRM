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

$module_name = 'AOS_Invoices';
$_module_name = 'aos_invoices';

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $popupMeta = array('moduleMain' => $module_name,
//                         'varName' => $module_name,
//                         'orderBy' => $_module_name.'.name',
//                         'whereClauses' =>
//                             array('name' => $_module_name.'.name',
//                                     'billing_address_city' => $_module_name.'.billing_address_city',
//                                     'phone_office' => $_module_name.'.phone_office'),
//                         'searchInputs' =>
//                             array('name',
//                                   'billing_address_city',
//                                   'phone_office',
//                                   'industry'
                                  
//                             ),
//                         );

$popupMeta = array(
    'moduleMain' => 'AOS_Invoices',
    'varName' => 'AOS_Invoices',
    'orderBy' => 'aos_invoices.name',
    'whereClauses' => array(
        'name' => 'aos_invoices.name',
        'number' => 'aos_invoices.number',
        'quote_number' => 'aos_invoices.quote_number',
        'billing_contact' => 'aos_invoices.billing_contact',
        'billing_account' => 'aos_invoices.billing_account',
        'total_amount' => 'aos_invoices.total_amount',
        'due_date' => 'aos_invoices.due_date',
        'status' => 'aos_invoices.status',
        'quote_date' => 'aos_invoices.quote_date',
        'invoice_date' => 'aos_invoices.invoice_date',
        'assigned_user_id' => 'aos_invoices.assigned_user_id',
    ),
    'searchInputs' => array(
        0 => 'name',
        4 => 'number',
        5 => 'quote_number',
        6 => 'billing_contact',
        7 => 'billing_account',
        8 => 'total_amount',
        9 => 'due_date',
        10 => 'status',
        11 => 'quote_date',
        12 => 'invoice_date',
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
        'quote_number' => array(
            'type' => 'int',
            'label' => 'LBL_QUOTE_NUMBER',
            'width' => '10%',
            'name' => 'quote_number',
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
        'due_date' => array(
            'name' => 'due_date',
            'width' => '10%',
        ),
        'status' => array(
            'name' => 'status',
            'width' => '10%',
        ),
        'quote_date' => array(
            'type' => 'date',
            'label' => 'LBL_QUOTE_DATE',
            'width' => '10%',
            'name' => 'quote_date',
        ),
        'invoice_date' => array(
            'type' => 'date',
            'label' => 'LBL_INVOICE_DATE',
            'width' => '10%',
            'name' => 'invoice_date',
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
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '15%',
            'label' => 'LBL_ACCOUNT_NAME',
            'link' => true,
            'default' => true,
            'name' => 'name',
        ),
        'NUMBER' => array(
            'width' => '5%',
            'label' => 'LBL_LIST_NUM',
            'default' => true,
            'name' => 'number',
        ),
        'QUOTE_NUMBER' => array(
            'type' => 'int',
            'label' => 'LBL_QUOTE_NUMBER',
            'width' => '10%',
            'default' => true,
            'name' => 'quote_number',
        ),
        'STATUS' => array(
            'width' => '10%',
            'label' => 'LBL_STATUS',
            'default' => true,
            'name' => 'status',
        ),
        'TOTAL_AMOUNT' => array(
            'width' => '10%',
            'label' => 'LBL_GRAND_TOTAL',
            'default' => true,
            'currency_format' => true,
            'name' => 'total_amount',
        ),
        'INVOICE_DATE' => array(
            'type' => 'date',
            'label' => 'LBL_INVOICE_DATE',
            'width' => '10%',
            'default' => true,
            'name' => 'invoice_date',
        ),
        'DUE_DATE' => array(
            'width' => '10%',
            'label' => 'LBL_DUE_DATE',
            'default' => true,
            'name' => 'due_date',
        ),
        'BILLING_CONTACT' => array(
            'width' => '11%',
            'label' => 'LBL_BILLING_CONTACT',
            'default' => true,
            'module' => 'Contacts',
            'id' => 'BILLING_CONTACT_ID',
            'link' => true,
            'related_fields' => array(
                0 => 'billing_contact_id',
            ),
            'name' => 'billing_contact',
        ),
        'BILLING_ACCOUNT' => array(
            'width' => '15%',
            'label' => 'LBL_BILLING_ACCOUNT',
            'default' => true,
            'module' => 'Accounts',
            'id' => 'BILLING_ACCOUNT_ID',
            'link' => true,
            'related_fields' => array(
                0 => 'billing_account_id',
            ),
            'name' => 'billing_account',
        ),
        'ASSIGNED_USER_NAME' => array(
            'width' => '10%',
            'label' => 'LBL_ASSIGNED_USER',
            'default' => true,
            'module' => 'Users',
            'id' => 'ASSIGNED_USER_ID',
            'link' => true,
            'related_fields' => array(
                0 => 'assigned_user_id',
            ),
            'name' => 'assigned_user_name',
        ),
    ),
);

// END STIC-Custom