/**
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
 */

// Set module name
var module = "Employees";

/* VIEWS CUSTOM CODE */
switch (viewType()) {
    case "edit":
    case "quickcreate":
    case "popup":
        break;
    
    case "detail":
        if (editACL){
            // Define button content
            var buttons = {
                showWorkCalendarAssistant: {
                    id: "show_work_calendar_assistant",
                    title: SUGAR.language.get(module, "LBL_PERIODIC_WORK_CALENDAR_BUTTON"),
                    onclick: "location.href='" + STIC.siteUrl + "/index.php?module=stic_Work_Calendar&action=showWorkCalendarAssistant&employeeId=" + STIC.record.id + "'",
                },
            };
            
            createDetailViewButton(buttons.showWorkCalendarAssistant);
        }
        break;

    case "list":
        button = {
            id: "bt_work_calendar_periodic_creation_listview",
            title: SUGAR.language.get(module, "LBL_PERIODIC_WORK_CALENDAR_BUTTON"),
            text: SUGAR.language.get(module, "LBL_PERIODIC_WORK_CALENDAR_BUTTON"),
            onclick: "onClickWorkCalendarPeriodicCreationButton()",
        };
        createListViewButton(button);
        break;

    default:
        break;
}    


/**
 * Used as a callback for the periodic creation of Work Calendar Records
 */
function onClickWorkCalendarPeriodicCreationButton() {
    sugarListView.get_checks();
    if(sugarListView.get_checks_count() < 1) {
        alert(SUGAR.language.get('app_strings', 'LBL_LISTVIEW_NO_SELECTED'));
        return false;
    }
    document.MassUpdate.action.value='showWorkCalendarAssistant';
    document.MassUpdate.module.value='stic_Work_Calendar';
    document.MassUpdate.submit();
  }