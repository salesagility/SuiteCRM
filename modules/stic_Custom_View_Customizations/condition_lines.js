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

function translateCondition(label) {
  return translate(label, "stic_Custom_View_Conditions");
}

var condln = 0;
var condln_count = 0;
var condprefix = "sticCustomView_Condition";
var condId = condprefix + "Lines";
var condValArray = [];

function getConditionDeleteButton(ln, functionName) {
  var html =
    "<button type='button' class='button' style='padding-top:8px;' title='" + translateCustomization("LBL_DELETE_CONDITION") + "' " +
            "id='" + condprefix + "delete" + ln + "' onclick='" + functionName + "(" + ln +")'>" +
      "<span class='suitepicon suitepicon-action-minus'></span>" +
    "</button><br>" +
    "<input type='hidden' name='" + condprefix + "deleted[" + ln + "]' id='" + condprefix + "deleted" + ln + "' value='0'>" +
    "<input type='hidden' name='" + condprefix + "id[" + ln + "]' id='" + condprefix + "id" + ln + "' value=''>";
  return html;
}

/**
 * Condition Table Header
 */
function insertConditionLinesHeader() {
  $("#" + condId).append(
    '<thead id="' + condId + '_head"><tr>' + '<th style="width:70px;"></th>' + // Remove button
      '<th style="width:20%;">' + translateCondition("LBL_FIELD") + "</th>" +
      '<th style="width:20%;">' + translateCondition("LBL_OPERATOR") + "</th>" +
      '<th style="width:20%;">' + translateCondition("LBL_CONDITION_TYPE") + "</th>" +
      "<th>" + translateCondition("LBL_VALUE") + "</th>" +
    "</thead>"
  );
}

function insertConditionLine() {
  var ln = condln;
  var id = condId;
  var prefix = condprefix;

  if (!$("#" + id + "_head").length) {
    insertConditionLinesHeader();
  }
  $("#" + id + "_head").show();

  tablebody = document.createElement("tbody");
  tablebody.id = prefix + "body" + ln;
  $("#" + id).append(tablebody);

  //Create row
  var x = tablebody.insertRow(-1);
  x.id = prefix + ln;
  x.insertCell(-1).id = prefix + "Cell" + "delete" + ln; // Delete button
  x.insertCell(-1).id = prefix + "Cell" + "field" + ln; // Field
  x.insertCell(-1).id = prefix + "Cell" + "operator" + ln; // Operator
  x.insertCell(-1).id = prefix + "Cell" + "condition_type" + ln; // Condition type
  x.insertCell(-1).id = prefix + "Cell" + "value" + ln; // Value

  // Initial fills

  // Delete button
  $("#" + prefix + "Cell" + "delete" + ln).html(getConditionDeleteButton(ln, "markConditionLineDeleted"));

  // Field
  $("#" + prefix + "Cell" + "field" + ln).html(
    "<select name='" + prefix + "field[" + ln + "]' id='" + prefix + "field" + ln + "'>" +
      view_module_action_map.actionTypes.field_modification.elements.options +
    "</select>" +
    "<span id='" + prefix + "field" + "_label" + ln + "' ></span>"
  );

  $("#" + prefix + "field" + ln).on("change", function() {
    onConditionFieldChanged(ln);
  });
  $("#" + prefix + "field" + ln).val(null);
  $("#" + prefix + "field" + ln).change();

  $(".edit-view-field #" + prefix + "Lines").find("tbody").last().find("select").change(function() {
    $(this).find("td").last().removeAttr("style");
    $(this).find("td").height($(this).find("td").last().height() + 8);
  });

  condln++;
  condln_count++;

  return ln;
}

function loadConditionLine(conditionString) {
  var prefix = condprefix;
  var ln = 0;

  var condition = JSON.parse(conditionString);

  ln = insertConditionLine();
  if (condition["value"] instanceof Array) {
    condition["value"] = JSON.stringify(condition["value"]);
  }
  var value = typeof condition["value"] !== "undefined" && condition["value"] !== null ? condition["value"] : "";
  condValArray.push({ line: ln, value: value.split("|")[0] });
  for (var a in condition) {
    $("#" + prefix + a + ln).val(condition[a]);
    $("#" + prefix + a + ln).change();
  }
}

function markConditionLineDeleted(ln) {
  // collapse line; update deleted value
  $("#" + condprefix + "body" + ln).hide();
  $("#" + condprefix + "deleted" + ln).val("1");
  $("#" + condprefix + "delete" + ln).prop("onclick", null).off("click");

  condln_count--;
  if (condln_count <= 0) {
    $("#" + condId + "_head").hide();
  }
}

function onConditionFieldChanged(ln) {
  var field = $("#" + condprefix + "field" + ln).val();
  if (field == "" || field == null) {
    // Reset next selectors
    $("#" + condprefix + "Cell" + "operator" + ln).html("");
    $("#" + condprefix + "Cell" + "condition_type" + ln).html("");
    $("#" + condprefix + "Cell" + "value" + ln).html("");
  } else {
    // Create next selector
    // Operator selector
    var value_type = view_field_map[field].type + "|" + view_field_map[field].list;
    $("#" + condprefix + "Cell" + "operator" + ln).html(
      "<select type='text' name='" + condprefix + "operator[" + ln + "]' id='" + condprefix + "operator" + ln + "'>" +
        view_field_map[field].condition_operators.options +
      "</select>" +
      "<input type='hidden' name='" + condprefix + "value_type[" + ln + "]' id='" + condprefix + "value_type" + ln + "' value='" + value_type + "'>"
    );

    $("#" + condprefix + "operator" + ln).on("change", function() {
      onConditionOperatorChanged(ln);
    });
    $("#" + condprefix + "operator" + ln).val(null);
    $("#" + condprefix + "operator" + ln).change();
  }
}
function onConditionOperatorChanged(ln) {
  var field = $("#" + condprefix + "field" + ln).val();
  var operator = $("#" + condprefix + "operator" + ln).val();
  if (field == "" || field == null) {
    $("#" + prefix + "field" + ln).change();
  } else if (operator == "" || operator == null) {
    // Reset next selectors
    $("#" + condprefix + "Cell" + "condition_type" + ln).html("");
    $("#" + condprefix + "Cell" + "value" + ln).html("");
  } else {
    // Create next selector
    if (operator == "is_null" || operator == "is_not_null") {
      $("#" + condprefix + "Cell" + "condition_type" + ln).html("<p> - </p>");
      $("#" + condprefix + "Cell" + "value" + ln).html("<p> - </p>");
    } else {
      // Condition Type selector
      if (
        $("#" + condprefix + "Cell" + "condition_type" + ln).html() == "" ||
        $("#" + condprefix + "Cell" + "condition_type" + ln).html() == "<p> - </p>"
      ) {
        $("#" + condprefix + "Cell" + "condition_type" + ln).html(
          "<select type='text' name='" + condprefix + "condition_type[" + ln + "]' id='" + condprefix + "condition_type" + ln + "'>" +
            view_field_map[field].condition_types.options +
          "</select>"
        );
        $("#" + condprefix + "condition_type" + ln).on("change", function() {
          onConditionTypeChanged(ln);
        });
        $("#" + condprefix + "condition_type" + ln).val(null);
        $("#" + condprefix + "condition_type" + ln).change();
      }
    }
  }
}
function onConditionTypeChanged(ln) {
  var field = $("#" + condprefix + "field" + ln).val();
  var condition_type = $("#" + condprefix + "condition_type" + ln).val();
  if (field == "" || field == null) {
    $("#" + prefix + "field" + ln).change();
  } else if (condition_type == "" || condition_type == null) {
    // Reset next selectors
    $("#" + condprefix + "Cell" + "value" + ln).html("");
  } else if (condition_type == "value") {
    // Value editor
    var condValue = undefined;
    for (let i = 0; i < condValArray.length; i++) {
      if (condValArray[i].line == ln) {
        condValue = condValArray[i].value;
        condValArray.splice(i, 1);
        break;
      }
    }
    getModuleFieldEditor(ln, condprefix, condValue);
  } else {
    $("#" + condprefix + "Cell" + "value" + ln).html(
      "<select type='text' name='" + condprefix + "value[" + ln + "]' id='" + condprefix + "value" + ln + "'>" +
        view_field_map[field]["condition_values_" + condition_type].options +
      "</select>"
    );
  }
}
