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

$viewdefs ['ProjectTask'] =
    array(
        'QuickCreate' =>
            array(
                'templateMeta' =>
                    array(
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
                                        'file' => 'modules/ProjectTask/ProjectTask.js',
                                    ),
                            ),
                    ),
                'panels' =>
                    array(
                        'default' =>
                            array(
                                0 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'name',
                                                'label' => 'LBL_NAME',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'project_task_id',
                                                'label' => 'LBL_TASK_ID',
                                            ),
                                    ),
                                1 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'date_start',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'date_finish',
                                            ),
                                    ),
                                2 =>
                                    array(
                                        'name' => 'assigned_user_name',
                                    ),
                                3 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'status',
                                                'customCode' => '<select name="{$fields.status.name}" id="{$fields.status.name}" title="" tabindex="s" onchange="update_percent_complete(this.value);">{if isset($fields.status.value) && $fields.status.value != ""}{html_options options=$fields.status.options selected=$fields.status.value}{else}{html_options options=$fields.status.options selected=$fields.status.default}{/if}</select>',
                                            ),
                                        1 => 'priority',
                                    ),
                                4 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'percent_complete',
                                                'customCode' => '<input type="text" name="{$fields.percent_complete.name}" id="{$fields.percent_complete.name}" size="30" value="{$fields.percent_complete.value}" title="" tabindex="0" onChange="update_status(this.value);" /></tr>',
                                            ),
                                    ),
                                5 =>
                                    array(
                                        0 => 'milestone_flag',
                                    ),
                                6 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'project_name',
                                                'label' => 'LBL_PROJECT_NAME',
                                            ),
                                    ),
                                7 =>
                                    array(
                                        0 => 'task_number',
                                        1 => 'order_number',
                                    ),
                                8 =>
                                    array(
                                        0 => 'estimated_effort',
                                        1 => 'utilization',
                                    ),
                                9 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'description',
                                            ),
                                    ),
                                10 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'duration',
                                                'hideLabel' => true,
                                                'customCode' => '<input type="hidden" name="duration" id="projectTask_duration" value="0" />',
                                            ),
                                    ),
                                11 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'duration_unit',
                                                'hideLabel' => true,
                                                'customCode' => '<input type="hidden" name="duration_unit" id="projectTask_durationUnit" value="Days" />',
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
?>
