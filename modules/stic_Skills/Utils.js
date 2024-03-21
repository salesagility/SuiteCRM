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
var module = "stic_Skills";

/* VALIDATION DEPENDENCIES */
var validationDependencies = {
  other: "language",
  language: "other",
};

/* VALIDATION CALLBACKS */

validateFunctions.other = function () {
  var isRequired = ["edit", "quickcreate"].indexOf(viewType()) >= 0;
  addToValidateCallback(getFormName(), "other", "text", isRequired, SUGAR.language.get(module, "LBL_QUICKCREATE_PANEL1"), function () {
    // Check if language is "other" before allowing a value in other
    return getFieldValue("language", "stic_skills_languages_list") === "other" || getFieldValue("other") === "";
  });
};

/* VIEWS CUSTOM CODE */
switch (viewType()) {
  case "edit":
  case "quickcreate":
  case "popup":
    languageType = {
      other: {
        enabled: ["other"],
        disabled: [],
      },
      default: {
        enabled: [],
        disabled: ["other"],
      },
    };
    setCustomStatus(languageType, $("#language", "form").val());
    $("form").on("change",'#language', function () {
      clear_all_errors();
      setCustomStatus(languageType, $("#language", "form").val());
      $("#other").val("");
    });

    // Definition of the behavior of fields that are conditionally enabled or disabled
    skillType = {
      language: {
          enabled: [],
          disabled: ["skill", "level"]
      },
      default: {
          enabled: ["skill", "level"],
          disabled: []
      }
    };
    setCustomStatus(skillType, $("#type", "form").val());
    $("form").on("change", "#type", function() {
        clear_all_errors();
        setCustomStatus(skillType, $("#type", "form").val());
    });


    $(document).ready(function () {
      // Definition of the behavior of fields that are conditionally enabled or disabled

      showTabsEdit();
      setAutofill(["name"]);
    });
    break;

  case "detail":
    $(document).ready(function () {
      var typeSelected = $("#type").val();
      showTabs(typeSelected);
    });
    break;

  case "list":
    break;

  default:
    break;
}

/* AUX FUNCTIONS */
// Function to show the tabs depending of the type
function showTabs(typeSelected) {

  var panelLanguages = $("div.panel-content");

  // Ocultar el panel de lenguaje por defecto
  panelLanguage(panelLanguages, "hide");

  if (typeSelected === "language") {
    // Mostrar el panel de lenguaje si typeSelected es 'language'
    panelLanguage(panelLanguages, "show");
  } else {
    // Ocultar el panel de lenguaje si typeSelected no es 'language'
    panelLanguage(panelLanguages, "hide");
  }
}

// Function to show the tabs when the type is changing
function showTabsEdit() {
  var typeSelected = $("#type").val();

  showTabs(typeSelected);

  // Get the subpanels of the quickcreate
  if (viewType() == "quickcreate") {
    typeContact = document.querySelector(
      "#whole_subpanel_stic_skills_contacts"
    );
    if (typeContact != null) {
      typeSelected = $("#whole_subpanel_stic_skills_contacts #type");
      typeSelected.on("change", function () {
        showTabs(typeSelected.val());
      });
    }
  } else {
    $("#type").on("change", function () {
      showTabsEdit();
    });
  }
}

// Get the status if the field is required or not
function getRequiredStatus(fieldId) {
  var validateFields = validate[getFormName()];
  for (i = 0; i < validateFields.length; i++) {
    // Array(name, type, required, msg);
    if (validateFields[i][0] == fieldId) {
      return validateFields[i][2];
    }
  }
  return false;
}

function panelLanguage(panelLanguages, view) {
  // Showing the tab Task and put the fields required if is in the EditView
  if (view === "show") {
    panelLanguages.show();
    if (
      viewType() === "edit" ||
      viewType() === "quickcreate" ||
      (viewType() === "popup" && getRequiredStatus("language") === false)
    ) {
      setRequiredStatus(
        "language",
        "text",
        SUGAR.language.get(module, 'LBL_LANGUAGE')
      );
      setRequiredStatus(
        "written",
        "text",
        SUGAR.language.get(module, 'LBL_WRITTEN')
      );
      setRequiredStatus(
        "oral",
        "text",
        SUGAR.language.get(module, 'LBL_ORAL')
      );
      setUnrequiredStatus("skill");
      setUnrequiredStatus("level");

    }
    // Hiding the tab Task and put the fields unrequired if is in the EditView
  } else if (view === "hide") {
    panelLanguages.hide();
    if (
      viewType() === "edit" ||
      viewType() === "quickcreate" ||
      (viewType() === "popup" && getRequiredStatus("language") != false)
    ) {
      setUnrequiredStatus("language");
      setUnrequiredStatus("written");
      setUnrequiredStatus("oral");

      setRequiredStatus(
        "level",
        "enum",
        SUGAR.language.get(module, 'LBL_LEVEL')
        );
      setRequiredStatus(
        "skill",
        "text",
        SUGAR.language.get(module, 'LBL_SKILL')
      );

    }
  }
}
