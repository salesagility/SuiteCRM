<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */


$viewdefs['Accounts'] = [
    'ListView' =>  [
        'sidebarWidgets' => [
            'accounts-new-by-month' => [
                'type' => 'chart',
                'labelKey' => 'LBL_QUICK_CHARTS',
                'options' => [
                    'toggle' => true,
                    'headerTitle' => false,
                    'charts' => [
                        [
                            'chartKey' => 'accounts-new-by-month',
                            'chartType' => 'line-chart',
                            'statisticsType' => 'accounts-new-by-month',
                            'labelKey' => 'ACCOUNT_TYPES_PER_MONTH',
                            'chartOptions' => [
                            ]
                        ]
                    ]
                ],
                'acls' => [
                    'Accounts' => ['view', 'list']
                ]
            ],
        ],
        'bulkActions' => [
            'actions' => [
                'records-to-target-list' => [
                    'key' => 'records-to-target-list',
                    'labelKey' => 'LBL_ADD_TO_PROSPECT_LIST_BUTTON_LABEL',
                    'modes' => ['list'],
                    'acl' => ['edit'],
                    'aclModule' => 'prospect-lists',
                    'params' => [
                        'selectModal' => [
                            'module' => 'ProspectLists'
                        ],
                        'allowAll' => false,
                        'max' => 200
                    ]
                ],
                'contacts-to-target-list' => [
                    'key' => 'contacts-to-target-list',
                    'labelKey' => 'LBL_ADD_TO_PROSPECT_LIST_BUTTON_LABEL_ACCOUNTS_CONTACTS',
                    'modes' => ['list'],
                    'acl' => ['edit'],
                    'aclModule' => 'prospect-lists',
                    'params' => [
                        'selectModal' => [
                            'module' => 'ProspectLists'
                        ],
                        'allowAll' => false,
                        'max' => 200
                    ]
                ],
                'print-as-pdf' => [
                    'key' => 'print-as-pdf',
                    'labelKey' => 'LBL_PRINT_AS_PDF',
                    'modes' => ['list'],
                    'acl' => ['view'],
                    'aclModule' => 'AOS_PDF_Templates',
                    'params' => [
                        'selectModal' => [
                            'module' => 'AOS_PDF_Templates'
                        ],
                        'allowAll' => false,
                        'max' => 50
                    ]
                ]
            ]
        ]
    ]
];


$listViewDefs ['Accounts'] =
array(
  'NAME' =>
  array(
    'width' => '20%',
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'link' => true,
    'default' => true,
  ),
  'BILLING_ADDRESS_CITY' =>
  array(
    'width' => '10%',
    'label' => 'LBL_LIST_CITY',
    'default' => true,
  ),
  'BILLING_ADDRESS_COUNTRY' =>
  array(
    'width' => '10%',
    'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
    'default' => true,
  ),
  'PHONE_OFFICE' =>
  array(
    'width' => '10%',
    'label' => 'LBL_LIST_PHONE',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' =>
  array(
    'width' => '10%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'EMAIL1' =>
  array(
    'width' => '15%',
    'label' => 'LBL_EMAIL_ADDRESS',
    'sortable' => false,
    'link' => true,
    'customCode' => '{$EMAIL1_LINK}',
    'default' => true,
  ),
  'DATE_ENTERED' =>
  array(
    'width' => '5%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
  ),
  'ACCOUNT_TYPE' =>
  array(
    'width' => '10%',
    'label' => 'LBL_TYPE',
    'default' => false,
  ),
  'INDUSTRY' =>
  array(
    'width' => '10%',
    'label' => 'LBL_INDUSTRY',
    'default' => false,
  ),
  'ANNUAL_REVENUE' =>
  array(
    'width' => '10%',
    'label' => 'LBL_ANNUAL_REVENUE',
    'default' => false,
  ),
  'PHONE_FAX' =>
  array(
    'width' => '10%',
    'label' => 'LBL_PHONE_FAX',
    'default' => false,
  ),
  'BILLING_ADDRESS_STREET' =>
  array(
    'width' => '15%',
    'label' => 'LBL_BILLING_ADDRESS_STREET',
    'default' => false,
  ),
  'BILLING_ADDRESS_STATE' =>
  array(
    'width' => '7%',
    'label' => 'LBL_BILLING_ADDRESS_STATE',
    'default' => false,
  ),
  'BILLING_ADDRESS_POSTALCODE' =>
  array(
    'width' => '10%',
    'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_STREET' =>
  array(
    'width' => '15%',
    'label' => 'LBL_SHIPPING_ADDRESS_STREET',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_CITY' =>
  array(
    'width' => '10%',
    'label' => 'LBL_SHIPPING_ADDRESS_CITY',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_STATE' =>
  array(
    'width' => '7%',
    'label' => 'LBL_SHIPPING_ADDRESS_STATE',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_POSTALCODE' =>
  array(
    'width' => '10%',
    'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_COUNTRY' =>
  array(
    'width' => '10%',
    'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
    'default' => false,
  ),
  'RATING' =>
  array(
    'width' => '10%',
    'label' => 'LBL_RATING',
    'default' => false,
  ),
  'PHONE_ALTERNATE' =>
  array(
    'width' => '10%',
    'label' => 'LBL_OTHER_PHONE',
    'default' => false,
  ),
  'WEBSITE' =>
  array(
    'width' => '10%',
    'label' => 'LBL_WEBSITE',
    'default' => false,
  ),
  'OWNERSHIP' =>
  array(
    'width' => '10%',
    'label' => 'LBL_OWNERSHIP',
    'default' => false,
  ),
  'EMPLOYEES' =>
  array(
    'width' => '10%',
    'label' => 'LBL_EMPLOYEES',
    'default' => false,
  ),
  'SIC_CODE' =>
  array(
    'width' => '10%',
    'label' => 'LBL_SIC_CODE',
    'default' => false,
  ),
  'TICKER_SYMBOL' =>
  array(
    'width' => '10%',
    'label' => 'LBL_TICKER_SYMBOL',
    'default' => false,
  ),
  'DATE_MODIFIED' =>
  array(
    'width' => '5%',
    'label' => 'LBL_DATE_MODIFIED',
    'default' => false,
  ),
  'CREATED_BY_NAME' =>
  array(
    'width' => '10%',
    'label' => 'LBL_CREATED',
    'default' => false,
  ),
  'MODIFIED_BY_NAME' =>
  array(
    'width' => '10%',
    'label' => 'LBL_MODIFIED',
    'default' => false,
  ),
);
