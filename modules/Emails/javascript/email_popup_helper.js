/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */




function send_back_selected(module, form, field, error_message, field_to_name_array) {
  // cn: bug 12274 - stripping false-positive security envelope
  var temp_request_data = request_data;
  if (temp_request_data.jsonObject) {
    request_data = temp_request_data.jsonObject;
  } else {
    request_data = temp_request_data; // passed data that is NOT incorrectly encoded via JSON.encode();
  }
  // cn: end bug 12274 fix

  var passthru_data = Object();
  if (typeof(request_data.passthru_data) != 'undefined') {
    passthru_data = request_data.passthru_data;
  }
  var form_name = request_data.form_name;
  var field_to_name_array = request_data.field_to_name_array;
  SUGAR.util.globalEval("retValue = window.opener." + request_data.call_back_function);
  var call_back_function = retValue;

  var array_contents = Array();
  var j = 0;
  for (i = 0; i < form.elements.length; i++) {
    if (form.elements[i].name == field) {
      if (form.elements[i].checked == true) {
        ++j;
        var id = form.elements[i].value;
        array_contents_row = Array();
        for (var the_key in field_to_name_array) {
          if (the_key != 'toJSON') {
            var the_name = field_to_name_array[the_key];
            var the_value = '';

            if (/*module != '' && */id != '') {
              the_value = associated_javascript_data[id][the_key.toUpperCase()];
            }

            array_contents_row.push('"' + the_name + '":"' + the_value + '"');
          }
        }
        SUGAR.util.globalEval("array_contents.push({" + array_contents_row.join(",") + "})");
      }
    }
  }

  var result_data = {"form_name": form_name, "name_to_value_array": array_contents};

  if (array_contents.length == 0) {
    window.alert(error_message);
    return;
  }

  call_back_function(result_data);
  var close_popup = window.opener.get_close_popup();

  if (close_popup) {
    window.close();
  }
}

function send_back(module, id) {
  var associated_row_data = associated_javascript_data[id];

  // cn: bug 12274 - stripping false-positive security envelope
  SUGAR.util.globalEval("var temp_request_data = " + window.document.forms['popup_query_form'].request_data.value);
  if (temp_request_data.jsonObject) {
    var request_data = temp_request_data.jsonObject;
  } else {
    var request_data = temp_request_data; // passed data that is NOT incorrectly encoded via JSON.encode();
  }
  // cn: end bug 12274 fix

  var passthru_data = Object();
  if (typeof(request_data.passthru_data) != 'undefined') {
    passthru_data = request_data.passthru_data;
  }
  var form_name = request_data.form_name;
  var field_to_name_array = request_data.field_to_name_array;
  SUGAR.util.globalEval("retValue = window.opener." + request_data.call_back_function);
  var call_back_function = retValue;
  var array_contents = Array();

  // constructs the array of values associated to the bean that the user clicked
  for (var the_key in field_to_name_array) {
    if (the_key != 'toJSON') {
      var the_name = field_to_name_array[the_key];
      var the_value = '';

      if (module != '' && id != '') {
        the_value = associated_row_data[the_key.toUpperCase()];
      }

      array_contents.push('"' + the_name + '":"' + the_value + '"');
    }
  }

  SUGAR.util.globalEval("var name_to_value_array = {'0' : {" + array_contents.join(",") + "}}");

  var result_data = {
    "form_name": form_name,
    "name_to_value_array": name_to_value_array,
    "passthru_data": passthru_data
  };
  var close_popup = window.opener.get_close_popup();

  call_back_function(result_data);

  if (close_popup) {
    window.close();
  }
}