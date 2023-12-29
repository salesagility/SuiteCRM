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
/**
 * Change the visibility of a field
 * @param field field to be changed
 * @param visibility visibility applied to the field
 */
function changeVisibility(field, visibility) {
  var o_td = document.getElementById("td_" + field);
  var o_td_lbl = document.getElementById("td_lbl_" + field);
  if (o_td) {
    o_td.style.display = visibility;
  }

  if (o_td_lbl) {
    o_td_lbl.style.display = visibility;
  }
}

/**
 * Show a hidden field
 * @param field field to be shown
 */
function showField(field) {
  changeVisibility(field, "table-cell");
}

/**
 * Hide a field
 * @param field field to be hidden
 */
function hideField(field) {
  changeVisibility(field, "none");
}

/**
 * Add a field as required
 * @param field field that will be set as required
 */
function addRequired(field) {
  var reqs = document.getElementById("req_id").value;
  if (-1 == reqs.search(field + ";")) {
    document.getElementById("req_id").value += field + ";";
  }

  var requiredLabel = document.getElementById("lbl_" + field + "_required");
  if (!requiredLabel) {
    var rlParent = document.getElementById("td_lbl_" + field);
    if (rlParent) {
      var newLabel = document.createElement("span");
      newLabel.id = "lbl_" + field + "_required";
      newLabel.class = "required";
      newLabel.style = "color: rgb(255, 0, 0);";
      newLabel.innerText = APP_LBL_REQUIRED_SYMBOL;
      rlParent.appendChild(newLabel);
    }
  }
}

/**
 * Delete a field as required
 * @param field field that will be set as no required
 */
function removeRequired(field) {
  var reqs = document.getElementById("req_id").value;
  document.getElementById("req_id").value = reqs.replace(field + ";", "");
  var requiredLabel = document.getElementById("lbl_" + field + "_required");
  if (requiredLabel) {
    requiredLabel.parentNode.removeChild(requiredLabel);
  }
}

/**
 * Validate different form fields
 * @returns {Boolean}
 */
function checkFields() {
  // Check the required fields, nif / cif fields, mails and date fields
  if (!validateRequired() || !validateNifCif() || !validateMails() || !validateDates()) {
    return false;
  } else {
    // If everything is correct replace the Boolean fields
    var boolHidden = document.getElementById("bool_id");
    if (boolHidden != null) {
      var reqs = boolHidden.value;
      if (reqs.length) {
        // If there are Boolean fields, they are treated
        bools = reqs.substring(0, reqs.lastIndexOf(";"));
        var boolFields = new Array();
        var boolFields = bools.split(";");
        nbrFields = boolFields.length;
        for (var i = 0; i < nbrFields; i++) {
          var element = document.getElementById(boolFields[i]);
          element.value == (element.value == "on" ? 1 : 0);
        }
      }
    }
    return true;
  }
}

/**
 * Check the format of the date fields
 * @returns {Boolean}
 */
function validateDates() {
  var elements = $.find("input[type=text].date_input");
  if (elements && elements.length > 0) {
    for (var i = 0; i < elements.length; i++) {
      // The field may not be mandatory, therefore, it is only validated if the element has any value
      if (elements[i].value && !validateDate(elements[i].value)) {
        var label = document.getElementById("lbl_" + elements[i].id);
        alert(stic_Web_Forms_LBL_INVALID_FORMAT + ": " + label.textContent.trim().replace(/:$/, ""));
        selectTextInput(elements[i]);
        return false;
      }
    }
  }
  return true;
}

/**
 * Validate a date using the format indicated in APP_DATE_FORMAT. Does not take into account if the year is leap year
 * @param date
 * @returns {Boolean}
 */
function validateDate(date) {
  var number = /\d+/g;
  var numbers = [];
  var match = number.exec(date);

  while (match != null) {
    numbers.push(match[0]);
    match = number.exec(date);
  }

  if (numbers.length != 3) {
    // If we don't have three numeric fields, it sure isn't a date
    return false;
  }

  var format = /\%Y|\%m|\%d/g;
  var fields = [];
  match = format.exec(APP_DATE_FORMAT); // We separate the fields from the format
  while (match != null) {
    fields.push(match[0]);
    match = format.exec(APP_DATE_FORMAT);
  }

  var idxFields = []; // Index the fields to be able to access them directly
  for (var i = 0; i < fields.length; i++) {
    idxFields[fields[i].replace("%", "")] = i;
  }

  // Retrieve the values ​​of each field
  var day = numbers[idxFields.d];
  var month = numbers[idxFields.m];
  var year = numbers[idxFields.Y];

  // Check the length of the fields
  if (month.length != 2 || day.length != 2 || year.length != 4) {
    return false;
  }

  // Check the format of separators
  if (date.replace(number, "") != APP_DATE_FORMAT.replace(format, "")) {
    return false;
  }
  day = parseInt(day);
  month = parseInt(month);
  year = parseInt(year);

  // Check the value of the month and day
  if (month > 12 || month < 1) {
    return false;
  } else {
    if (day < 1) {
      return false;
    }

    switch (month) {
      case 1:
      case 3:
      case 5:
      case 7:
      case 8:
      case 10:
      case 12:
        return day <= 31;
      case 2:
        return day <= 29; // Leap years are not taken into account
      case 4:
      case 6:
      case 9:
      case 11:
        return day <= 30;
    }
  }
}

/**
 * Check the required fields
 * @returns {Boolean}
 */
function validateRequired() {
  // Check the required fields
  var reqHidden = document.getElementById("req_id");
  if (reqHidden != null) {
    var reqs = reqHidden.value;
    if (reqs.length) {
      // If there are required fields check them
      reqs = reqs.substring(0, reqs.lastIndexOf(";"));
      var reqFields = new Array();
      var reqFields = reqs.split(";");
      nbrFields = reqFields.length;

      for (var i = 0; i < nbrFields; i++) {
        var lbl_element;
        var element = document.getElementById(reqFields[i]);
        var error = 0;
        if (element != null) {
          lbl_element = "#lbl_" + element.id;
          $(lbl_element).removeClass("current-required-field");
          switch (element.type) {
            case "checkbox":
              if (element.checked == 0) {
                error = 1;
              }
              break;

            case "select-one":
              if (element.selectedIndex <= 0) {
                error = 1;
              }
              break;

            case "select-multiple":
              let numOptionsSelected = $("select[id='input_selectmultiple'] option:selected").length;
              if (element.selectedIndex <= 0 && numOptionsSelected <= 1) {
                error = 1;
              }
              break;

            default:
              // Type fields: text, email, password...
              if (element.value.length <= 0) {
                error = 1;
              }
          }
        } else {
          //radio type fields
          error = 1;
          var options = document.getElementsByName(reqFields[i]);

          lbl_element = "#lbl_" + options[0].name;
          $(lbl_element).removeClass("current-required-field");

          options.forEach(function(option) {
            if (option.checked) {
              error = 0;
            }
          });
        }

        if (error) {
          alert(stic_Web_Forms_LBL_PROVIDE_WEB_FORM_FIELDS);
          $(lbl_element).addClass("current-required-field");
          selectTextInput(element);
          return false;
        }
      }
    }
  }
  return true;
}

/**
 * Validate form emails
 * @returns {Boolean}
 */
 function validateMails() {
  var fields = ["Contacts___email1", "Contacts___email2", "Accounts___email1", "Accounts___email2"];
  var ret = true;
  for (var i = 0; i < fields.length && ret; i++) {
    emailInput=document.getElementById(fields[i])
    if(emailInput != undefined)
    {
      ret = validateEmailAdd(emailInput);
    }
  }
  return ret;
}

/**
 * Validate an email address
 * Regex validation email from https://html5-tutorial.net/form-validation/validating-email/
 * @param obj DOM object of the input containing the mail
 * @returns {Boolean}
 */

function validateEmailAdd(obj) {
  obj.value=obj.value.trim();
  if (obj != null && obj.value.length > 0 && !isValidEmail(obj.value)) {
    var label = document.getElementById("lbl_" + obj.id);
    alert(stic_Web_Forms_LBL_INVALID_FORMAT + ": " + label.textContent.replace(/: +$/, ""));
    selectTextInput(obj);
    return false;
  } else {
    return true;
  }
}

/**
 * Check the identification number fields for contacts and accounts as needed
 * @returns {Boolean}
 */
function validateNifCif() {
  var validateIdentificationNumber = document.getElementById("validate_identification_number");

  // Return true if identification number validation is not required
  if (validateIdentificationNumber && validateIdentificationNumber.value == "0") {
    console.log("Identification number validation is not required.");
    return true;
  }

  // NIF validation
  var identificationType = $("#Contacts___stic_identification_type_c").val();
  // Validate if the stic_identification_type_c field is not defined or is defined as NIF or NIE. 
  // Other values like passports and so on should not be validated as there's no rule to do it.
  if (identificationType == null || identificationType == "nif" || identificationType == "nie") {
    var nif = document.getElementById("Contacts___stic_identification_number_c");
    // The nif field may not be required so it can be empty. If so, it is not necessary to validate it
    if (nif && nif.value && !isValidDNI(nif.value)) {
      label = " ";
      if (nif.labels && nif.labels[0]) {
        label += (nif.labels[0].textContent.slice(-1) == ":" ? nif.labels[0].textContent.substring(0, nif.labels[0].textContent.length - 1) : nif.labels[0].textContent);
      }
      alert(stic_Web_Forms_LBL_INVALID_FORMAT + label + ".");
      nif.focus();
      return false;
    }
  }

  // CIF validation
  var cif = document.getElementById("Accounts___stic_identification_number_c");
  // The cif field may not be required so it can be empty. If so, it is not necessary to validate it
  if (cif && cif.value && !isValidCif(cif.value)) {
    label = " ";
    if (cif.labels && cif.labels[0]) {
      label += (cif.labels[0].textContent.slice(-1) == ":" ? cif.labels[0].textContent.substring(0, cif.labels[0].textContent.length - 1) : cif.labels[0].textContent);
    }
    alert(stic_Web_Forms_LBL_INVALID_FORMAT + label + ".");
    cif.focus();
    return false;
  }

  return true;
}

/**
 * Check with each change of value in the field that only number and separator are allowed of decimals '.'
 * @returns {Boolean}
 */
function isNumberKey(evt) {
  var charCode = evt.which ? evt.which : event.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  }

  if (charCode == 46) {
    var evento = evt || event;
    var dots = evento.currentTarget.value.match(/\./g); // If there is already a point, you cannot add another
    if (dots && dots.length > 0) {
      return false;
    }
    if (evento.currentTarget.value.length == 0) {
      // If the point is at the beginning it includes a 0
      evento.currentTarget.value = "0";
    }
  }

  return true;
}

/**
 * Format a value in a number with fixed-point notation
 * @param input currency type field in which to validate the format
 */
function formatCurrency(input) {
  var value = Number(input.value);
  if (!isNaN(value)) {
    input.value = value.toFixed(2);
  }
}

/**
 * Valid if a cif is valid
 * Adapted to javascript from its original in:
 * http://www.michublog.com/informatica/8-funciones-para-la-validacion-de-formularios-con-expresiones-regulares
 * @param cif
 * @returns {Boolean}
 */
function isValidCif(cif) {
  cif.toUpperCase();
  cifRegEx1 = /^[ABEH][0-9]{8}/i;
  cifRegEx2 = /^[KPQS][0-9]{7}[A-J]/i;
  cifRegEx3 = /^[CDFGJLMNRUVW][0-9]{7}[0-9A-J]/i;

  if (cif.match(cifRegEx1) || cif.match(cifRegEx2) || cif.match(cifRegEx3)) {
    control = cif.charAt(cif.length - 1);
    sum_A = 0;
    sum_B = 0;
    for (i = 1; i < 8; i++) {
      if (i % 2 == 0) {
        sum_A += parseInt(cif.charAt(i));
      } else {
        t = (parseInt(cif.charAt(i)) * 2).toString();
        p = 0;
        for (j = 0; j < t.length; j++) {
          p += parseInt(t.charAt(j));
        }
        sum_B += p;
      }
    }

    sum_C = parseInt(sum_A + sum_B) + ""; // Así se convierte en cadena
    sum_D = (10 - parseInt(sum_C.charAt(sum_C.length - 1))) % 10;
    letters = "JABCDEFGHI";

    if (control >= "0" && control <= "9") {
      return control == sum_D;
    } else {
      return control.toUpperCase() == letters[sum_D];
    }
  } else {
    return false;
  }
}

/**
 * Check if it is a correct ID (between 5 and 8 letters followed by the corresponding letter).
 * Accept NIEs (Foreigners with X, Y or Z at the beginning)
 * http://trellat.es/funcion-para-validar-dni-o-nie-en-javascript/
 * @param dni
 * @returns {Boolean}
 */
function isValidDNI(dni) {
  var number, lett, letter;
  var regular_expression_dni = /^[XYZ]?\d{5,8}[A-Z]$/;
  dni = dni.toUpperCase();

  if (regular_expression_dni.test(dni) === true) {
    number = dni.substr(0, dni.length - 1);
    number = number.replace("X", 0);
    number = number.replace("Y", 1);
    number = number.replace("Z", 2);
    lett = dni.substr(dni.length - 1, 1);
    number = number % 23;

    letter = "TRWAGMYFPDXBNJZSQVHLCKET";
    letter = letter.substring(number, number + 1);

    return letter == lett;
  } else {
    return false;
  }
}

/**
 * Assign a value to a select field
 * @param select form field element
 * @param value value that the select option must have to be selected
 */
//
function setSelectValue(select, value) {
  for (var i = 0; i < select.options.length; i++) {
    if (select.options[i].value == value) {
      select.options[i].selected = true;
    } else {
      select.options[i].selected = false;
    }
  }
  // Save the previous value
  select.prev_value = select.options[select.selectedIndex].value;
}

/**
 * Select the text of an input text of the form
 * @param input Object from which the text will be selected
 */
function selectTextInput(input) {
  if (typeof input.setSelectionRange != "undefined") {
    input.setSelectionRange(0, input.value.length);
  }
  input.focus();
}

/**
 * Verify that the size of the form attachments does not exceed the size defined in the PHP configuration
 */
var items;
var formSizeArray = [];

var url =
  $("form")
    .attr("action")
    .split("=")[0] + "=stic_Web_Forms_attachment_limits_response";
$.ajax({
  url: url,
  dataType: "jsonp"
});

/**
 * Gets values of the PHP configuration in the system
 * @param data array from which the values ​​are obtained
 */
function getConfigVariables(data) {
  items = data;
  if (!items.uploadMaxFilesize || !items.postMaxSize) {
    alert(stic_Web_Forms_LBL_SERVER_CONNECTION_ERROR);
  }
}

/**
 * Check if the attachment file size added to the input file is sizer
 * to the configuration variable php upload_max_filesize
 */
$(".document").change(function() {
  var numInput = this.id.substring(this.id.length - 1, this.id.length);
  var errorZone = "#error_zone_" + numInput;
  if (this.files[0]) {
    var fileName = this.files[0].name;
    var fileSize = this.files[0].size;
    if (fileSize > items.uploadMaxFilesizeBytes) {
      $(errorZone).html("<span>" + stic_Web_Forms_LBL_SIZE_FILE_EXCEED + items.uploadMaxFilesize + "B </span>");
      formSizeArray[numInput - 1] = fileSize;
    } else {
      $(errorZone).html("");
      formSizeArray[numInput - 1] = fileSize;
    }
  } else {
    $(errorZone).html("");
    formSizeArray[numInput - 1] = 0;
  }
});

/**
 * Check the total size of the files attached to the form
 * @returns {Boolean}
 */
function checkFormSize() {
  if (items) {
    var formSize = 0;
    var fileZizeError = 0;

    formSizeArray.forEach(function(inputSize) {
      if (inputSize) {
        if (inputSize > items.uploadMaxFilesizeBytes) {
          fileZizeError = 1;
        }
        formSize = formSize + inputSize;
      }
    });

    if (fileZizeError) {
      alert(stic_Web_Forms_LBL_SIZE_FILE_EXCEED + items.uploadMaxFilesize + "B");
      return false;
    }

    if (formSize <= items.postMaxSizeBytes) {
      return true;
    } else {
      alert(stic_Web_Forms_LBL_SUM_SIZE_FILES_EXCEED + items.postMaxSize + "B");
      return false;
    }
  } else {
    return true;
  }
}

/**
 * Fills the timeZone variable on loading.
 */
$('#timeZone').val(Intl.DateTimeFormat().resolvedOptions().timeZone);
