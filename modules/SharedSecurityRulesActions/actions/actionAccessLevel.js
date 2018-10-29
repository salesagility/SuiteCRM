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

var currentln;
var emailln = new Array();

function show_edit_template_link(field, ln) {
    var field1 = document.getElementById('shared_rules_actions_edit_template_link' + ln);

    if (field.selectedIndex == 0) {
        field1.style.visibility = "hidden";
    } else {
        field1.style.visibility = "visible";
    }
}

function refresh_email_template_list(template_id, template_name) {
    refresh_template_list(template_id, template_name,currentln);
}

function refresh_template_list(template_id, template_name, ln) {
    var field = document.getElementById('shared_rules_actions_param_email_template' + ln);
    var bfound = 0;
    for (var i = 0; i < field.options.length; i++) {
        if (field.options[i].value == template_id) {
            if (field.options[i].selected == false) {
                field.options[i].selected = true;
            }
            field.options[i].text = template_name;
            bfound = 1;
        }
    }
    //add item to selection list.
    if (bfound == 0) {
        var newElement = document.createElement('option');
        newElement.text = template_name;
        newElement.value = template_id;
        field.options.add(newElement);
        newElement.selected = true;
    }

    //enable the edit button.
    var field1 = document.getElementById('shared_rules_actions_edit_template_link' + ln);
    field1.style.visibility = "visible";
}

function open_email_template_form(ln) {
    currentln = ln;
    URL = "index.php?module=EmailTemplates&action=EditView&inboundEmail=1&return_module=AOW_WorkFlow&base_module=AOW_WorkFlow";
    URL += "&show_js=1";

    windowName = 'email_template';
    windowFeatures = 'width=800' + ',height=600' + ',resizable=1,semailollbars=1';

    win = window.open(URL, windowName, windowFeatures);
    if (window.focus) {
        // put the focus on the popup if the browser supports the focus() method
        win.focus();
    }
}

function edit_email_template_form(ln) {
    currentln = ln;
    var field = document.getElementById('shared_rules_actions_param_email_template' + ln);
    URL = "index.php?module=EmailTemplates&action=EditView&inboundEmail=1&return_module=AOW_WorkFlow&base_module=AOW_WorkFlow";
    if (field.options[field.selectedIndex].value != 'undefined') {
        URL += "&record=" + field.options[field.selectedIndex].value;
    }
    URL += "&show_js=1";

    windowName = 'email_template';
    windowFeatures = 'width=800' + ',height=600' + ',resizable=1,semailollbars=1';

    win = window.open(URL, windowName, windowFeatures);
    if (window.focus) {
        // put the focus on the popup if the browser supports the focus() method
        win.focus();
    }
}
function assign_field_change(field){
  hideElem(field + '[1]');
  hideElem(field + '[2]');

  if(document.getElementById(field + '[0]').value == 'role'){
    showElem(field + '[2]');
  }
  else if(document.getElementById(field + '[0]').value == 'security_group'){
    showElem(field + '[1]');
    showElem(field + '[2]');
  }
}

function show_emailField(ln, cln, value){
    if (typeof value === 'undefined') { value = ''; }

    flow_module = document.getElementById('flow_module').value;
    var aow_emailtype = document.getElementById('shared_rules_actions_param'+ln+'_email_target_type'+cln).value;
    if(aow_emailtype != ''){
        var callback = {
            success: function(result) {
                document.getElementById('emailLine'+ln+'_field'+cln).innerHTML = result.responseText;
                SUGAR.util.evalScript(result.responseText);
                enableQS(false);
            },
            failure: function(result) {
                document.getElementById('emailLine'+ln+'_field'+cln).innerHTML = '';
            }
        }

        var aow_field_name = "shared_rules_actions_param["+ln+"][email]["+cln+"]";

        YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOW_WorkFlow&action=getEmailField&aow_module="+flow_module+"&aow_newfieldname="+aow_field_name+"&aow_type="+aow_emailtype+"&aow_value="+value,callback);
    }
    else {
        document.getElementById('emailLine'+ln+'_field'+cln).innerHTML = '';
    }
}

function load_emailline(ln, to, type, value){
    cln = add_emailLine(ln);
    document.getElementById("shared_rules_actions_param"+ln+"_accesslevel"+cln).value = to;
    document.getElementById("shared_rules_actions_param"+ln+"_email_target_type"+cln).value = type;
    show_emailField(ln, cln, value);
}

function add_emailLine(ln){

    var aow_email_type_list = document.getElementById("aow_email_type_list").value;
    var aow_email_to_list = document.getElementById("aow_email_to_list").value;
    var sharedGroupRules = document.getElementById("sharedGroupRule").value;

    if(emailln[ln] == null){emailln[ln] = 0}

    tablebody = document.createElement("tbody");
    tablebody.id = 'emailLine'+ln+'_body' + emailln[ln];
    document.getElementById('emailLine'+ln+'_table').appendChild(tablebody);

    var x = tablebody.insertRow(-1);
    x.id = 'emailLine'+ln+'_line' + emailln[ln];

    var a = x.insertCell(0);
    a.innerHTML = "<button type='button' id='emailLine"+ln+"_delete" + emailln[ln]+"' class='button' value='Remove Line' tabindex='116' onclick='clear_emailLine(" + ln + ",this);' style='padding: 6px 6px; font-size: 25px; height: 29px; line-height: 0;'>-</button> ";

    a.innerHTML += "<select tabindex='116' name='shared_rules_actions_param["+ln+"][accesslevel]["+emailln[ln]+"]' id='shared_rules_actions_param"+ln+"_accesslevel"+emailln[ln]+"'>" + sharedGroupRules + "</select> ";

    a.innerHTML += "<select tabindex='116' name='shared_rules_actions_param["+ln+"][email_target_type]["+emailln[ln]+"]' id='shared_rules_actions_param"+ln+"_email_target_type"+emailln[ln]+"' onchange='show_emailField(" + ln + "," + emailln[ln] + ");'>" + aow_email_type_list + "</select> ";

    a.innerHTML += "<span id='emailLine"+ln+"_field"+emailln[ln]+"'></span>";


    emailln[ln]++;

    return emailln[ln] -1;

}

function clear_emailLine(ln, cln){

    document.getElementById('emailLine'+ln+'_table').deleteRow(cln.parentNode.parentNode.rowIndex);
}

function clear_emailLines(ln){

    var email_rows = document.getElementById('emailLine'+ln+'_table').getElementsByTagName('tr');
    var email_row_length = email_rows.length;
    var i;
    for (i=0; i < email_row_length; i++) {
        document.getElementById('emailLine'+ln+'_table').deleteRow(email_rows[i]);
    }
}

function hideElem(id){
    if(document.getElementById(id)){
        document.getElementById(id).style.display = "none";
        document.getElementById(id).value = "";
    }
}

function showElem(id){
    if(document.getElementById(id)){
        document.getElementById(id).style.display = "";
    }
}

function targetTypeChanged(ln){
    var elem = document.getElementById("shared_rules_actions_param_email_target_type"+ln);
    if(elem.value === 'Email Address'){
        showElem("shared_rules_actions_param_email"+ln);
        hideElem("shared_rules_actions_param_email_target"+ln);
        hideElem("shared_rules_actions_email_user_span"+ln);
    }else if(elem.value === 'Specify User'){
        hideElem("shared_rules_actions_param_email"+ln);
        hideElem("shared_rules_actions_param_email_target"+ln);
        showElem("shared_rules_actions_email_user_span"+ln);
    }else if(elem.value === 'Related Field'){
        hideElem("shared_rules_actions_param_email"+ln);
        showElem("shared_rules_actions_param_email_target"+ln);
        hideElem("shared_rules_actions_email_user_span"+ln);
    }else if(elem.value === 'Record Email'){
        hideElem("shared_rules_actions_param_email"+ln);
        hideElem("shared_rules_actions_param_email_target"+ln);
        hideElem("shared_rules_actions_email_user_span"+ln);
    }
}
