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
var grid2, grid3, grid4, grid3F, grid4F;
var addAllFields = SUGAR.language.get("app_strings", "LBL_ADD_ALL_LEAD_FIELDS");
var removeAllFields = SUGAR.language.get("app_strings", "LBL_REMOVE_ALL_LEAD_FIELDS");

/**
 *
 * @param
 * @returns
 */
function back(formId) {
  var form = document.getElementById(formId);
  form.step.value = form.back_step.value;
  return addGrids(formId);
}

/**
 *
 * @param
 * @returns
 */
function next(formId) {
  if (!checkFields(formId) || !check_form(formId)) {
    return false;
  } else {
    return addGrids(formId);
  }
}

/**
 *
 * @param
 * @returns
 */
function addGrids(formId) {
  grid3 = SUGAR_GRID_grid1;
  grid4 = SUGAR_GRID_grid2;
  var webFormDiv = document.getElementById(formId);
  if (typeof grid3 != "undefined") {
    addCols(grid3, "colsFirst", webFormDiv);
  }

  if (typeof grid4 != "undefined") {
    addCols(grid4, "colsSecond", webFormDiv);
  }
  return true;
}

/**
 *
 * @param
 * @returns
 */
function checkFields(formId) {
  grid2 = SUGAR_GRID_grid0;
  grid3 = SUGAR_GRID_grid1;
  grid4 = SUGAR_GRID_grid2;
  var reqFields = "";

  if (typeof grid2 == "undefined") {
    // If grid2 does not exist we may not be on a screen with grids, so return true
    return true;
  }

  for (var i = 0; i < grid2.getRecordSet().getLength(); i++) {
    if (grid2.getRecord(i).getData()[2] != null) {
      reqFields = reqFields + grid2.getRecord(i).getData()[0] + ", ";
    }
  }

  var form = document.getElementById(formId);
  var module = form.module.value;
  if (reqFields) {
    reqFields = reqFields.substring(0, reqFields.lastIndexOf(","));
    var msg = SUGAR.language.get(module, "LBL_WEBFORMS_REQUIRED_FIELDS") + " " + reqFields;
    alert(msg);
    return false;
  } else if (grid3.getRecordSet().getLength() == 1 && grid4.getRecordSet().getLength() == 1) {
    var msg = SUGAR.language.get(module, "LBL_WEBFORMS_SELECT_FIELDS");
    alert(msg);
    return false;
  } else {
    return true;
  }
}

/**
 *
 * @param
 * @param
 */
function displayAddRemoveDragButtons(addAllFields, removeAllFields) {
  var addRemove = document.getElementById("lead_add_remove_button");
  if (grid2.getRecordSet().getLength() == 0) {
    addRemove.setAttribute("value", removeAllFields);
    addRemove.setAttribute("title", removeAllFields);
  } else if (grid3.getRecordSet().getLength() == 0 && grid4.getRecordSet().getLength() == 0) {
    addRemove.setAttribute("value", addAllFields);
    addRemove.setAttribute("title", addAllFields);
  }
}

/**
 *
 * @param
 * @param
 * @param
 */
function displayAddRemoveButtons(addRemove, addAllFields, removeAllFields) {
  if (grid2.getRecordSet().getLength() > 1) {
    addRemove.setAttribute("value", addAllFields);
    addRemove.setAttribute("title", addAllFields);
  } else {
    addRemove.setAttribute("value", removeAllFields);
    addRemove.setAttribute("title", removeAllFields);
  }
}

/**
 *
 * @param
 * @param
 * @param
 */
function dragDropAllFields(addRemove, addAllFields, removeAllFields) {
  grid2 = SUGAR_GRID_grid0;
  grid3 = SUGAR_GRID_grid1;
  grid4 = SUGAR_GRID_grid2;
  var availibleSet = grid2.getRecordSet();
  var availibleCount = availibleSet.getLength();

  if (addRemove.value == addAllFields && availibleCount > 1) {
    for (var i = 0; i < availibleCount; i++) {
      if (i % 2 == 0 && availibleSet.getRecord(i).getData()[0] != " ") {
        grid3.addRow(availibleSet.getRecord(i).getData(), i / 2);
      }

      if (i % 2 == 1 && availibleSet.getRecord(i).getData()[0] != " ") {
        grid4.addRow(availibleSet.getRecord(i).getData(), (i - 1) / 2);
      }
    }

    for (i = availibleCount - 1; i >= 0; i--) {
      if (grid2.getRecord(i) != null && grid2.getRecord(i).getData()[0] != " ") {
        grid2.deleteRow(i);
      }
    }
  } else if (addRemove.value == removeAllFields) {
    var count = 0;
    if (grid3.getRecordSet().getLength() >= grid4.getRecordSet().getLength()) {
      count = grid3.getRecordSet().getLength();
    } else {
      count = grid4.getRecordSet().getLength();
    }

    for (var i = 0; i < count; i++) {
      if (grid3.getRecord(i) != null && grid3.getRecord(i).getData()[0] != " ") {
        grid2.addRow(grid3.getRecord(i).getData(), grid2.getRecordSet().getLength() - 1);
      }

      if (grid4.getRecord(i) != null && grid4.getRecord(i).getData()[0] != " ") {
        grid2.addRow(grid4.getRecord(i).getData(), grid2.getRecordSet().getLength() - 1);
      }
    }

    for (var i = count - 1; i >= 0; i--) {
      if (grid4.getRecord(i) != null && grid4.getRecord(i).getData()[0] != " ") {
        grid4.deleteRow(i);
      }

      if (grid3.getRecord(i) != null && grid3.getRecord(i).getData()[0] != " ") {
        grid3.deleteRow(i);
      }
    }
  }
  displayAddRemoveButtons(addRemove, addAllFields, removeAllFields);
}

/**
 *
 * @param
 * @param
 * @param
 */
function addCols(grid, colsNumber, webFormDiv) {
  for (var i = 0; i < grid.getRecordSet().getLength() - 1; i++) {
    var selectedEl = grid.getRecord(i).getData()[1];
    var webField = document.createElement("input");
    webField.setAttribute("id", colsNumber + i);
    webField.setAttribute("name", colsNumber + "[]");
    webField.setAttribute("type", "hidden");
    webField.setAttribute("value", selectedEl);
    webFormDiv.appendChild(webField);
  }
}
