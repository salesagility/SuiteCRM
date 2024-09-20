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
var module = "stic_Group_Opportunities";

/* VIEWS CUSTOM CODE */
switch (viewType()) {
  case "edit":
  case "quickcreate":
  case "popup":
    $(document).ready(function() {
      initializeEditFields();
    });
    break;

  case "detail":
  case "list":
  default:
    break;
}

/* AUX FUNCTIONS */

function initializeEditFields() {
  setAutofill(["name"]);
  if ($("#form_SubpanelQuickCreate_stic_Group_Opportunities").length > 0) {
    switch (module_sugar_grp1) {
      case "Opportunities":
        setReadonly($("#stic_group_opportunities_opportunities_name"));
        break;
      case "Accounts":
        setReadonly($("#stic_group_opportunities_accounts_name"));
        break;
    }
  }
}

function setReadonly($element) {
  $element
    .parent()
    .parent()
    .append(
      '<div class="' + $element.attr("class").replaceAll("hidden", "") + ' stic-ReadonlyInput" ' +
        'style="min-height:20px; height:30px; display:inline-flex; align-items:center; padding-left:5px; border-radius:0.25em;">' +
        $element.val() +
        "</div>"
    );
  $element.parent().hide();
}
