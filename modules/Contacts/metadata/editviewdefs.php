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
$viewdefs['Contacts'] =
[
    'EditView' => [
        'templateMeta' => [
            'form' => [
                'hidden' => [
                    0 => '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                    1 => '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                    2 => '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                    3 => '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                    4 => '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
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
            'useTabs' => false,
            'tabDefs' => [
                'LBL_CONTACT_INFORMATION' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_ADVANCED' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
        ],
        'panels' => [
            'lbl_contact_information' => [
                0 => [
                    0 => [
                        'name' => 'first_name',
                        'customCode' => '{html_options name="salutation" id="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name"  id="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
                    ],
                    1 => [
                        'name' => 'last_name',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'phone_work',
                        'comment' => 'Work phone number of the contact',
                        'label' => 'LBL_OFFICE_PHONE',
                    ],
                    1 => [
                        'name' => 'phone_mobile',
                        'comment' => 'Mobile phone number of the contact',
                        'label' => 'LBL_MOBILE_PHONE',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'title',
                        'comment' => 'The title of the contact',
                        'label' => 'LBL_TITLE',
                    ],
                    1 => 'department',
                ],
                3 => [
                    0 => [
                        'name' => 'account_name',
                        'displayParams' => [
                            'key' => 'billing',
                            'copy' => 'primary',
                            'billingKey' => 'primary',
                            'additionalFields' => [
                                'phone_office' => 'phone_work',
                            ],
                        ],
                    ],
                    1 => [
                        'name' => 'phone_fax',
                        'comment' => 'Contact fax number',
                        'label' => 'LBL_FAX_PHONE',
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'email1',
                        'studio' => 'false',
                        'label' => 'LBL_EMAIL_ADDRESS',
                    ],
                ],
                5 => [
                    0 => [
                        'name' => 'primary_address_street',
                        'hideLabel' => true,
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'primary',
                            'rows' => 2,
                            'cols' => 30,
                            'maxlength' => 150,
                        ],
                    ],
                    1 => [
                        'name' => 'alt_address_street',
                        'hideLabel' => true,
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'alt',
                            'copy' => 'primary',
                            'rows' => 2,
                            'cols' => 30,
                            'maxlength' => 150,
                        ],
                    ],
                ],
                6 => [
                    0 => [
                        'name' => 'description',
                        'label' => 'LBL_DESCRIPTION',
                    ],
                    1 => '',
                ],
                7 => [
                    0 => [
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO_NAME',
                    ],
                ],
            ],
            'LBL_PANEL_ADVANCED' => [
                0 => [
                    0 => [
                        'name' => 'lead_source',
                        'comment' => 'How did the contact come about',
                        'label' => 'LBL_LEAD_SOURCE',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'report_to_name',
                        'label' => 'LBL_REPORTS_TO',
                    ],
                    1 => 'campaign_name',
                ],
            ],
        ],
    ],
];
