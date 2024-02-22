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
var module = "stic_Goals";

/* INCLUDES */
loadScript("include/javascript/moment.min.js");

/* VALIDATION DEPENDENCIES */
var validationDependencies = {
  start_date: "actual_end_date",
  start_date: "expected_end_date",
  expected_end_date: "start_date",
  actual_end_date: "start_date",
};

/* VALIDATION CALLBACKS */
addToValidateCallback(getFormName(), "expected_end_date", "date", false, SUGAR.language.get(module, "LBL_EXPECTED_END_DATE_ERROR"), function () {
  return checkStartAndEndDatesCoherence("start_date", "expected_end_date");
});

addToValidateCallback(getFormName(), "actual_end_date", "date", false, SUGAR.language.get(module, "LBL_ACTUAL_END_DATE_ERROR"), function () {
  return checkStartAndEndDatesCoherence("start_date", "actual_end_date");
});

addToValidateCallback(getFormName(), "start_date", "date", false, SUGAR.language.get(module, "LBL_START_DATE_ERROR_2"), function () {
  return checkStartAndEndDatesCoherence("start_date", "actual_end_date");
});

addToValidateCallback(getFormName(), "start_date", "date", false, SUGAR.language.get(module, "LBL_START_DATE_ERROR"), function () {
  return checkStartAndEndDatesCoherence("start_date", "expected_end_date");
});

/* VIEWS CUSTOM CODE */
switch (viewType()) {
  case "edit":
  case "quickcreate":
  case "popup":
    contactInView = $("#stic_goals_contactscontacts_ida").length;
    familyInView = $("#stic_families_stic_goalsstic_families_ida").length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView);
    break;
  case "detail":
    contactInView = $("#stic_goals_contactscontacts_ida").length;
    familyInView = $("#stic_families_stic_goalsstic_families_ida").length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView);
    function sub_p_rem(subpanelName, getSubpanelData, goalId) {
      console.log(subpanelName, getSubpanelData, goalId);
    }
    break;
  case "list":
    contactInView = $('[field=stic_goals_contacts_name]').length;
    familyInView = $('[field=stic_families_stic_goals_name]').length;
    addValidationsAccordingToContactOrFamily(contactInView, familyInView);
  default:
    break;
}

/* AUX FUNCTIONS */
/**
 * Add validations for contact or family field
 */
function addValidationsAccordingToContactOrFamily(contactInView, familyInView) {
  if (contactInView && familyInView) {
    validationDependencies['stic_goals_contacts_name'] = "stic_families_stic_goals_name";
    validationDependencies['stic_families_stic_goals_name'] = "stic_goals_contacts_name";

    addToValidateCallback(getFormName(), "stic_goals_contacts_name", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_A_FAMILY_OR_A_CONTACT"), function () {
      return JSON.parse(checkContactOrFamily());
    });
    addToValidateCallback(getFormName(), "stic_families_stic_goals_name", "related", false, SUGAR.language.get(module, "LBL_MUST_RELATE_TO_A_FAMILY_OR_A_CONTACT"), function () {
      return JSON.parse(checkContactOrFamily());
    });
  } else {
    if (contactInView) {
      addToValidate(getFormName(), 'stic_goals_contacts_name', 'relate', true, SUGAR.language.get(module, 'LBL_STIC_GOALS_CONTACTS_FROM_CONTACTS_TITLE'));
      addRequiredMark('stic_goals_contacts_name', 'conditional-required')
    } else if (familyInView) {
      addToValidate(getFormName(), 'stic_families_stic_goals_name', 'relate', true, SUGAR.language.get(module, 'LBL_STIC_FAMILIES_STIC_GOALS_FROM_STIC_FAMILIES_TITLE'));
      addRequiredMark('stic_families_stic_goals_name', 'conditional-required')
    }
  }
}

/**
 * Callback function to check if there is a base person or a family or both
 */
function checkContactOrFamily() {
  if (viewType() == "edit") {
    contact = getFieldValue("stic_goals_contactscontacts_ida");
    family = getFieldValue("stic_families_stic_goalsstic_families_ida");
  } else {
    // For inline edit we can only check this fields
    contact = getFieldValue("stic_goals_contacts_name");
    family = getFieldValue("stic_families_stic_goals_name");
  }

  if (contact == "" && family == "") {
    return false;
  }
  return true;
}

/**
 * FUNCTIONS TO MANAGE CUSTOM MANY2MANY RELATIONSHIPS BETWEEN GOALS
 */

//  Unset default open popup event for destination goals subpanel
$("a#getSticGoalsSticGoalsDestinationSide_select_button").off();

// Set custom event to open custom popup window
$("BODY").on("click", "a#getSticGoalsSticGoalsDestinationSide_select_button", function () {
  open_popup(
    "stic_Goals",
    800,
    600,
    "",
    true,
    true,
    {
      call_back_function: "relateDestinationGoal",
      form_name: "DetailView",
      field_to_name_array: {
        id: "sticGoalId",
      },
      passthru_data: {},
    },
    "Select",
    true
  );
});

/**
 * Custom callback function to process selected goals in popupview
 */
function relateDestinationGoal(popupReplyData) {
  // console.log(popupReplyData);

  idList = "";

  // Get value in case of single select (link click)
  if (popupReplyData.name_to_value_array && popupReplyData.name_to_value_array.sticGoalId) {
    idList = popupReplyData.name_to_value_array.sticGoalId;
  }

  // Get values in case of multiple select (and convert in single string separated by space " ")
  $.each(popupReplyData.selection_list || {}, function (index, value) {
    idList = idList + " " + value;
  });

  var obj = {
    action: "relateDestinationGoalFromPopUp",
    module: "stic_Goals",
    return_module: "stic_Goals",
    return_action: "DetailView",
    record: window.document.forms["DetailView"].record.value,
    goalIds: idList.trim(),
    select_entire_list: popupReplyData.select_entire_list,
    current_query_by_page: popupReplyData.current_query_by_page,
  };

  var url = "?index.php&" + $.param(obj);
  location.href = url;
}

//  Unset default open popup event for origin goals subpanel
$("a#getSticGoalsSticGoalsOriginSide_select_button").off();

// Set custom event to open custom popup window
$("BODY").on("click", "a#getSticGoalsSticGoalsOriginSide_select_button", function () {
  open_popup(
    "stic_Goals",
    800,
    600,
    "",
    true,
    true,
    {
      call_back_function: "relateOriginGoal",
      form_name: "DetailView",
      field_to_name_array: {
        id: "sticGoalId",
      },
      passthru_data: {},
    },
    "Select",
    true
  );
});

/**
 * Custom callback function to process selected goals in popupview
 */
function relateOriginGoal(popupReplyData) {
  idList = "";

  // Get value in case of single select (link click)
  if (popupReplyData.name_to_value_array && popupReplyData.name_to_value_array.sticGoalId) {
    idList = popupReplyData.name_to_value_array.sticGoalId;
  }

  // Get values in case of multiple select (and convert in single string separated by space " ")
  $.each(popupReplyData.selection_list || {}, function (index, value) {
    idList = idList + " " + value;
  });
  var obj = {
    action: "relateOriginGoalFromPopUp",
    module: "stic_Goals",
    return_module: "stic_Goals",
    return_action: "DetailView",
    record: window.document.forms["DetailView"].record.value,
    goalIds: idList.trim(),
    select_entire_list: popupReplyData.select_entire_list,
    current_query_by_page: popupReplyData.current_query_by_page,
  };
  var url = "?index.php&" + $.param(obj);
  location.href = url;
}

/**
 * Redirect to custom action "removeAutoRelationGoalFromSubpanel" in controller.php to remove custom goal relationship 
 * This function is called directly by custom widget in custom/include/generic/SugarWidgets/SugarWidgetSubPanelRemoveButtonstic_Goals.php
 * 
 * @param {String} subpanelName The subpanel name allows know if the goal to remove relation is Origin or Destination
 * @param {String} goalId The goal id to unlink 
 */
function removeCustomRelationManyToMany(subpanelName, goalId) {
  var obj = {
    action: "removeAutoRelationGoalFromSubpanel",
    module: "stic_Goals",
    return_module: "stic_Goals",
    return_action: "DetailView",
    main_record: window.document.forms["DetailView"].record.value,
    subpanel_record: goalId,
    subpanel_name: subpanelName,
  };
  var url = "?index.php&" + $.param(obj);
  location.href = url;
}

/**
 * END FUNCTIONS TO MANAGE CUSTOM MANY2MANY RELATIONSHIPS BETTWEN GOALS
 */


YAHOO.util.Event.addListener('stic_goals_stic_assessmentsstic_assessments_ida','change',goalchanged);

function goalchanged() {
  let assessmentName = $('#stic_goals_stic_assessments_name').val();
  let assessmentId = $('#stic_goals_stic_assessmentsstic_assessments_ida').val();
  // We check the name and not the id because when removed manually the name, the id is not automatically cleared
  if (assessmentName != null && assessmentName != '' ) {
      // let contactOrFamily = getContactOrFamily(assessmentId);
      getContactOrFamilyAsync(assessmentId, applyContactOrFamily);
  }
}

function applyContactOrFamily(contactOrFamily) {
  if(contactOrFamily!= null) {
    let confirmationAsked = false;
    let changeValues = true;
    Object.entries(contactOrFamily).forEach((element) => {
      const [key, value] = element;
      if ($('#' + key).val() != null && $('#' + key).val() != '' && $('#' + key).val() != value && !confirmationAsked) {
        questionText = SUGAR.language.get(module, "LBL_CONTACT_OR_FAMILY_CHANGED");
        changeValues = confirm(questionText);
        confirmationAsked = true;
      }
      if(changeValues) {
        if (((key == 'stic_goals_contactscontacts_ida' || key == 'stic_goals_contacts_name') && $('.quickcreate').attr('id') == 'subpanel_stic_goals_contacts_newDiv') || 
          ((key == 'stic_families_stic_goalsstic_families_ida' || key == 'stic_families_stic_goals_name') && $('.quickcreate').attr('id') == 'subpanel_stic_families_stic_goals_newDiv')) {
          // Values are not changed if we are on the subpanel from the module related (eg. contact data is not changed if we are in contact detail view)
        }
        else {
          $('#' + key).val(value);
        }
      }
    });
  }
}


function getContactOrFamilyAsync(assessmentId, callbackFunction) {
  $.ajax({
    url: "index.php?module=stic_Goals&action=getContactOrFamilyFromAssessment",
    type: "post",
    dataType: "json",
    data: {
      "assessmentId": assessmentId
    },
    success: function(resultado) {
      if (resultado.code == 'OK') {
        callbackFunction(resultado.data);
      }
      else if (resultado.code == 'No data') {
        console.log('No data');
        return null;
      }
      else {
        console.log('Error:', resultado.code);
      }
    }
  });
}

// Utility function to extract params from the URL
// $.urlParam = function(name){
// 	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
// 	return results[1] || 0;
// }

$(document).ready(() => {
  // Redefine set_return function to act upon receiving value from popup
  if (typeof old_set_return === 'undefined'){
    // only redefine the function if it is not already redefined
    old_set_return = set_return;
    set_return = function (popup_reply_data) {
      old_set_return(popup_reply_data);
      // After 1/2 second, we activate the goalchanged event. If called before, the confirm action is not execute due to security issues
      // Only call when the assessment has been changed and not on other changes
      if (popup_reply_data.name_to_value_array.stic_goals_stic_assessmentsstic_assessments_ida !== 'undefined'){
        setTimeout(() => {goalchanged();}, 500);
      }
    };
  }

  // We look for the assessment person or family only if we are at Assessment view
  if (currentModule == 'stic_Assessments') {
    // Check assessment on page load in case we are at quick create goal from assessment
    let assessmentId = $('#stic_goals_stic_assessmentsstic_assessments_ida').val();
    if (assessmentId != null && assessmentId != '') {
      // let contactOrFamily = getContactOrFamily(assessmentId);
      getContactOrFamilyAsync(assessmentId, (contactOrFamily) => {
        if(contactOrFamily!= null) {
          Object.entries(contactOrFamily).forEach((element) => {
            const [key, value] = element;
            $('#' + key).val(value);
          });
        }
      });
    }
  }

  // If we are in stic_Goals DetailView and that fields exist, it's beacause we are in goals subpanel
  // We take Persona and Family from parent Goal.
  if (currentModule == 'stic_Goals' && viewType() == 'quickcreate' &&
      ($("#stic_goals_contacts_name").length > 0 || $("#stic_families_stic_goals_name").length)) {
    const personaName = $("span#stic_goals_contactscontacts_ida").text();
    const personaId = $('span#stic_goals_contactscontacts_ida').attr('data-id-value');

    const familyName = $('span#stic_families_stic_goalsstic_families_ida').text();
    const familyId = $('span#stic_families_stic_goalsstic_families_ida').attr('data-id-value');

    $('input#stic_goals_contactscontacts_ida').val(personaId);
    $('input#stic_goals_contacts_name').val(personaName);

    $('input#stic_families_stic_goalsstic_families_ida').val(familyId);
    $('input#stic_families_stic_goals_name').val(familyName);
  }
});
