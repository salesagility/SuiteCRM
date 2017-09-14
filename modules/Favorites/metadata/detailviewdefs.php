<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$module_name = 'Favorites';
$viewdefs [$module_name] =
    array(
        'DetailView' =>
            array(
                'templateMeta' =>
                    array(
                        'form' =>
                            array(
                                'buttons' =>
                                    array(
                                        0 => 'EDIT',
                                        1 => 'DUPLICATE',
                                        2 => 'DELETE',
                                        3 => 'FIND_DUPLICATES',
                                    ),
                                'hidden' =>
                                    array(
                                        0 => '<input id="custom_hidden_1" type="hidden" name="custom_hidden_1" value=""/>',
                                        1 => '<input id="custom_hidden_2" type="hidden" name="custom_hidden_2" value=""/>',
                                    ),
                            ),
                        'maxColumns' => '2',
                        'includes' =>
                            array(
                                0 =>
                                    array(
                                        'file' => 'include/javascript/checkbox.js',
                                    ),
                                1 =>
                                    array(
                                        'file' => 'cache/include/javascript/sugar_grp_yui_widgets.js',
                                    ),
                            ),
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
                        'useTabs' => true,
                        'tabDefs' =>
                            array(
                                'LBL_PANEL_OVERVIEW' =>
                                    array(
                                        'newTab' => true,
                                        'panelDefault' => 'expanded',
                                    ),
                                'LBL_EMAIL_INVITE' =>
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
                        'syncDetailEditViews' => true,
                    ),
                'panels' =>
                    array(
                        'LBL_PANEL_OVERVIEW' =>
                            array(
                                0 =>
                                    array(
                                        0 => 'name',
                                        1 =>
                                            array(
                                                'name' => 'fp_event_locations_fp_events_1_name',
                                            ),
                                    ),
                                1 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'date_start',
                                                'comment' => 'Date of start of meeting',
                                                'label' => 'LBL_DATE',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'date_end',
                                                'comment' => 'Date meeting ends',
                                                'label' => 'LBL_DATE_END',
                                            ),
                                    ),
                                2 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'duration',
                                                'customCode' => '{$fields.duration_hours.value}{$MOD.LBL_HOURS_ABBREV} {$fields.duration_minutes.value}{$MOD.LBL_MINSS_ABBREV} ',
                                                'label' => 'LBL_DURATION',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'budget',
                                                'label' => 'LBL_BUDGET',
                                            ),
                                    ),
                                3 =>
                                    array(
                                        0 => 'description',
                                    ),
                                4 =>
                                    array(
                                        0 => 'assigned_user_name',
                                    ),
                            ),
                        'LBL_EMAIL_INVITE' =>
                            array(
                                0 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'invite_templates',
                                                'studio' => 'visible',
                                                'label' => 'LBL_INVITE_TEMPLATES',
                                            ),
                                    ),
                                1 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'accept_redirect',
                                                'label' => 'LBL_ACCEPT_REDIRECT',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'decline_redirect',
                                                'label' => 'LBL_DECLINE_REDIRECT',
                                            ),
                                    ),
                            ),
                        'LBL_PANEL_ASSIGNMENT' =>
                            array(
                                0 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'date_entered',
                                                'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                                                'label' => 'LBL_DATE_ENTERED',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'date_modified',
                                                'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                                                'label' => 'LBL_DATE_MODIFIED',
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
