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
var module = "stic_FollowUps";

/* INCLUDES */

/* VALIDATION DEPENDENCIES */
var validationDependencies = {};

/* VALIDATION CALLBACKS */

/* VIEWS CUSTOM CODE */
switch (viewType()) {
  case "edit":
  case "quickcreate":
  case "popup":
    setAutofill(["name"]);
    contactInView = $("#stic_followups_contactscontacts_ida").length;
    familyInView = $("#stic_families_stic_followupsstic_families_ida").length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView);  

    // Adding color dots to "color" enum field
    buildEditableColorFieldSelectize('color');
  	break;
  case "detail":
    contactInView = $("#stic_followups_contactscontacts_ida").length;
    familyInView = $("#stic_families_stic_followupsstic_families_ida").length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView);  

    // Adding color dots to "color" enum field
    buildDetailedColorFieldSelectize('color');
    break;
  case "list":
    contactInView = $('[field=stic_followups_contacts_name]').length;
    familyInView = $('[field=stic_families_stic_followups_name]').length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView); 
    
    // Adding color dots to "color" enum field
    // Check both massupdate and both filters, basic and advanced.
    buildEditableColorFieldSelectize('mass_color');
    buildEditableColorFieldSelectize('color_basic');
    buildEditableColorFieldSelectize('color_advanced');
    break;
  default:
    break;
}

/* AUX FUNCTIONS */
/**
 * Add validations for contact or family field
 */
function addValidationsAccordingToContactOrFamily(contactInView, familyInView) 
 {
  if (contactInView && familyInView) {
    validationDependencies['stic_followups_contacts_name'] = "stic_families_stic_followups_name";
    validationDependencies['stic_families_stic_followups_name'] = "stic_followups_contacts_name";

    addToValidateCallback(getFormName(), "stic_followups_contacts_name", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_A_FAMILY_OR_A_CONTACT"), function () {
      return JSON.parse(checkContactOrFamily());
    });
    addToValidateCallback(getFormName(), "stic_families_stic_followups_name", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_A_FAMILY_OR_A_CONTACT"), function () {
      return JSON.parse(checkContactOrFamily());
    });
  } else {
    if (contactInView) {
      addToValidate(getFormName(), 'stic_followups_contacts_name', 'relate', true, SUGAR.language.get(module, 'LBL_STIC_FOLLOWUPS_CONTACTS_FROM_CONTACTS_TITLE'));
      addRequiredMark('stic_followups_contacts_name', 'conditional-required')      
    } else if (familyInView) {
      addToValidate(getFormName(), 'stic_families_stic_followups_name', 'relate', true, SUGAR.language.get(module, 'LBL_STIC_FAMILIES_STIC_FOLLOWUPS_FROM_STIC_FAMILIES_TITLE'));
      addRequiredMark('stic_families_stic_followups_name', 'conditional-required')
    }
  }
}

/**
 * Callback function to check if there is a base person or a family or both
 */
 function checkContactOrFamily() {
  if (viewType() == "edit") {
    contact = getFieldValue("stic_followups_contactscontacts_ida");
    family = getFieldValue("stic_families_stic_followupsstic_families_ida");
  } else {
    // For inline edit we can only check this fields
    contact = getFieldValue("stic_followups_contacts_name");
    family = getFieldValue("stic_families_stic_followups_name");
  }

  if (contact == "" && family == "") {
    return false;
  }
  return true;
}