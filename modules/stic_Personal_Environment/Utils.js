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
var module = "stic_Personal_Environment";

/* INCLUDES */
loadScript("include/javascript/moment.min.js");

/* VALIDATION DEPENDENCIES */
var validationDependencies = {
  stic_personal_environment_contacts_1_name: "stic_personal_environment_accounts_name",
  stic_personal_environment_accounts_name: "stic_personal_environment_contacts_1_name",
  start_date: "end_date",
  end_date: "start_date",
};

/* VALIDATION CALLBACKS */
addToValidateCallback(getFormName(), "stic_personal_environment_contacts_1_name", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_AN_ACCOUNT_OR_A_CONTACT"), function () {
  return JSON.parse(checkPEContactOrAccount());
});

addToValidateCallback(getFormName(), "stic_personal_environment_accounts_name", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_AN_ACCOUNT_OR_A_CONTACT"), function () {
  return JSON.parse(checkPEContactOrAccount());
});

addToValidateCallback(getFormName(), "end_date", "date", false, SUGAR.language.get(module, "LBL_END_DATE_ERROR"), function () {
  return checkStartAndEndDatesCoherence("start_date", "end_date");
});

addToValidateCallback(getFormName(), "start_date", "date", false, SUGAR.language.get(module, "LBL_START_DATE_ERROR"), function () {
  return checkStartAndEndDatesCoherence("start_date", "end_date");
});

/* VIEWS CUSTOM CODE */
switch (viewType()) {
  case "edit":
  case "quickcreate":
  case "popup":
    setAutofill(["name"]);
    contactInView = $("#stic_personal_environment_contactscontacts_ida").length;
    familyInView = $("#stic_families_stic_personal_environmentstic_families_ida").length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView);
    break;
  case "detail":
    contactInView = $("#stic_personal_environment_contactscontacts_ida").length;
    familyInView = $("#stic_families_stic_personal_environmentstic_families_ida").length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView);
    break;
  case "list":
    contactInView = $('[field=stic_personal_environment_contacts_name]').length;
    familyInView = $('[field=stic_families_stic_personal_environment_name]').length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView);
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
    validationDependencies['stic_personal_environment_contacts_name'] = "stic_families_stic_personal_environment_name";
    validationDependencies['stic_families_stic_personal_environment_name'] = "stic_personal_environment_contacts_name";

    addToValidateCallback(getFormName(), "stic_personal_environment_contacts_name", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_A_FAMILY_OR_A_CONTACT"), function () {
      return JSON.parse(checkContactOrFamily());
    });
    addToValidateCallback(getFormName(), "stic_families_stic_personal_environment_name", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_A_FAMILY_OR_A_CONTACT"), function () {
      return JSON.parse(checkContactOrFamily());
    });
  } else {
    if (contactInView) {
      addToValidate(getFormName(), 'stic_personal_environment_contacts_name', 'relate', true, SUGAR.language.get(module, 'LBL_STIC_PERSONAL_ENVIRONMENT_CONTACTS_FROM_CONTACTS_TITLE'));
      addRequiredMark('stic_personal_environment_contacts_name', 'conditional-required')
    } else if (familyInView) {
      addToValidate(getFormName(), 'stic_families_stic_personal_environment_name', 'relate', true, SUGAR.language.get(module, 'LBL_STIC_FAMILIES_STIC_PERSONAL_ENVIRONMENT_FROM_STIC_FAMILIES_TITLE'));
      addRequiredMark('stic_families_stic_personal_environment_name', 'conditional-required')
    }
  }
}


/**
 * Callback function to check if there is a base person or a family or both
 */
function checkContactOrFamily() {
  if (viewType() == "edit") {
    contact = getFieldValue("stic_personal_environment_contactscontacts_ida");
    family = getFieldValue("stic_families_stic_personal_environmentstic_families_ida");
  } else {
    // For inline edit we can only check this fields
    contact = getFieldValue("stic_personal_environment_contacts_name");
    family = getFieldValue("stic_families_stic_personal_environment_name");
  }

  if (contact == "" && family == "") {
    return false;
  }
  return true;
}
/**
 * Check if there is a person or a account or both
 */
function checkPEContactOrAccount() {
  if (viewType() == "edit") {
    contact = getFieldValue("stic_personal_environment_contacts_1contacts_ida");
    account = getFieldValue("stic_personal_environment_accountsaccounts_ida");
  } else {
    // For inline edit we can only check this fields
    contact = getFieldValue("stic_personal_environment_contacts_1_name");
    account = getFieldValue("stic_personal_environment_accounts_name");
  }

  if (contact == "" && account == "") {
    return false;
  }
  return true;
}
