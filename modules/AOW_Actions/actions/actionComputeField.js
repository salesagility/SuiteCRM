/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 *
 * This file was contributed by diligent technology & business consulting GmbH <info@dtbc.eu>
 */

var FieldComputer = function (line, containerName, parameters, parameterTypes, formulas, formulaContents, relationParameters, relationParameterFields, relationParameterTypes) {
  this.initialize(line, containerName, parameters, parameterTypes, formulas, formulaContents, relationParameters, relationParameterFields, relationParameterTypes);
};

FieldComputer.prototype = {
  constructor: FieldComputer,
  initialize: function (line, containerName, parameters, parameterTypes, formulas, formulaContents, relationParameters, relationParameterFields, relationParameterTypes) {
    this.line = line;
    this.container = $('#' + containerName);

    this.parameterSelect = this.container.find('div.computeFieldParametersContainer select.parameterSelect');
    this.parameterTypeSelect = this.container.find('div.computeFieldParametersContainer select.parameterTypeSelect');
    this.parameterBody = this.container.find('div.computeFieldParametersContainer > table > tbody');
    this.parameters = parameters == undefined ? [] : parameters;
    this.parameterTypes = parameterTypes == undefined ? [] : parameterTypes;

    this.formulaSelect = this.container.find('div.computeFieldFormulaContainer select');
    this.formulaBody = this.container.find('div.computeFieldFormulaContainer > table > tbody');
    this.formulas = formulas == undefined ? [] : formulas;
    this.formulaContents = formulaContents == undefined ? [] : formulaContents;

    this.relationParameterSelect = this.container.find('div.computeFieldRelationParametersContainer select.relationParameterSelect');
    this.relationParameterTypeSelect = this.container.find('div.computeFieldRelationParametersContainer select.relationParameterTypeSelect');
    this.relationParameterBody = this.container.find('div.computeFieldRelationParametersContainer > table > tbody');
    this.relationParameters = relationParameters == undefined ? [] : relationParameters;
    this.relationParameterTypes = relationParameterTypes == undefined ? [] : relationParameterTypes;
    this.relationParameterFields = relationParameterFields == undefined ? [] : relationParameterFields;

    if (!this.isNullOrEmpty(parameters) || !this.isNullOrEmpty(formulas) || !this.isNullOrEmpty(relationParameters)) {
      this.recalculateParameterTable.apply(this);
      this.recalculateFormulaTable.apply(this);
      this.recalculateRelationParameterTable.apply(this);
    }
  },

  getCurrentRelationParameterFieldSelect: function () {
    return this.container.find('select.relationParameterFieldSelect:visible');
  },

  getRelationParameterFieldSelectForRelation: function (relationName) {
    return this.container.find('select.relationParameterFieldSelect[relation=\"' + relationName + '\"]');
  },

  isNullOrEmpty: function (collection) {
    return collection == undefined || collection == null || collection.length == 0;
  },

  isVisible: function (elem) {
    return $(elem).css('display') !== 'none';
  },

  addParameter: function () {
    var parameter = this.parameterSelect.val();
    if (parameter == "") {
      return;
    }


    var parameterType = this.parameterTypeSelect.val();
    var parameterTypeValue = (parameterType == "" || !this.isVisible(this.parameterTypeSelect)) ? "raw" : parameterType;

    for (var i = 0; i < this.parameters.length; i++) {
      if (this.parameters[i] == parameter && this.parameterTypes[i] == parameterTypeValue) {
        return;
      }
    }

    this.parameters.push(parameter);
    this.parameterTypes.push(parameterTypeValue);

    this.recalculateParameterTable.apply(this);
  },

  addFormula: function () {
    var field = this.formulaSelect.val();
    if (field == "") {
      return;
    }

    var index = this.formulas.indexOf(field);
    if (index !== -1) {
      return;
    }

    this.formulas.push(field);
    this.formulaContents.push("");

    this.recalculateFormulaTable.apply(this);
  },

  addRelationParameter: function () {
    var relation = this.relationParameterSelect.val();
    if (relation == "") {
      return;
    }

    var field = this.getCurrentRelationParameterFieldSelect().val();
    if (field == "") {
      return;
    }

    var relationParameterType = this.relationParameterTypeSelect.val();
    var relationParameterTypeValue = (relationParameterType == "" || !this.isVisible(this.relationParameterTypeSelect)) ? "raw" : relationParameterType;

    for (var i = 0; i < this.relationParameters.length; i++) {
      if (this.relationParameters[i] == relation && this.relationParameterFields[i] == field && this.relationParameterTypes[i] == relationParameterTypeValue) {
        return;
      }
    }

    this.relationParameters.push(relation);
    this.relationParameterFields.push(field);
    this.relationParameterTypes.push(relationParameterTypeValue);

    this.recalculateRelationParameterTable.apply(this);
  },

  removeParameter: function (fieldName, fieldType) {
    var index = -1;
    for (var i = 0; i < this.parameters.length; i++) {
      if (this.parameters[i] == fieldName && this.parameterTypes[i] == fieldType) {
        index = i;
        break;
      }
    }

    if (index == -1) {
      return;
    }

    this.parameters.splice(index, 1);
    this.parameterTypes.splice(index, 1);

    this.recalculateParameterTable.apply(this);
  },

  removeFormula: function (fieldName) {
    var index = this.formulas.indexOf(fieldName);
    if (index === -1) {
      return;
    }

    this.formulas.splice(index, 1);
    this.formulaContents.splice(index, 1);

    this.recalculateFormulaTable.apply(this);
  },

  removeRelationParameter: function (relationName, fieldName, fieldType) {
    var index = -1;
    for (var i = 0; i < this.relationParameters.length; i++) {
      if (this.relationParameters[i] == relationName && this.relationParameterFields[i] == fieldName && this.relationParameterTypes[i] == fieldType) {
        index = i;
        break;
      }
    }

    if (index == -1) {
      return;
    }

    this.relationParameters.splice(index, 1);
    this.relationParameterFields.splice(index, 1);
    this.relationParameterTypes.splice(index, 1);

    this.recalculateRelationParameterTable.apply(this);
  },

  showHideTable: function (body) {
    if (body.find('tr').length > 0) {
      body.parent().show();
    }
    else {
      body.parent().hide();
    }
  },

  recalculateParameterTable: function () {
    this.parameterBody.empty();

    for (var i = 0; i < this.parameters.length; i++) {
      this.addParameterLine(this.parameters[i], this.parameterTypes[i], this.parameterTypeSelect.find("option[value='" + this.parameterTypes[i] + "']").text(), this.parameterSelect.find("option[value='" + this.parameters[i] + "']").text(), i);
    }

    this.showHideTable(this.parameterBody);
  },

  addParameterLine: function (fieldName, fieldType, fieldTypeLabel, label, id) {
    $deleteButton = $('<button type="button" class="button" onclick="computers[' + this.line + '].removeParameter(\'' + fieldName + '\', \'' + fieldType + '\');"><span class="suitepicon suitepicon-action-minus"></span></button>');

    $tr = $("<tr></tr>")
      .append($deleteButton)
      .append("<td>" + label + "<input type='hidden' name='aow_actions_param[" + this.line + "][parameter][" + id + "]' value='" + fieldName + "'></td>")
      .append("<td>" + fieldTypeLabel + "<input type='hidden' name='aow_actions_param[" + this.line + "][parameterType][" + id + "]' value='" + fieldType + "'></td>")
      .append("<td>{P" + id + "}</td>");

    this.parameterBody.append($tr);
  },

  recalculateFormulaTable: function () {
    this.formulaBody.empty();

    for (var i = 0; i < this.formulas.length; i++) {
      this.addFormulaLine(this.formulas[i], this.formulaSelect.find("option[value='" + this.formulas[i] + "']").text(), i, this.formulaContents[i]);
    }

    this.showHideTable(this.formulaBody);
  },

  addFormulaLine: function (fieldName, label, id, formula) {
    $deleteButton = $('<button type="button" class="button" onclick="computers[' + this.line + '].removeFormula(\'' + fieldName + '\');"><span class="suitepicon suitepicon-action-minus"></span></button>');

    $tr = $("<tr></tr>")
      .append($deleteButton)
      .append("<td>" + label + "<input type='hidden' name='aow_actions_param[" + this.line + "][formula][" + id + "]' value='" + fieldName + "'></td>")
      .append("<td style='width: 100%;'><input style='width: 100%;' type='text' onchange='computers[" + this.line + "].formulaChanged(this, \"" + fieldName + "\")' value='" + formula + "' name='aow_actions_param[" + this.line + "][formulaContent][" + id + "]'></input></td>");

    this.formulaBody.append($tr);
  },

  formulaChanged: function (textbox, fieldName) {
    var index = this.formulas.indexOf(fieldName);
    if (index === -1) {
      return;
    }

    this.formulaContents[index] = $(textbox).val();
  },

  recalculateRelationParameterTable: function () {
    this.relationParameterBody.empty();

    for (var i = 0; i < this.relationParameters.length; i++) {
      this.addRelationParameterLine(this.relationParameters[i],
        this.relationParameterSelect.find("option[value='" + this.relationParameters[i] + "']").text(),
        i,
        this.relationParameterFields[i],
        this.getRelationParameterFieldSelectForRelation(this.relationParameters[i]).find("option[value='" + this.relationParameterFields[i] + "']").text(),
        this.relationParameterTypes[i],
        this.relationParameterTypeSelect.find("option[value='" + this.relationParameterTypes[i] + "']").text());
    }

    this.showHideTable(this.relationParameterBody);
  },

  addRelationParameterLine: function (relationName, relationLabel, id, fieldName, fieldLabel, fieldType, fieldTypeLabel) {
    $deleteButton = $('<button type="button" class="button" onclick="computers[' + this.line + '].removeRelationParameter(\'' + relationName + '\', \'' + fieldName + '\', \'' + fieldType + '\');"><span class="suitepicon suitepicon-action-minus"></span></button>');

    $tr = $("<tr></tr>")
      .append($deleteButton)
      .append("<td>" + relationLabel + "<input type='hidden' name='aow_actions_param[" + this.line + "][relationParameter][" + id + "]' value='" + relationName + "'></td>")
      .append("<td>" + fieldLabel + "<input type='hidden' name='aow_actions_param[" + this.line + "][relationParameterField][" + id + "]' value='" + fieldName + "'></td>")
      .append("<td>" + fieldTypeLabel + "<input type='hidden' name='aow_actions_param[" + this.line + "][relationParameterType][" + id + "]' value='" + fieldType + "'></td>")
      .append("<td>{R" + id + "}</td>");

    this.relationParameterBody.append($tr);
  }
};

var computers = [];

function addParameter(line, containerName) {
  if (computers[line] == undefined) {
    computers[line] = new FieldComputer(line, containerName);
  }

  computers[line].addParameter();
}

function addRelationParameter(line, containerName) {
  if (computers[line] == undefined) {
    computers[line] = new FieldComputer(line, containerName);
  }

  computers[line].addRelationParameter();
}

function addFormula(line, containerName) {
  if (computers[line] == undefined) {
    computers[line] = new FieldComputer(line, containerName);
  }

  computers[line].addFormula();
}

