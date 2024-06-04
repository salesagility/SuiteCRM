{* 
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 *}
{literal}
    <style>
        .modal-calendar-filters {
            text-align: left;
            font-size: 13px;
        }
    </style>
{/literal}
<div class="modal fade modal-calendar-filters" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 class="modal-title">{$MOD.LBL_FILTERS_TITLE}</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form name="form_filters" id="form_filters" method="POST"
                        action="index.php?module=Calendar&action=SaveFilters">
                        <div class="panel panel-default ">
                            <div class="panel-heading  panel-heading-collapse">
                                <a id="subpanel_title_activities" class="" role="button" data-toggle="collapse"
                                    href="#subpanel_filters_sessions">
                                    <div class="col-xs-10 col-sm-11 col-md-11">
                                        <div>
                                            {$MOD.LBL_FILTERS_SESSIONS_TITLE}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div id="subpanel_filters_sessions" class="panel-body panel-collapse collapse in">
                                <table class='table-responsive' >
                                    <input type="hidden" name="view" value="{$view}">
                                    <input type="hidden" name="day" value="{$day}">
                                    <input type="hidden" name="month" value="{$month}">
                                    <input type="hidden" name="year" value="{$year}">
                                    <tr>
                                        <td scope="row" style="width:60%;">
                                            {$MOD.LBL_FILTERS_STIC_SESSIONS_RESPONSIBLE}
                                        </td>
                                        <td>
                                            <input type='text' class='sqsEnabled' name='stic_sessions_responsible_name'
                                                id='stic_sessions_responsible_name' autocomplete='off'
                                                value='{$stic_sessions_responsible_name}' title='' tabindex='3'>
                                            <input type='hidden' name='stic_sessions_responsible_id'
                                                id='stic_sessions_responsible_id'
                                                value='{$stic_sessions_responsible_id}'>
                                            <span class='id-ff multiple'>
                                                <button title='{$MOD.LBL_SELECT_BUTTON_TITLE}' type='button'
                                                    class='button' name='btn_1'
                                                    onclick='openSelectPopup("Contacts", "stic_sessions_responsible")'>
                                                    <span class='suitepicon suitepicon-action-select'></span>
                                                </button>
                                                <button type='button' name='btn_1' class='button lastChild'
                                                    onclick='clearRow(this.form, "stic_sessions_responsible")'>
                                                    <span class='suitepicon suitepicon-action-clear'></span>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" style="width:60%;">
                                            {$MOD.LBL_FILTERS_STIC_SESSIONS_ACTIVITY_TYPE}
                                        </td>
                                        <td>
                                            <select multiple id="stic_sessions_activity_type" name="stic_sessions_activity_type[]" tabindex="102">
                                                {$stic_sessions_activity_type}
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" style="width:60%;">
                                            {$MOD.LBL_FILTERS_STIC_SESSIONS_COLOR}
                                        </td>
                                        <td>
                                            <select multiple id="stic_sessions_color" name="stic_sessions_color[]" tabindex="102">
                                                {$stic_sessions_color}
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" style="width:60%;">
                                            {$MOD.LBL_FILTERS_STIC_SESSIONS_STIC_CENTERS}
                                        </td>
                                        <td>
                                            <input type='text' class='sqsEnabled' name='stic_sessions_stic_centers_name'
                                                id='stic_sessions_stic_centers_name' autocomplete='off'
                                                value='{$stic_sessions_stic_centers_name}' title='' tabindex='3'>
                                            <input type='hidden' name='stic_sessions_stic_centers_id'
                                                id='stic_sessions_stic_centers_id'
                                                value='{$stic_sessions_stic_centers_id}'>
                                            <span class='id-ff multiple'>
                                                <button title='{$MOD.LBL_SELECT_BUTTON_TITLE}' type='button'
                                                    class='button' name='btn_1'
                                                    onclick='openSelectPopup("stic_Centers", "stic_sessions_stic_centers")'>
                                                    <span class='suitepicon suitepicon-action-select'></span>
                                                </button>
                                                <button type='button' name='btn_1' class='button lastChild'
                                                    onclick='clearRow(this.form, "stic_sessions_stic_centers")'>
                                                    <span class='suitepicon suitepicon-action-clear'></span>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" style="width:60%;">
                                            {$MOD.LBL_FILTERS_STIC_SESSIONS_STIC_EVENTS}
                                        </td>
                                        <td>
                                            <input type='text' class='sqsEnabled' name='stic_sessions_stic_events_name'
                                                id='stic_sessions_stic_events_name' autocomplete='off'
                                                value='{$stic_sessions_stic_events_name}' title='' tabindex='3'>
                                            <input type='hidden' name='stic_sessions_stic_events_id'
                                                id='stic_sessions_stic_events_id'
                                                value='{$stic_sessions_stic_events_id}'>
                                            <span class='id-ff multiple'>
                                                <button title='{$MOD.LBL_SELECT_BUTTON_TITLE}' type='button'
                                                    class='button' name='btn_1'
                                                    onclick='openSelectPopup("stic_Events", "stic_sessions_stic_events")'>
                                                    <span class='suitepicon suitepicon-action-select'></span>
                                                </button>
                                                <button type='button' name='btn_1' class='button lastChild'
                                                    onclick='clearRow(this.form, "stic_sessions_stic_events")'>
                                                    <span class='suitepicon suitepicon-action-clear'></span>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" style="width:60%;">
                                            {$MOD.LBL_FILTERS_STIC_SESSIONS_STIC_EVENTS_TYPE}
                                        </td>
                                        <td>
                                            <select multiple id="stic_sessions_stic_events_type" name="stic_sessions_stic_events_type[]" tabindex="102">
                                                {$stic_sessions_stic_events_type}
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            {$MOD.LBL_FILTERS_STIC_SESSIONS_PROJECTS}
                                        </td>
                                        <td>
                                            <input type='text' class='sqsEnabled' name='stic_sessions_projects_name'
                                                id='stic_sessions_projects_name' autocomplete='off'
                                                value='{$stic_sessions_projects_name}' title='' tabindex='3'>
                                            <input type='hidden' name='stic_sessions_projects_id'
                                                id='stic_sessions_projects_id' value='{$stic_sessions_projects_id}'>
                                            <span class='id-ff multiple'>
                                                <button title='{$MOD.LBL_SELECT_BUTTON_TITLE}' type='button'
                                                    class='button' name='btn_1'
                                                    onclick='openSelectPopup("Project", "stic_sessions_projects")'>
                                                    <span class='suitepicon suitepicon-action-select'></span>
                                                </button>
                                                <button type='button' name='btn_1' class='button lastChild'
                                                    onclick='clearRow(this.form, "stic_sessions_projects")'>
                                                    <span class='suitepicon suitepicon-action-clear'></span>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            {$MOD.LBL_FILTERS_STIC_SESSIONS_CONTACTS}
                                        </td>
                                        <td>
                                            <input type='text' class='sqsEnabled' name='stic_sessions_contacts_name'
                                                id='stic_sessions_contacts_name' autocomplete='off'
                                                value='{$stic_sessions_contacts_name}' title='' tabindex='3'>
                                            <input type='hidden' name='stic_sessions_contacts_id'
                                                id='stic_sessions_contacts_id' value='{$stic_sessions_contacts_id}'>
                                            <span class='id-ff multiple'>
                                                <button title='{$MOD.LBL_SELECT_BUTTON_TITLE}' type='button'
                                                    class='button' name='btn_1'
                                                    onclick='openSelectPopup("Contacts", "stic_sessions_contacts")'>
                                                    <span class='suitepicon suitepicon-action-select'></span>
                                                </button>
                                                <button type='button' name='btn_1' class='button lastChild'
                                                    onclick='clearRow(this.form, "stic_sessions_contacts")'>
                                                    <span class='suitepicon suitepicon-action-clear'></span>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="panel-heading  panel-heading-collapse">
                                <a id="subpanel_title_activities" class="" role="button" data-toggle="collapse"
                                    href="#subpanel_filters_followups">
                                    <div class="col-xs-10 col-sm-11 col-md-11">
                                        <div>
                                            {$MOD.LBL_FILTERS_FOLLOWUPS_TITLE}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div id="subpanel_filters_followups" class="panel-body panel-collapse collapse in">
                                <table class='table-responsive' >
                                    <input type="hidden" name="view" value="{$view}">
                                    <input type="hidden" name="day" value="{$day}">
                                    <input type="hidden" name="month" value="{$month}">
                                    <input type="hidden" name="year" value="{$year}">
                                    <tr>
                                        <td scope="row" style="width:60%;">
                                            {$MOD.LBL_FILTERS_STIC_FOLLOWUPS_TYPE}
                                        </td>
                                        <td>
                                            <select multiple id="stic_followups_type" name="stic_followups_type[]" tabindex="102">
                                                {$stic_followups_type}
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" style="width:60%;">
                                            {$MOD.LBL_FILTERS_STIC_FOLLOWUPS_COLOR}
                                        </td>
                                        <td>
                                            <select multiple id="stic_followups_color" name="stic_followups_color[]" tabindex="102">
                                                {$stic_followups_color}
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            {$MOD.LBL_FILTERS_STIC_FOLLOWUPS_CONTACTS}
                                        </td>
                                        <td>
                                            <input type='text' class='sqsEnabled' name='stic_followups_contacts_name'
                                                id='stic_followups_contacts_name' autocomplete='off'
                                                value='{$stic_followups_contacts_name}' title='' tabindex='3'>
                                            <input type='hidden' name='stic_followups_contacts_id'
                                                id='stic_followups_contacts_id' value='{$stic_followups_contacts_id}'>
                                            <span class='id-ff multiple'>
                                                <button title='{$MOD.LBL_SELECT_BUTTON_TITLE}' type='button'
                                                    class='button' name='btn_1'
                                                    onclick='openSelectPopup("Contacts", "stic_followups_contacts")'>
                                                    <span class='suitepicon suitepicon-action-select'></span>
                                                </button>
                                                <button type='button' name='btn_1' class='button lastChild'
                                                    onclick='clearRow(this.form, "stic_followups_contacts")'>
                                                    <span class='suitepicon suitepicon-action-clear'></span>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            {$MOD.LBL_FILTERS_STIC_FOLLOWUPS_PROJECTS}
                                        </td>
                                        <td>
                                            <input type='text' class='sqsEnabled' name='stic_followups_projects_name'
                                                id='stic_followups_projects_name' autocomplete='off'
                                                value='{$stic_followups_projects_name}' title='' tabindex='3'>
                                            <input type='hidden' name='stic_followups_projects_id'
                                                id='stic_followups_projects_id' value='{$stic_followups_projects_id}'>
                                            <span class='id-ff multiple'>
                                                <button title='{$MOD.LBL_SELECT_BUTTON_TITLE}' type='button'
                                                    class='button' name='btn_1'
                                                    onclick='openSelectPopup("Project", "stic_followups_projects")'>
                                                    <span class='suitepicon suitepicon-action-select'></span>
                                                </button>
                                                <button type='button' name='btn_1' class='button lastChild'
                                                    onclick='clearRow(this.form, "stic_followups_projects")'>
                                                    <span class='suitepicon suitepicon-action-clear'></span>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="panel-heading  panel-heading-collapse">
                                <a id="subpanel_title_activities" class="" role="button" data-toggle="collapse"
                                    href="#subpanel_filters_work_calendar">
                                    <div class="col-xs-10 col-sm-11 col-md-11">
                                        <div>
                                            {$MOD.LBL_FILTERS_STIC_WORK_CALENDAR_TITLE}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div id="subpanel_filters_work_calendar" class="panel-body panel-collapse collapse in">
                                <table class='table-responsive' >
                                    <input type="hidden" name="view" value="{$view}">
                                    <input type="hidden" name="day" value="{$day}">
                                    <input type="hidden" name="month" value="{$month}">
                                    <input type="hidden" name="year" value="{$year}">
                                    <tr>                            
                                    <tr>
                                        <td scope="row" style="width:60%;">
                                            {$MOD.LBL_FILTERS_STIC_WORK_CALENDAR_TYPE}
                                        </td>
                                        <td>
                                            <select multiple id="stic_work_calendar_type" name="stic_work_calendar_type[]" tabindex="102">
                                                {$stic_work_calendar_type}
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" style="width:60%;">
                                            {$MOD.LBL_FILTERS_STIC_WORK_CALENDAR_DEPARTMENT}
                                        </td>
                                        <td>
                                            <input type='text' name='stic_work_calendar_assigned_user_department'
                                                id='stic_work_calendar_assigned_user_department' autocomplete='off'
                                                value='{$stic_work_calendar_assigned_user_department}' title='' tabindex='3'>                                        
                                        </td>
                                    </tr>                                                                    
                                </table>
                            </div>                            
                        </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">{$MOD.LBL_CANCEL_BUTTON}</button>
                <button id="btn-save-filters" onclick="$('#form_filters').submit();" class="btn btn-danger"
                    type="button">{$MOD.LBL_APPLY_BUTTON}</button>
            </div>
        </div>
    </div>
</div>
{literal}
<style>
    .cp-color-picker {
        z-index: 9999;
    }
</style>
{/literal}