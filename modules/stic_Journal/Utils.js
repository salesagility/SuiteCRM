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
var module = "stic_Journal";

/* VIEWS CUSTOM CODE */
switch (viewType()) {
  case "edit":
  case "quickcreate":
  case "popup":
    $(document).ready(function() {
      showTabsEdit();
      setAutofill(["name"]);
    });
    break;

  case "detail":
    $(document).ready(function() {
      var typeSelected = $('#type').val();
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

  var tabsKeys = Object.keys(STIC.tabsArray);
  
  var positionTask = tabsKeys.indexOf("LBL_PANEL_TASKS");
  var positionInfringement = tabsKeys.indexOf("LBL_PANEL_INFRINGEMENTS");

  var panelTasks = $('a#tab' + positionTask);
  var panelInfringements = $('a#tab' + positionInfringement);

  if(viewType() == 'quickcreate' && document.querySelector('#whole_subpanel_stic_journal_stic_centers') != null ) {
    panelTasks = $('#whole_subpanel_stic_journal_stic_centers a#tab' + positionTask);
    panelInfringements = $('#whole_subpanel_stic_journal_stic_centers a#tab' + positionInfringement);
  } else if (viewType() == 'quickcreate' && document.querySelector('#whole_subpanel_stic_journal_contacts') != null ) {
    panelTasks = $('#whole_subpanel_stic_journal_contacts a#tab' + positionTask);
    panelInfringements = $('#whole_subpanel_stic_journal_contacts a#tab' + positionInfringement);
  } 

  descriptionRequired('show');

  tabTask(panelTasks, 'hide');
  tabInfrigement(panelInfringements, 'hide');

  if (typeSelected === 'task') {
    descriptionRequired('hide');
    
    tabTask(panelTasks, 'show');
  } else if (typeSelected === 'infringement') {
    descriptionRequired('hide');
    
    tabInfrigement(panelInfringements, 'show');
  } else if (typeSelected === 'educational_measure') {
    descriptionRequired('hide');
    
    tabTask(panelTasks, 'show');
    tabInfrigement(panelInfringements, 'show');
  } 
}

// Function to show the tabs when the type is changing
function showTabsEdit () {
  var typeSelected = $('#type').val();
  
  showTabs(typeSelected);
  
  // Get the subpanels of the quickcreate
  if(viewType() == 'quickcreate') {
    typeCenter = document.querySelector('#whole_subpanel_stic_journal_stic_centers');
    typeContact = document.querySelector('#whole_subpanel_stic_journal_contacts');
    if(typeCenter != null ) {
      typeSelected = $('#whole_subpanel_stic_journal_stic_centers #type');
        typeSelected.on('change', function() {
          showTabs(typeSelected.val());
        });
    } else if (typeContact != null ) {
      typeSelected = $('#whole_subpanel_stic_journal_contacts #type');
      typeSelected.on('change', function() {
        showTabs(typeSelected.val());
      });
    }
  } else {
    $('#type').on('change', function() {
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

function tabTask (panelTasks, view) {
  // Showing the tab Task and put the fields required if is in the EditView
  if (view === 'show') {
    panelTasks.show();
    if(viewType() === 'edit' || viewType() === 'quickcreate' || viewType() === 'popup' && getRequiredStatus('task') === false) {
      setRequiredStatus('task', 'text', SUGAR.language.languages.stic_Journal.LBL_TASK);
      setRequiredStatus('task_scope', 'text', SUGAR.language.languages.stic_Journal.LBL_TASK_SCOPE);
      setRequiredStatus('task_start_date', 'text', SUGAR.language.languages.stic_Journal.LBL_TASK_START_DATE);
      setRequiredStatus('task_end_date', 'text', SUGAR.language.languages.stic_Journal.LBL_TASK_END_DATE);
      setRequiredStatus('task_description', 'text', SUGAR.language.languages.stic_Journal.LBL_TASK_DESCRIPTION);
    }
  // Hiding the tab Task and put the fields unrequired if is in the EditView
  } else if (view === 'hide') {
    panelTasks.hide();
    if(viewType() === 'edit' || viewType() === 'quickcreate' || viewType() === 'popup' && getRequiredStatus('task') != false) {
      setUnrequiredStatus('task');
      setUnrequiredStatus('task_scope');
      setUnrequiredStatus('task_start_date');
      setUnrequiredStatus('task_end_date');
      setUnrequiredStatus('task_description');
    }
  }
}

function tabInfrigement (panelInfringements, view) {
  // Showing the tab TasInfringementk and put the fields required if is in the EditView
  if (view === 'show') {
    panelInfringements.show();
    if(viewType() === 'edit' || viewType() === 'quickcreate' || viewType() === 'popup' && getRequiredStatus('infringement_seriousness') === false) {
      setRequiredStatus('infringement_seriousness', 'text', SUGAR.language.languages.stic_Journal.LBL_INFRINGEMENT_SERIOUSNESS);
      setRequiredStatus('infringement_description', 'text', SUGAR.language.languages.stic_Journal.LBL_INFRINGEMENT_DESCRIPTION);
    }
  // Hiding the tab Infringement and put the fields unrequired if is in the EditView
  } else if (view === 'hide') {
    panelInfringements.hide();
    if(viewType() === 'edit' || viewType() === 'quickcreate' || viewType() === 'popup' && getRequiredStatus('infringement_seriousness') != false) {
      setUnrequiredStatus('infringement_seriousness');
      setUnrequiredStatus('infringement_description');
    }
  }
}

// Adding the field Description required if there aren't the tabs Tasks or Infringenments
function descriptionRequired(view) {
  if (view === 'show') {
    if(viewType() === 'edit' || viewType() === 'quickcreate' || viewType() === 'popup' && getRequiredStatus('description') === false) {
      setRequiredStatus('description', 'text', SUGAR.language.languages.stic_Journal.LBL_DESCRIPTION);
    }
  // Remove the field Description from required if there are the tabs Tasks or Infringenments
  } else if (view === 'hide') {
    if(viewType() === 'edit' || viewType() === 'quickcreate' || viewType() === 'popup' && getRequiredStatus('description') != false) {
      setUnrequiredStatus('description');
    }
  }
}