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

$module_name = 'AOS_Quotes';
$_module_name = 'aos_quotes';

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
// END STIC-Custom