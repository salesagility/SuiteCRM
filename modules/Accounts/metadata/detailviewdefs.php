<?php
/**
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
$viewdefs['Accounts'] =
[
    'DetailView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    'SEND_CONFIRM_OPT_IN_EMAIL' => EmailAddress::getSendConfirmOptInEmailActionLinkDefs('Accounts'),
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                    3 => 'FIND_DUPLICATES',
                    'AOS_GENLET' => [
                        'customCode' => '<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_PRINT_AS_PDF}">',
                    ],
                ],
            ],
            'maxColumns' => '2',
            'widths' => [
                0 => [
                    'label' => '10',
                    'field' => '30',
                ],
                1 => [
                    'label' => '10',
                    'field' => '30',
                ],
            ],
            'includes' => [
                0 => [
                    'file' => 'modules/Accounts/Account.js',
                ],
            ],
            'useTabs' => true,
            'tabDefs' => [
                'LBL_ACCOUNT_INFORMATION' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_ADVANCED' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_ASSIGNMENT' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
            ],
        ],
        'panels' => [
            'lbl_account_information' => [
                0 => [
                    0 => [
                        'name' => 'name',
                        'comment' => 'Name of the Company',
                        'label' => 'LBL_NAME',
                    ],
                    1 => [
                        'name' => 'phone_office',
                        'comment' => 'The office phone number',
                        'label' => 'LBL_PHONE_OFFICE',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'website',
                        'type' => 'link',
                        'label' => 'LBL_WEBSITE',
                        'displayParams' => [
                            'link_target' => '_blank',
                        ],
                    ],
                    1 => [
                        'name' => 'phone_fax',
                        'comment' => 'The fax phone number of this company',
                        'label' => 'LBL_FAX',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'email1',
                        'studio' => 'false',
                        'label' => 'LBL_EMAIL',
                    ],
                ],
                3 => [
                    0 => [
                        'name' => 'billing_address_street',
                        'label' => 'LBL_BILLING_ADDRESS',
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'billing',
                        ],
                    ],
                    1 => [
                        'name' => 'shipping_address_street',
                        'label' => 'LBL_SHIPPING_ADDRESS',
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'shipping',
                        ],
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'description',
                        'comment' => 'Full text of the note',
                        'label' => 'LBL_DESCRIPTION',
                    ],
                ],
                5 => [
                    0 => [
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO',
                    ],
                ],
            ],
            'LBL_PANEL_ADVANCED' => [
                0 => [
                    0 => [
                        'name' => 'account_type',
                        'comment' => 'The Company is of this type',
                        'label' => 'LBL_TYPE',
                    ],
                    1 => [
                        'name' => 'industry',
                        'comment' => 'The company belongs in this industry',
                        'label' => 'LBL_INDUSTRY',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'annual_revenue',
                        'comment' => 'Annual revenue for this company',
                        'label' => 'LBL_ANNUAL_REVENUE',
                    ],
                    1 => [
                        'name' => 'employees',
                        'comment' => 'Number of employees, varchar to accomodate for both number (100) or range (50-100)',
                        'label' => 'LBL_EMPLOYEES',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'parent_name',
                        'label' => 'LBL_MEMBER_OF',
                    ],
                ],
                3 => [
                    0 => 'campaign_name',
                ],
            ],
            'LBL_PANEL_ASSIGNMENT' => [
                0 => [
                    0 => [
                        'name' => 'date_entered',
                        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                    ],
                    1 => [
                        'name' => 'date_modified',
                        'label' => 'LBL_DATE_MODIFIED',
                        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                    ],
                ],
            ],
        ],
    ],
];
