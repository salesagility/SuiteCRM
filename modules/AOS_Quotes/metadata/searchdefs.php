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

$module_name = 'AOS_Quotes';
$_module_name = 'aos_quotes';

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
  // $searchdefs[$module_name] = array(
  //                   'templateMeta' => array(
  //                           'maxColumns' => '3',
  //                           'widths' => array('label' => '10', 'field' => '30'),
  //                          ),
  //                   'layout' => array(
  //                               'basic_search' =>
  //                       array(
  //                         'name' =>
  //                         array(
  //                           'name' => 'name',
  //                           'default' => true,
  //                           'width' => '10%',
  //                         ),
  //                         'current_user_only' =>
  //                         array(
  //                           'name' => 'current_user_only',
  //                           'label' => 'LBL_CURRENT_USER_FILTER',
  //                           'type' => 'bool',
  //                           'default' => true,
  //                           'width' => '10%',
  //                         ),
  //                           'favorites_only' => array('name' => 'favorites_only','label' => 'LBL_FAVORITES_FILTER','type' => 'bool',),

  //                       ),
  //                       'advanced_search' => array(
  //                           'name',
  //                           'billing_contact',
  //                           'billing_account',
  //                           'number',
  //                           'total_amount',
  //                           'expiration',
  //                           'stage',
  //                           'term',
  //                           array('name' => 'assigned_user_id', 'type' => 'enum', 'label' => 'LBL_ASSIGNED_TO', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
  //                       ),
  //                   ),
  //              );

$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'number' => array(
                'type' => 'int',
                'label' => 'LBL_QUOTE_NUMBER',
                'width' => '10%',
                'default' => true,
                'name' => 'number',
            ),
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'stage' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STAGE',
                'width' => '10%',
                'name' => 'stage',
            ),
            'approval_status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_APPROVAL_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'approval_status',
            ),
            'invoice_status' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_INVOICE_STATUS',
                'width' => '10%',
                'name' => 'invoice_status',
            ),
            'total_amount' => array(
                'type' => 'currency',
                'label' => 'LBL_GRAND_TOTAL',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'total_amount',
            ),
            'expiration' => array(
                'type' => 'date',
                'label' => 'LBL_EXPIRATION',
                'width' => '10%',
                'default' => true,
                'name' => 'expiration',
            ),
            'billing_contact' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_BILLING_CONTACT',
                'id' => 'BILLING_CONTACT_ID',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'billing_contact',
            ),
            'billing_account' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_BILLING_ACCOUNT',
                'id' => 'BILLING_ACCOUNT_ID',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'billing_account',
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
            'number' => array(
                'name' => 'number',
                'default' => true,
                'width' => '10%',
            ),
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'stage' => array(
                'name' => 'stage',
                'default' => true,
                'width' => '10%',
            ),
            'approval_status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_APPROVAL_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'approval_status',
            ),
            'invoice_status' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_INVOICE_STATUS',
                'width' => '10%',
                'name' => 'invoice_status',
            ),
            'currency_id' => array(
                'type' => 'id',
                'studio' => 'visible',
                'label' => 'LBL_CURRENCY',
                'width' => '10%',
                'default' => true,
                'name' => 'currency_id',
            ),
            'tax_amount' => array(
                'type' => 'currency',
                'label' => 'LBL_TAX_AMOUNT',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'tax_amount',
            ),
            'shipping_tax_amt' => array(
                'type' => 'currency',
                'label' => 'LBL_SHIPPING_TAX_AMT',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_tax_amt',
            ),
            'shipping_tax' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_SHIPPING_TAX',
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_tax',
            ),
            'shipping_amount' => array(
                'type' => 'currency',
                'label' => 'LBL_SHIPPING_AMOUNT',
                'currency_format' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_amount',
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
                'name' => 'total_amount',
                'default' => true,
                'width' => '10%',
            ),
            'expiration' => array(
                'name' => 'expiration',
                'default' => true,
                'width' => '10%',
            ),
            'terms_c' => array(
                'type' => 'text',
                'studio' => 'visible',
                'label' => 'LBL_TERMS_C',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'terms_c',
            ),
            'approval_issue' => array(
                'type' => 'text',
                'studio' => 'visible',
                'label' => 'LBL_APPROVAL_ISSUE',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'approval_issue',
            ),
            'billing_contact' => array(
                'name' => 'billing_contact',
                'default' => true,
                'width' => '10%',
            ),
            'billing_account' => array(
                'name' => 'billing_account',
                'default' => true,
                'width' => '10%',
            ),
            'opportunity' => array(
                'type' => 'relate',
                'studio' => 'visible',
                'label' => 'LBL_OPPORTUNITY',
                'id' => 'OPPORTUNITY_ID',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'opportunity',
            ),
            'billing_address_street' => array(
                'type' => 'varchar',
                'label' => 'LBL_BILLING_ADDRESS_STREET',
                'width' => '10%',
                'default' => true,
                'name' => 'billing_address_street',
            ),
            'billing_address_postalcode' => array(
                'type' => 'varchar',
                'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
                'width' => '10%',
                'default' => true,
                'name' => 'billing_address_postalcode',
            ),
            'billing_address_city' => array(
                'type' => 'varchar',
                'label' => 'LBL_BILLING_ADDRESS_CITY',
                'width' => '10%',
                'default' => true,
                'name' => 'billing_address_city',
            ),
            'billing_address_state' => array(
                'type' => 'varchar',
                'label' => 'LBL_BILLING_ADDRESS_STATE',
                'width' => '10%',
                'default' => true,
                'name' => 'billing_address_state',
            ),
            'billing_address_country' => array(
                'type' => 'varchar',
                'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
                'width' => '10%',
                'default' => true,
                'name' => 'billing_address_country',
            ),
            'shipping_address_street' => array(
                'type' => 'varchar',
                'label' => 'LBL_SHIPPING_ADDRESS_STREET',
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_address_street',
            ),
            'shipping_address_postalcode' => array(
                'type' => 'varchar',
                'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_address_postalcode',
            ),
            'shipping_address_city' => array(
                'type' => 'varchar',
                'label' => 'LBL_SHIPPING_ADDRESS_CITY',
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_address_city',
            ),
            'shipping_address_state' => array(
                'type' => 'varchar',
                'label' => 'LBL_SHIPPING_ADDRESS_STATE',
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_address_state',
            ),
            'shipping_address_country' => array(
                'type' => 'varchar',
                'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_address_country',
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
                'type' => 'enum',
                'label' => 'LBL_ASSIGNED_TO',
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
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
);
// END STIC-Custom