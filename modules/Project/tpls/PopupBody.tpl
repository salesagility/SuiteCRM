{*
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
*}
{sugar_include type="smarty" file="modules/Project/tpls/PopupHeader.tpl"}

<!--Create task pop-up-->
<div style="display: none;">
    <div id="dialog" title="{$mod.LBL_ADD_NEW_TASK}">
        <p>
            {$mod.LBL_EDIT_TASK_PROPERTIES}
        </p>
        <form id="popup_form" class="projects-gantt-chart-popup">
            <fieldset>
                <table width="100%">
                    <tr>
                        <td>

                            <input type="hidden" name="project_id" id="project_id" value="{$projectID}">
                            <input type="hidden" name="consider_business_hours" id="consider_business_hours"
                                   value="{$projectBusinessHours}">
                            <input type="hidden" name="task_id" style="display: none; visibility: collapse;"
                                   id="task_id" value="">

                            <input type="radio" name="Milestone" value="Subtask" checked="checked" id="Subtask"/>
                            <label id="Subtask_label" for="Subtask">{$mod.LBL_SUBTASK}</label>
                            <input type="radio" name="Milestone" value="Milestone" id="Milestone"/>

                            <label id="Milestone_label" for="Milestone">{$mod.LBL_MILESTONE_FLAG}</label>
                            <label id="parent_task_id" for="parent_task"
                                   style="display: none; visibility: collapse;">{$mod.LBL_PARENT_TASK_ID}</label>
                            <input id="parent_task" class="text ui-widget-content ui-corner-all"
                                   style="display: none; visibility: collapse;" type="text" name="parent_task"
                                   value=""/>

                            <label for="task_name">{$mod.LBL_TASK_NAME}</label>
                            <input type="text" name="task_name" id="task_name"
                                   class="text ui-widget-content ui-corner-all"/>

                            <label for="Predecessor">{$mod.LBL_PREDECESSORS}</label>
                            <select id="Predecessor" name="Predecessor"
                                    class="text ui-widget-content ui-corner-all"></select>

                            <label for="relation_type">{$mod.LBL_RELATIONSHIP_TYPE}</label>
                            <select id="relation_type" name="relation_type"
                                    class="text ui-widget-content ui-corner-all">{$relationshipDropdown}</select>

                            <label for="Lag">{$mod.LBL_LAG}</label>
                            <input type="text" name="Lag" value="0" id="Lag"
                                   class="text ui-widget-content ui-corner-all"/>

                            <label for="Lag_unit"></label><select id="Lag_unit" name="Lag_unit" class="text ui-widget-content ui-corner-all">
                                <option value="Days">{$mod.LBL_DAYS}</option>
                            </select>

                            <label for="Start">{$mod.LBL_START}</label>
                            <input type="text" name="Start" id="Start" value=""
                                   class="text ui-widget-content ui-corner-all"/>

                            <script type="text/javascript">
                              Calendar.setup({literal}{{/literal}
                                inputField: "Start",
                                ifFormat: "{$CALENDAR_DATEFORMAT}",
                                daFormat: "{$CALENDAR_DATEFORMAT}",
                                button: "Start",
                                singleClick: true,
                                step: 1,
                                weekNumbers: false,
                                startWeekday: 0
                                  {literal}}{/literal});
                            </script>

                        </td>
                        <td>

                            <label for="Duration">{$mod.LBL_DURATION_TITLE}</label>
                            <input type="text" name="Duration" id="Duration"
                                   class="text ui-widget-content ui-corner-all"/>
                            <label for="Duration_unit"></label><select id="Duration_unit" name="Duration_unit"
                                                                       class="text ui-widget-content ui-corner-all">
                                {$durationDropDown}</select>


                            <label for="assigned_user_name">{$mod.LBL_ASSIGNED_USER_ID}</label>
                            <input name="assigned_user_name" id="assigned_user_name" class="text ui-widget-content ui-corner-all" value="{$currentUserName}" type="text">
                            <input name="assigned_user_id" id="assigned_user_id" value="{$currentUserId}" type="hidden">

                            <input name="btn_assigned_user_name" title="{$app.LBL_SELECT_BUTTON_TITLE}" class="button" value="{$app.LBL_SELECT_BUTTON_LABEL}" onclick='open_popup("Users", 600, 400, "", true, false, {literal}{"call_back_function":"set_return","form_name":"Distribute","field_to_name_array":{"id":"assigned_user_id","name":"assigned_user_name"}}{/literal}, "single", true);' type="button">
                            <input name="btn_clr_assigned_user_name" title="{$app.LBL_CLEAR_BUTTON_TITLE}" class="button" value="{$app.LBL_CLEAR_BUTTON_LABEL}" onclick="this.form.assigned_user_name.value = ''; this.form.assigned_user_id.value = '';" type="button">



                            <label for="Complete">{$mod.LBL_PERCENT_COMPLETE}</label>
                            <input type="text" name="Complete" id="Complete" value="0"
                                   class="text ui-widget-content ui-corner-all"/>
                            <label for="Actual_duration">{$mod.LBL_ACTUAL_DURATION}</label>
                            <input type="text" name="Actual_duration" id="Actual_duration" value=""
                                   class="text ui-widget-content ui-corner-all"/>
                            <input type="hidden" name="Notes" id="Notes"/>

                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
    <!--Delete task pop-up-->
    <div id="delete_dialog" title="">
        <p>
            Are you sure you want to delete this task?
        </p>
    </div>
</div>
<!-- Pop-up End -->

<div id="wrapper">
    {if $showButton === true}
        <div><button id="add_button" class="gantt_button">{$mod.LBL_ADD_NEW_TASK}</button></div>
        <input id="is_editable" name="is_editable" type="hidden" value="1" >
    {/if}

    <input id="project_id" type="hidden" name="project_id" value="{$projectTasks}"/>
    <div id="project_wrapper"></div>
</div>
<!--Main body end-->

{sugar_include type="smarty" file="modules/Project/tpls/PopupFooter.tpl"}