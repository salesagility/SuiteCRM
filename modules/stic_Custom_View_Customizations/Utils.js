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
var module = "stic_Custom_View_Customizations";

/* INCLUDES */

/* VALIDATION DEPENDENCIES */

/* VALIDATION CALLBACKS */

/* VIEWS CUSTOM CODE */
switch (viewType()) {
  case "quickcreate":
    $(document).ready(function() {
      var customView = sticCustomizeView.quickcreate();
      // Hide Labels
      customView.field("condition_lines").header.hide();
      customView.field("action_lines").header.hide();
    });
    break;

  case "edit":
  case "popup":
    break;

  case "detail":
    break;

  case "list":
    break;

  default:
    break;
}

$(document).ready(function() {});

function translate(label, module) {
  return SUGAR.language.get(module, label);
}

function translateCustomization(label) {
  return translate(label, "stic_Custom_View_Customizations");
}

function getModuleFieldEditor(ln, prefix, field_value) {
  var field = $("#" + prefix + "field" + ln).val();
  if (!field || field == "") {
    field = $("#" + prefix + "element" + ln).val();
  }

  var editor_name = prefix + "value[" + ln + "]";
  var is_value_set = true;
  if (typeof field_value === "undefined") {
    field_value = "";
    is_value_set = false;
  }

  var callbackFieldEditor = {
    success: function(result) {
      $("#" + prefix + "Cell" + "value" + ln).html(result.responseText);
      $("#" + prefix + "Cell" + "value" + ln).children().attr("style", "max-width: 90% !important");
      SUGAR.util.evalScript(result.responseText);
      enableQS(true);
    },
    failure: function(result) {
      $("#" + prefix + "Cell" + "value" + ln).html("");
    },
  };

  YAHOO.util.Connect.asyncRequest(
    "GET",
    "index.php?module=stic_Custom_Views&action=getModuleFieldEditor&form=form_SubpanelQuickCreate_stic_Custom_View_Customizations" + 
             "&view_module=" + view_module + "&field_name=" + field + 
             "&editor_name=" + editor_name + "&field_value=" + field_value +
             "&is_value_set=" + is_value_set,
    callbackFieldEditor
  );
}
