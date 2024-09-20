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
var module = "Opportunities";

/* INCLUDES */

/* VALIDATION DEPENDENCIES */

/* DIRECT VALIDATION CALLBACKS */

/* VIEWS CUSTOM CODE */
switch (viewType()) {
  case "edit":
  case "quickcreate":
  case "popup":
    break;

  case "detail":
    // Define button content
    var buttons = {
      createParticipantsFromAccounts: {
        id: "load_participants",
        title: SUGAR.language.get(module, "LBL_LOAD_PARTICIPANTS"),
        onclick:
          "open_popup('Accounts', 800, 600, '', true, true, {" +
          "'call_back_function': 'setReturnAndCreateParticipants', " +
          "'field_to_name_array': {'id': 'account_id'}," +
          "'form_name': 'DetailView', " +
          "'passthru_data': { }" +
          "}, 'MultiSelect', true)"
      }
    };
    createDetailViewButton(buttons.createParticipantsFromAccounts);
    break;

  case "list":
  default:
    break;
}

/* AUX FUNCTIONS */
/**
 * Callback function after selecting a list of Accounts to create Participants
 */
function setReturnAndCreateParticipants(popupReplyData) {
  var obj = {
    action: "createParticipantsFromAccounts",
    module: "Opportunities",
    return_module: "Accounts",
    return_action: "DetailView",
    record: window.document.forms["DetailView"].record.value,
    accountIds: popupReplyData.selection_list,
  };

  if (obj.accountIds === undefined && popupReplyData.name_to_value_array.account_id !== undefined) {
    obj.accountIds = [popupReplyData.name_to_value_array.account_id];
  }

  var url = "?index.php&" + $.param(obj);
  location.href = url;
}