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

/* HEADER */
// Set module name
var module = "stic_Time_Tracker";

/* VALIDATION DEPENDENCIES */
var validationDependencies = {
  start_date: "end_date",
  end_date: "start_date",
};

/* VALIDATION CALLBACKS */
addToValidateCallback(getFormName(), "start_date", "datetime", false, SUGAR.language.get(module, "LBL_END_DATE_ERROR"), function () {
  return checkStartAndEndDatesCoherence("start_date", "end_date", true);
});
addToValidateCallback(getFormName(), "end_date", "datetime", false, SUGAR.language.get(module, "LBL_END_DATE_ERROR"), function () {
  return checkStartAndEndDatesCoherence("start_date", "end_date", true);
});

/* VIEWS CUSTOM CODE */

switch (viewType()) {
  case "edit":
  case "quickcreate":
  case "popup":    
    // Set autofill mark beside field label
    setAutofill(["name"]);
    // Disable editing of the name field
    document.getElementById('name').disabled = true; 
    break;

  case "detail":
    break;
    
  case "list":
    break;

  default:
    break;
}