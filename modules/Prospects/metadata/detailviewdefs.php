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
$viewdefs['Prospects'] =
[
    'DetailView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    'SEND_CONFIRM_OPT_IN_EMAIL' => EmailAddress::getSendConfirmOptInEmailActionLinkDefs('Prospects'),
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                    3 => [
                        'customCode' => '<input title="{$MOD.LBL_CONVERT_BUTTON_TITLE}" class="button" onclick="this.form.return_module.value=\'Prospects\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\';this.form.module.value=\'Leads\';this.form.action.value=\'EditView\';" type="submit" name="CONVERT_LEAD_BTN" value="{$MOD.LBL_CONVERT_BUTTON_LABEL}"/>',
                        'sugar_html' => [
                            'type' => 'submit',
                            'value' => '{$MOD.LBL_CONVERT_BUTTON_LABEL}',
                            'htmlOptions' => [
                                'class' => 'button',
                                'name' => 'CONVERT_LEAD_BTN',
                                'id' => 'convert_target_button',
                                'title' => '{$MOD.LBL_CONVERT_BUTTON_TITLE}',
                                'onclick' => 'this.form.return_module.value=\'Prospects\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\';this.form.module.value=\'Leads\';this.form.action.value=\'EditView\';',
                            ],
                        ],
                    ],
                    4 => [
                        'customCode' => '<input title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" class="button" onclick="this.form.return_module.value=\'Prospects\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\';" type="submit" name="Manage Subscriptions" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/>',
                        'sugar_html' => [
                            'type' => 'submit',
                            'value' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                            'htmlOptions' => [
                                'class' => 'button',
                                'id' => 'manage_subscriptions_button',
                                'name' => 'Manage Subscriptions',
                                'title' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                                'onclick' => 'this.form.return_module.value=\'Prospects\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\';',
                            ],
                        ],
                    ],
                ],
                'hidden' => [
                    0 => '<input type="hidden" name="prospect_id" value="{$fields.id.value}">',
                ],
                'headerTpl' => 'modules/Prospects/tpls/DetailViewHeader.tpl',
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
            'useTabs' => true,
            'tabDefs' => [
                'LBL_PROSPECT_INFORMATION' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
                'LBL_MORE_INFORMATION' => [
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
            'lbl_prospect_information' => [
                0 => [
                    0 => [
                        'name' => 'full_name',
                    ],
                ],
                1 => [
                    0 => 'title',
                    1 => [
                        'name' => 'phone_work',
                        'label' => 'LBL_OFFICE_PHONE',
                    ],
                ],
                2 => [
                    0 => 'department',
                    1 => 'phone_mobile',
                ],
                3 => [
                    0 => [
                        'name' => 'account_name',
                    ],
                    1 => 'phone_fax',
                ],
                4 => [
                    0 => [
                        'name' => 'primary_address_street',
                        'label' => 'LBL_PRIMARY_ADDRESS',
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'primary',
                        ],
                    ],
                    1 => [
                        'name' => 'alt_address_street',
                        'label' => 'LBL_ALTERNATE_ADDRESS',
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'alt',
                        ],
                    ],
                ],
                5 => [
                    0 => 'email1',
                ],
                6 => [
                    0 => 'description',
                ],
                7 => [
                    0 => 'assigned_user_name',
                ],
            ],
            'LBL_MORE_INFORMATION' => [
                0 => [
                    0 => 'email_opt_out',
                    1 => 'do_not_call',
                ],
            ],
            'LBL_PANEL_ASSIGNMENT' => [
                0 => [
                    0 => [
                        'name' => 'modified_by_name',
                        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}&nbsp;',
                        'label' => 'LBL_DATE_MODIFIED',
                    ],
                    1 => [
                        'name' => 'created_by_name',
                        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}&nbsp;',
                        'label' => 'LBL_DATE_ENTERED',
                    ],
                ],
            ],
        ],
    ],
];
