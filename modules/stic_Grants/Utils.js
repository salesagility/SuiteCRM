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
var module = "stic_Grants";

/* INCLUDES */
// Load moment.js to use in validations
loadScript("include/javascript/moment.min.js");

/* VALIDATION DEPENDENCIES */
var validationDependencies = {
  stic_grants_contacts_name: "stic_grants_stic_families_name",
  stic_grants_stic_families_name: "stic_grants_contacts_name",

  amount: "percentage",
  percentage: "amount",

  end_date: "start_date",
  start_date: "end_date",

  expected_end_date: "start_date",
  renovation_date: "start_date",
};

/* VALIDATION CALLBACKS */

addToValidateCallback(getFormName(), "end_date", "date", false, SUGAR.language.get(module, "LBL_END_DATE_ERROR"), function () {
  return checkStartAndEndDatesCoherence("start_date", "end_date");
});
addToValidateCallback(getFormName(), "start_date", "date", false, SUGAR.language.get(module, "LBL_START_DATE_ERROR"), function () {
  return checkStartAndEndDatesCoherence("start_date", "end_date");
});
addToValidateCallback(getFormName(), "renovation_date", "date", false, SUGAR.language.get(module, "LBL_RENOVATION_DATE_ERROR"), function () {
  return checkStartAndEndDatesCoherence("start_date", "renovation_date");
});
addToValidateCallback(getFormName(), "expected_end_date", "date", false, SUGAR.language.get(module, "LBL_EXPECTED_END_DATE_ERROR"), function () {
  return checkStartAndEndDatesCoherence("start_date", "expected_end_date");
});
addToValidateCallback(getFormName(), "percentage", "percentageRange", false, SUGAR.language.get(module, "LBL_PERCENTAGE_RANGE_ERROR"), function () {
  return checkPercentageRange("percentage");
});

/* VIEWS CUSTOM CODE */
switch (viewType()) {
  case "edit":
  case "quickcreate":
  case "popup":
    contactInView = $("#stic_grants_contactscontacts_ida").length;
    familyInView = $("#stic_grants_stic_familiesstic_families_ida").length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView);
    amountInView = $("#amount").length;
    percentageInView = $("#percentage").length;
    addValidationsAccordingToAmountOrPercentage(amountInView, percentageInView);
    break;
  case "detail":
    contactInView = $("#stic_grants_contactscontacts_ida").length;
    familyInView = $("#stic_grants_stic_familiesstic_families_ida").length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView);
    break;
  case "list":
    contactInView = $('[field=stic_grants_contacts_name]').length;
    familyInView = $('[field=stic_grants_stic_familiesstic_families_ida]').length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView);
    amountInView = $("#amount").length;
    percentageInView = $("#percentage").length;
    addValidationsAccordingToAmountOrPercentage(amountInView, percentageInView);
    break;
  default:
    break;
}
/* AUX FUNCTIONS */

/**
 * Add validations for contact or family field
 */
function addValidationsAccordingToContactOrFamily(contactInView, familyInView) {
  if (contactInView && familyInView) {
    validationDependencies['stic_grants_contacts_name'] = "stic_grants_stic_families_name";
    validationDependencies['stic_grants_stic_families_name'] = "stic_grants_contacts_name";

    addToValidateCallback(getFormName(), "stic_grants_contacts_name", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_A_FAMILY_OR_A_CONTACT"), function () {
      return JSON.parse(checkContactOrFamily());
    });
    addToValidateCallback(getFormName(), "stic_grants_stic_families_name", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_A_FAMILY_OR_A_CONTACT"), function () {
      return JSON.parse(checkContactOrFamily());
    });
  } else {
    if (contactInView) {
      addToValidate(getFormName(), 'stic_grants_contacts_name', 'relate', true, SUGAR.language.get(module, 'LBL_STIC_GRANTS_CONTACTS_FROM_CONTACTS_TITLE'));
      addRequiredMark('stic_grants_contacts_name', 'conditional-required')
    } else if (familyInView) {
      addToValidate(getFormName(), 'stic_grants_stic_families_name', 'relate', true, SUGAR.language.get(module, 'LBL_STIC_GRANTS_STIC_FAMILIES_FROM_STIC_FAMILIES_TITLE'));
      addRequiredMark('stic_grants_stic_families_name', 'conditional-required')
    }
  }
}
/**
 * Add validations for contact or family field
 */
function addValidationsAccordingToAmountOrPercentage(amountInView, percentageInView) {
  if (amountInView && percentageInView) {
    validationDependencies['amount'] = "percentage";
    validationDependencies['percentage'] = "amount";

    addToValidateCallback(getFormName(), "amount", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_AN_AMOUNT_OR_A_PERCENTAGE"), function () {
      return JSON.parse(checkAmountOrPercentage());
    });
    addToValidateCallback(getFormName(), "percentage", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_AN_AMOUNT_OR_A_PERCENTAGE"), function () {
      return JSON.parse(checkAmountOrPercentage());
    });
  } else {
    if (amountInView) {
      addToValidate(getFormName(), 'amount', 'relate', true, SUGAR.language.get(module, 'LBL_AMOUNT'));
      addRequiredMark('amount', 'conditional-required')
    } else if (percentageInView) {
      addToValidate(getFormName(), 'percentage', 'relate', true, SUGAR.language.get(module, 'LBL_PERCENTAGE'));
      addRequiredMark('percentage', 'conditional-required')
    }
  }
}

/**
 * Callback function to check if there is a contact or a family or both
 */
function checkContactOrFamily() {
  if (viewType() == "edit") {
    contact = getFieldValue("stic_grants_contactscontacts_ida");
    family = getFieldValue("stic_grants_stic_familiesstic_families_ida");
  } else {
    // For inline edit we can only check this fields
    contact = getFieldValue("stic_grants_contacts_name");
    family = getFieldValue("stic_grants_stic_families_name");
  }

  if (contact == "" && family == "") {
    return false;
  }
  return true;
}
/**
 * Callback function to check if there is an amount or a percentage or both
 */
function checkAmountOrPercentage() {
  if (viewType() == "edit") {
    amount = getFieldValue("amount");
    percentage = getFieldValue("percentage");
  } else {
    // For inline edit we can only check this fields
    amount = getFieldValue("amount");
    percentage = getFieldValue("percentage");
  }

  if (amount == "" && percentage == "") {
    return false;
  }
  return true;
}
/**
 * Callback function to check if the percentage is in the valid range (0-100)
 */
function checkPercentageRange(field) {
  console.log('entra en el range')
  var percentage = getFieldValue("percentage");
  if (percentage !== "") {
    // Convert the percentage to a number for comparison
    var percentageValue = parseFloat(percentage);

    // Check if the percentage is within the valid range
    if (percentageValue < 0 || percentageValue > 100) {
      return false;
    }
  }
  return true;
}
