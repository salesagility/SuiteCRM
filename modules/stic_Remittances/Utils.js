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
var module = "stic_Remittances";

/* INCLUDES */

/* VALIDATION DEPENDENCIES */
var validationDependencies = {
  bank_account: "type",
  type: "bank_account"
};

/* VALIDATION CALLBACKS */
validateFunctions.bank_account = function() {
  var isRequired = ["edit", "quickcreate"].indexOf(viewType()) >= 0;
  addToValidateCallback(getFormName(), "bank_account", "text", isRequired, SUGAR.language.get(module, "LBL_NO_BANK_ACCOUNT_ERROR"), function() {
    return JSON.parse(getFieldValue("bank_account", "stic_remittances_ibans_list") != "");
  });
};

addToValidateCallback(getFormName(), "type", "enum", true, SUGAR.language.get(module, "LBL_BANK_ACCOUNT_SHOULD_BE_EMPTY_ERROR"), function() {
  var remittanceType = getFieldValue("type", "stic_remittances_types_list");
  var bank_account = getFieldValue("bank_account", "stic_remittances_ibans_list");
  switch (remittanceType) {
    case "direct_debits":
    case "transfers":
      return bank_account != "";
    case "cards":
      return bank_account == "";
    default:
      return false;
      break;
  }
});

/* VIEWS CUSTOM CODE */

switch (viewType()) {
  case "edit":
  case "quickcreate":
    // Definition of the behavior of fields that are conditionally enabled or disabled
    remittanceType = {
      direct_debits: {
        enabled: ["bank_account"],
        disabled: []
      },
      transfers: {
        enabled: ["bank_account"],
        disabled: []
      },
      cards: {
        enabled: [],
        disabled: ["bank_account"]
      },
      default: {
        enabled: [],
        disabled: ["bank_account"]
      }
    };

    setCustomStatus(remittanceType, $("#type", "form").val());
    $("form").on("change", "#type", function() {
      clear_all_errors();
      setCustomStatus(remittanceType, $("#type", "form").val());
    });

    break;
    
  case "detail":
    $recordId = $("#formDetailView input[type=hidden][name=record]").val();
    // Define button content
    var buttons = {
      directDebits: {
        id: "bt_direct_debit",
        title: SUGAR.language.get("stic_Remittances", "LBL_GENERATE_SEPA_DIRECT_DEBITS_SEPA"),
        onclick: "window.location='index.php?module=stic_Remittances&action=GenerateSEPADirectDebit&record=" + $recordId + "'"
      },
      creditTransfers: {
        id: "bt_credit_transfer",
        title: SUGAR.language.get("stic_Remittances", "LBL_GENERATE_SEPA_CREDIT_TRANSFERS"),
        onclick: "window.location='index.php?module=stic_Remittances&action=generateSEPACreditTransfer&record=" + $recordId + "'"
      },
      cardPayments: {
        id: "bt_card_payments",
        title: SUGAR.language.get("stic_Remittances", "LBL_PROCESS_REDSYS_CARD_PAYMENTS"),
        onclick: "window.location='index.php?module=stic_Remittances&action=processRedsysCardPayments&record=" + $recordId + "'"
      }
    };
    createDetailViewButton(buttons.directDebits);
    createDetailViewButton(buttons.creditTransfers);
    createDetailViewButton(buttons.cardPayments);

    break;
    
  case "list":
    break;

  default:
    break;
}
