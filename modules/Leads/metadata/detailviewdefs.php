<?php
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

$viewdefs ['Leads'] =
    array(
        'DetailView' =>
            array(
                'templateMeta' =>
                    array(
                        'form' =>
                            array(
                                'buttons' =>
                                    array(
                                        'SEND_CONFIRM_OPT_IN_EMAIL' => EmailAddress::getSendConfirmOptInEmailActionLinkDefs('Leads'),
                                        0 => 'EDIT',
                                        1 => 'DUPLICATE',
                                        2 => 'DELETE',
                                        3 =>
                                            array(
                                                'customCode' => '{if $bean->aclAccess("edit") && !$DISABLE_CONVERT_ACTION}<input title="{$MOD.LBL_CONVERTLEAD_TITLE}" accessKey="{$MOD.LBL_CONVERTLEAD_BUTTON_KEY}" type="button" class="button" onClick="document.location=\'index.php?module=Leads&action=ConvertLead&record={$fields.id.value}\'" name="convert" value="{$MOD.LBL_CONVERTLEAD}">{/if}',
                                                'sugar_html' =>
                                                    array(
                                                        'type' => 'button',
                                                        'value' => '{$MOD.LBL_CONVERTLEAD}',
                                                        'htmlOptions' =>
                                                            array(
                                                                'title' => '{$MOD.LBL_CONVERTLEAD_TITLE}',
                                                                'accessKey' => '{$MOD.LBL_CONVERTLEAD_BUTTON_KEY}',
                                                                'class' => 'button',
                                                                'onClick' => 'document.location=\'index.php?module=Leads&action=ConvertLead&record={$fields.id.value}\'',
                                                                'name' => 'convert',
                                                                'id' => 'convert_lead_button',
                                                            ),
                                                        'template' => '{if $bean->aclAccess("edit") && !$DISABLE_CONVERT_ACTION}[CONTENT]{/if}',
                                                    ),
                                            ),
                                        4 => 'FIND_DUPLICATES',
                                        5 =>
                                            array(
                                                'customCode' => '<input title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" class="button" onclick="this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'DetailView\';this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Leads\';" type="submit" name="Manage Subscriptions" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}">',
                                                'sugar_html' =>
                                                    array(
                                                        'type' => 'submit',
                                                        'value' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                                                        'htmlOptions' =>
                                                            array(
                                                                'title' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                                                                'class' => 'button',
                                                                'id' => 'manage_subscriptions_button',
                                                                'onclick' => 'this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'DetailView\';this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Leads\';',
                                                                'name' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                                                            ),
                                                    ),
                                            ),
                                        'AOS_GENLET' =>
                                            array(
                                                'customCode' => '<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_PRINT_AS_PDF}">',
                                            ),
                                    ),
                                'headerTpl' => 'modules/Leads/tpls/DetailViewHeader.tpl',
                            ),
                        'maxColumns' => '2',
                        'widths' =>
                            array(
                                0 =>
                                    array(
                                        'label' => '10',
                                        'field' => '30',
                                    ),
                                1 =>
                                    array(
                                        'label' => '10',
                                        'field' => '30',
                                    ),
                            ),
                        'includes' =>
                            array(
                                0 =>
                                    array(
                                        'file' => 'modules/Leads/Lead.js',
                                    ),
                            ),
                        'useTabs' => true,
                        'tabDefs' =>
                            array(
                                'LBL_CONTACT_INFORMATION' =>
                                    array(
                                        'newTab' => true,
                                        'panelDefault' => 'expanded',
                                    ),
                                'LBL_PANEL_ADVANCED' =>
                                    array(
                                        'newTab' => true,
                                        'panelDefault' => 'expanded',
                                    ),
                                'LBL_PANEL_ASSIGNMENT' =>
                                    array(
                                        'newTab' => true,
                                        'panelDefault' => 'expanded',
                                    ),
                            ),
                    ),
                'summaryTemplates' => [
                    'edit' => 'LBL_SUMMARY_PERSON',
                    'detail' => 'LBL_SUMMARY_PERSON',
                ],
                'topWidget' => [
                    'type' => 'statistics',
                    'options' => [
                        'statistics' => [
                            [
                                'labelKey' => 'LBL_DAYS_OPEN',
                                'type' => 'lead-days-open'
                            ],
                        ],
                    ],
                    'acls' => [
                        'Leads' => ['view', 'list']
                    ]
                ],
                'sidebarWidgets' => [
                    [
                        'type' => 'history-timeline',
                        'acls' => [
                            'Leads' => ['view', 'list']
                        ]
                    ],
                ],
                'recordActions' => [
                    'actions' => [
                        'convert-lead' => [
                            'key' => 'convert-lead',
                            'labelKey' => 'LBL_CONVERTLEAD',
                            'asyncProcess' => true,
                            'params' => [],
                            'modes' => ['detail'],
                            'acl' => ['edit'],
                        ],

                        'print-as-pdf' => [
                            'key' => 'print-as-pdf',
                            'labelKey' => 'LBL_PRINT_AS_PDF',
                            'asyncProcess' => true,
                            'modes' => ['detail'],
                            'acl' => ['view'],
                            'aclModule' => 'AOS_PDF_Templates',
                            'params' => [
                                'selectModal' => [
                                    'module' => 'AOS_PDF_Templates'
                                ]
                            ]
                        ]
                    ]
                ],
                'panels' =>
                    array(
                        'LBL_CONTACT_INFORMATION' =>
                            array(
                                0 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'full_name',
                                                'label' => 'LBL_NAME',
                                            ),
                                        1 => 'phone_work',
                                    ),
                                1 =>
                                    array(
                                        0 => 'title',
                                        1 => 'phone_mobile',
                                    ),
                                2 =>
                                    array(
                                        0 => 'department',
                                        1 => 'phone_fax',
                                    ),
                                3 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'account_name',
                                            ),
                                        1 => 'website',
                                    ),
                                4 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'primary_address_street',
                                                'label' => 'LBL_PRIMARY_ADDRESS',
                                                'type' => 'address',
                                                'displayParams' =>
                                                    array(
                                                        'key' => 'primary',
                                                    ),
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'alt_address_street',
                                                'label' => 'LBL_ALTERNATE_ADDRESS',
                                                'type' => 'address',
                                                'displayParams' =>
                                                    array(
                                                        'key' => 'alt',
                                                    ),
                                            ),
                                    ),
                                5 =>
                                    array(
                                        0 => 'email1',
                                    ),
                                6 =>
                                    array(
                                        0 => 'description',
                                    ),
                                7 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'assigned_user_name',
                                                'label' => 'LBL_ASSIGNED_TO',
                                            ),
                                    ),
                            ),
                        'LBL_PANEL_ADVANCED' =>
                            array(
                                0 =>
                                    array(
                                        0 => 'status',
                                        1 => 'lead_source',
                                    ),
                                1 =>
                                    array(
                                        0 => 'status_description',
                                        1 => 'lead_source_description',
                                    ),
                                2 =>
                                    array(
                                        0 => 'opportunity_amount',
                                        1 => 'refered_by',
                                    ),
                                3 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'campaign_name',
                                                'label' => 'LBL_CAMPAIGN',
                                            ),
                                    ),
                            ),
                        'LBL_PANEL_ASSIGNMENT' =>
                            array(
                                0 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'date_modified',
                                                'label' => 'LBL_DATE_MODIFIED',
                                                'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'date_entered',
                                                'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
