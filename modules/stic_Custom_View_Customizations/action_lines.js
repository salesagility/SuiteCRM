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

function translateAction(label) {
  return translate(label, "stic_Custom_View_Actions");
}

var actln = 0;
var actln_count = 0;
var actprefix = "sticCustomView_Action";
var actId = actprefix + "Lines";
var actValArray = [];

function getActionDeleteButton(ln, functionName) {
  var html =
    "<button type='button' class='button' style='padding-top:8px;' title='" +
    translateCustomization("LBL_DELETE_ACTION") +
    "' " +
    "id='" +
    actprefix +
    "delete" +
    ln +
    "' onclick='" +
    functionName +
    "(" +
    ln +
    ")'>" +
    "<span class='suitepicon suitepicon-action-minus'></span>" +
    "</button><br>" +
    "<input type='hidden' name='" +
    actprefix +
    "deleted[" +
    ln +
    "]' id='" +
    actprefix +
    "deleted" +
    ln +
    "' value='0'>" +
    "<input type='hidden' name='" +
    actprefix +
    "id[" +
    ln +
    "]' id='" +
    actprefix +
    "id" +
    ln +
    "' value=''>";
  return html;
}

function getActionDuplicateButton(ln, functionName) {
  var html =
    "<button type='button' class='button' title='" +
    translateCustomization("LBL_DUPLICATE_ACTION") +
    "' " +
    "id='" +
    actprefix +
    "duplicate" +
    ln +
    "' onclick='" +
    functionName +
    "(" +
    ln +
    ")'>" +
    "<span> x2 </span>" +
    "</button>";
  return html;
}

/**
 * Action Table Header
 */
function insertActionLinesHeader() {
  $("#" + actId).append(
    '<thead id="' +
    actId +
    '_head"><tr>' +
    '<th style="width:70px;"></th>' + // Remove button
    "<th>" +
    translateAction("LBL_TYPE") +
    "</th>" +
    "<th>" +
    translateAction("LBL_ELEMENT") +
    "</th>" +
    "<th>" +
    translateAction("LBL_ACTION") +
    "</th>" +
    "<th>" +
    translateAction("LBL_VALUE") +
    "</th>" +
    "<th>" +
    translateAction("LBL_ELEMENT_SECTION") +
    "</th>" +
    '<th style="width:70px;"></th>' + // Duplicate button
      "</thead>"
  );
}

function insertActionLine() {
  var ln = actln;
  var id = actId;
  var prefix = actprefix;

  if (!$("#" + id + "_head").length) {
    insertActionLinesHeader();
  }
  $("#" + id + "_head").show();

  tablebody = document.createElement("tbody");
  tablebody.id = prefix + "body" + ln;
  $("#" + id).append(tablebody);

  //Create row
  var x = tablebody.insertRow(-1);
  x.id = prefix + ln;
  x.insertCell(-1).id = prefix + "Cell" + "delete" + ln; // Delete button
  x.insertCell(-1).id = prefix + "Cell" + "type" + ln; // Action Type
  x.insertCell(-1).id = prefix + "Cell" + "element" + ln; // Element
  x.insertCell(-1).id = prefix + "Cell" + "action" + ln; // Action
  x.insertCell(-1).id = prefix + "Cell" + "value" + ln; // Value
  x.insertCell(-1).id = prefix + "Cell" + "element_section" + ln; // Section
  x.insertCell(-1).id = prefix + "Cell" + "duplicate" + ln; // Duplicate button

  // Initial fills

  // Delete button
  $("#" + prefix + "Cell" + "delete" + ln).html(getActionDeleteButton(ln, "markActionLineDeleted"));

  // Action type
  $("#" + prefix + "Cell" + "type" + ln).html(
    "<select name='" + prefix + "type[" + ln + "]' id='" + prefix + "type" + ln + "'>" +
      view_module_action_map.actionTypes.options +
    "</select>" +
    "<span id='" + prefix + "type" + "_label" + ln + "' ></span>"
  );

  $("#" + prefix + "type" + ln).on("change", function() {
    onActionTypeChanged(ln);
  });
  $("#" + prefix + "type" + ln).val(null);
  $("#" + prefix + "type" + ln).change();

  $(".edit-view-field #" + prefix + "Lines").find("tbody").last().find("select").change(function() {
    $(this).find("td").last().removeAttr("style");
    $(this).find("td").height($(this).find("td").last().height() + 8);
  });

  actln++;
  actln_count++;

  return ln;
}

function loadActionLine(actionString) {
  var prefix = actprefix;
  var ln = insertActionLine();

  var action = JSON.parse(actionString);
  if (action["value"] instanceof Array) {
    action["value"] = JSON.stringify(action["value"]);
  }
  if (action["type"] == "field_modification" && action["action"] == "fixed_value") {
    var value = typeof action["value"] !== "undefined" && action["value"] !== null ? action["value"] : "";
    actValArray.push({ line: ln, value: value.split("|")[0] });
  }
  for (var a in action) {
    $("#" + prefix + a + ln).val(action[a]);
    $("#" + prefix + a + ln).change();
  }
}

function duplicateActionLine(ln) {
  var prefix = actprefix;
  var newln = insertActionLine();

  var parts = ["type", "element", "action", "value", "element_section"];
  parts.forEach(a => {
    $("#" + prefix + a + newln).val($("#" + prefix + a + ln).val());
    $("#" + prefix + a + newln).change();
  });

  // if (action['value'] instanceof Array) {
  //   action['value'] = JSON.stringify(action['value'])
  // }
}

function markActionLineDeleted(ln) {
  // collapse line; update deleted value
  $("#" + actprefix + "body" + ln).hide();
  $("#" + actprefix + "deleted" + ln).val("1");
  $("#" + actprefix + "delete" + ln).prop("onclick", null).off("click");

  actln_count--;
  if (actln_count <= 0) {
    $("#" + actId + "_head").hide();
  }
}

function onActionTypeChanged(ln) {
  var type = $("#" + actprefix + "type" + ln).val();
  if (type == "" || type == null) {
    // Reset Element selector
    $("#" + actprefix + "Cell" + "element" + ln).html("");
  } else {
    // Create Element selector
    $("#" + actprefix + "Cell" + "element" + ln).html(
      "<select type='text' name='" + actprefix + "element[" + ln + "]' id='" + actprefix + "element" + ln + "'>" +
        view_module_action_map.actionTypes[type].elements.options +
      "</select>"
    );

    $("#" + actprefix + "element" + ln).on("change", function() {
      onActionElementChanged(ln);
    });
    $("#" + actprefix + "element" + ln).val(null);
    $("#" + actprefix + "element" + ln).change();
  }

  // Reset next selectors
  $("#" + actprefix + "Cell" + "action" + ln).html("");
  $("#" + actprefix + "Cell" + "value" + ln).html("");
  $("#" + actprefix + "Cell" + "element_section" + ln).html("");
}

function onActionElementChanged(ln) {
  var type = $("#" + actprefix + "type" + ln).val();
  var element = $("#" + actprefix + "element" + ln).val();
  if (type == "" || type == null) {
    $("#" + actprefix + "type" + ln).change();
  } else if (element != "" && element != null) {
    var value_type = "";
    if (type == "field_modification") {
      value_type = view_field_map[element].type + "|" + view_field_map[element].list;
    }
    // Create next selector if need
    if ($("#" + actprefix + "Cell" + "action" + ln).html() == "") {
      // Action selector
      $("#" + actprefix + "Cell" + "action" + ln).html(
        "<select type='text' name='" + actprefix + "action[" + ln + "]' id='" + actprefix + "action" + ln + "'>" +
          view_module_action_map.actionTypes[type].actions.options +
        "</select>" +
        "<input type='hidden' name='" + actprefix + "value_type[" + ln + "]' id='" + actprefix + "value_type" + ln + "' value='" + value_type + "'>"
      );

      $("#" + actprefix + "action" + ln).on("change", function() {
        onActionChanged(ln);
      });
      $("#" + actprefix + "action" + ln).val(null);
      $("#" + actprefix + "action" + ln).change();
    } else {
      // Update value_type
      $("#" + actprefix + "value_type" + ln).val(value_type);
    }
  }
}

function onActionChanged(ln) {
  var type = $("#" + actprefix + "type" + ln).val();
  var element = $("#" + actprefix + "element" + ln).val();
  var action = $("#" + actprefix + "action" + ln).val();
  if (type == "" || type == null) {
    $("#" + actprefix + "type" + ln).change();
  } else if (element == "" || element == null) {
    $("#" + actprefix + "element" + ln).change();
  } else if (action == "" || action == null) {
    // Reset next selectors
    $("#" + actprefix + "Cell" + "value" + ln).html("");
    $("#" + actprefix + "Cell" + "element_section" + ln).html("");
  } else {
    // Create next selectors
    // Value editor
    if (type == "field_modification" && action == "fixed_value") {
      var actValue = undefined;
      for (let i = 0; i < actValArray.length; i++) {
        if (actValArray[i].line == ln) {
          actValue = actValArray[i].value;
          actValArray.splice(i, 1);
          break;
        }
      }
      getModuleFieldEditor(ln, actprefix, actValue);
    } else {
      $("#" + actprefix + "Cell" + "value" + ln).html(
        decodeURIComponent(escape(atob(view_action_editor_map[action].editor_base64)))
      );
      $("#" + actprefix + "Cell" + "value" + ln).children().attr("id", actprefix + "value" + ln);
      $("#" + actprefix + "Cell" + "value" + ln).children().attr("name", actprefix + "value[" + ln + "]");
    }
    $("#" + actprefix + "Cell" + "value" + ln).children().attr("style", "width: 90% !important");

    // Section selector
    $("#" + actprefix + "Cell" + "element_section" + ln).html(
      "<select type='text' name='" + actprefix + "element_section[" + ln + "]' id='" + actprefix + "element_section" + ln + "'>" +
        view_module_action_map.actionTypes[type].actions[action].sections.options +
      "</select>"
    );
    if ($("#" + actprefix + "element_section" + ln).children().length <= 1) {
      $("#" + actprefix + "element_section" + ln).hide();
      $("#" + actprefix + "Cell" + "element_section" + ln).append(
        "<p>" + $("#" + actprefix + "element_section" + ln).text() + "</p>"
      );
    }

    // Duplicate button
    $("#" + actprefix + "Cell" + "duplicate" + ln).html(getActionDuplicateButton(ln, "duplicateActionLine"));
  }
}
