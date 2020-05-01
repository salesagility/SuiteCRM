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
    'DetailView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    'SEND_CONFIRM_OPT_IN_EMAIL' => EmailAddress::getSendConfirmOptInEmailActionLinkDefs('Contacts'),
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                    3 => 'FIND_DUPLICATES',
                    4 => [
                        'customCode' => '<input type="submit" class="button" title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" onclick="this.form.return_module.value=\'Contacts\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Contacts\';" name="Manage Subscriptions" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/>',
                        'sugar_html' => [
                            'type' => 'submit',
                            'value' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                            'htmlOptions' => [
                                'class' => 'button',
                                'id' => 'manage_subscriptions_button',
                                'title' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                                'onclick' => 'this.form.return_module.value=\'Contacts\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Contacts\';',
                                'name' => 'Manage Subscriptions',
                            ],
                        ],
                    ],
                    'AOS_GENLET' => [
                        'customCode' => '<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_PRINT_AS_PDF}">',
                    ],
                    'AOP_CREATE' => [
                        'customCode' => '{if !$fields.joomla_account_id.value && $AOP_PORTAL_ENABLED}<input type="submit" class="button" onClick="this.form.action.value=\'createPortalUser\';" value="{$MOD.LBL_CREATE_PORTAL_USER}"> {/if}',
                        'sugar_html' => [
                            'type' => 'submit',
                            'value' => '{$MOD.LBL_CREATE_PORTAL_USER}',
                            'htmlOptions' => [
                                'title' => '{$MOD.LBL_CREATE_PORTAL_USER}',
                                'class' => 'button',
                                'onclick' => 'this.form.action.value=\'createPortalUser\';',
                                'name' => 'buttonCreatePortalUser',
                                'id' => 'createPortalUser_button',
                            ],
                            'template' => '{if !$fields.joomla_account_id.value && $AOP_PORTAL_ENABLED}[CONTENT]{/if}',
                        ],
                    ],
                    'AOP_DISABLE' => [
                        'customCode' => '{if $fields.joomla_account_id.value && !$fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}<input type="submit" class="button" onClick="this.form.action.value=\'disablePortalUser\';" value="{$MOD.LBL_DISABLE_PORTAL_USER}"> {/if}',
                        'sugar_html' => [
                            'type' => 'submit',
                            'value' => '{$MOD.LBL_DISABLE_PORTAL_USER}',
                            'htmlOptions' => [
                                'title' => '{$MOD.LBL_DISABLE_PORTAL_USER}',
                                'class' => 'button',
                                'onclick' => 'this.form.action.value=\'disablePortalUser\';',
                                'name' => 'buttonDisablePortalUser',
                                'id' => 'disablePortalUser_button',
                            ],
                            'template' => '{if $fields.joomla_account_id.value && !$fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}[CONTENT]{/if}',
                        ],
                    ],
                    'AOP_ENABLE' => [
                        'customCode' => '{if $fields.joomla_account_id.value && $fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}<input type="submit" class="button" onClick="this.form.action.value=\'enablePortalUser\';" value="{$MOD.LBL_ENABLE_PORTAL_USER}"> {/if}',
                        'sugar_html' => [
                            'type' => 'submit',
                            'value' => '{$MOD.LBL_ENABLE_PORTAL_USER}',
                            'htmlOptions' => [
                                'title' => '{$MOD.LBL_ENABLE_PORTAL_USER}',
                                'class' => 'button',
                                'onclick' => 'this.form.action.value=\'enablePortalUser\';',
                                'name' => 'buttonENablePortalUser',
                                'id' => 'enablePortalUser_button',
                            ],
                            'template' => '{if $fields.joomla_account_id.value && $fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}[CONTENT]{/if}',
                        ],
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
                    'file' => 'modules/Contacts/Contact.js',
                ],
            ],
            'useTabs' => true,
            'tabDefs' => [
                'LBL_CONTACT_INFORMATION' => [
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
            'lbl_contact_information' => [
                0 => [
                    0 => [
                        'name' => 'first_name',
                        'comment' => 'First name of the contact',
                        'label' => 'LBL_FIRST_NAME',
                    ],
                    1 => [
                        'name' => 'last_name',
                        'comment' => 'Last name of the contact',
                        'label' => 'LBL_LAST_NAME',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'phone_work',
                        'label' => 'LBL_OFFICE_PHONE',
                    ],
                    1 => [
                        'name' => 'phone_mobile',
                        'label' => 'LBL_MOBILE_PHONE',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'title',
                        'comment' => 'The title of the contact',
                        'label' => 'LBL_TITLE',
                    ],
                    1 => [
                        'name' => 'department',
                        'label' => 'LBL_DEPARTMENT',
                    ],
                ],
                3 => [
                    0 => [
                        'name' => 'account_name',
                        'label' => 'LBL_ACCOUNT_NAME',
                    ],
                    1 => [
                        'name' => 'phone_fax',
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
                6 => [
                    0 => [
                        'name' => 'description',
                        'comment' => 'Full text of the note',
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
                    1 => [
                        'name' => 'campaign_name',
                        'label' => 'LBL_CAMPAIGN',
                    ],
                ],
            ],
            'LBL_PANEL_ASSIGNMENT' => [
                0 => [
                    0 => [
                        'name' => 'date_entered',
                        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                        'label' => 'LBL_DATE_ENTERED',
                    ],
                    1 => [
                        'name' => 'date_modified',
                        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                        'label' => 'LBL_DATE_MODIFIED',
                    ],
                ],
            ],
        ],
    ],
];
