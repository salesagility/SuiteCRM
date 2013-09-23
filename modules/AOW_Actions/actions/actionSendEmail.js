/**
 * Advanced OpenWorkflow, Automating SugarCRM.
 * @package Advanced OpenWorkflow for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */

var currentln;

function show_edit_template_link(field, ln) {
    console.log("Show edit called");
    console.log('aow_actions_edit_template_link' + ln);
    var field1 = document.getElementById('aow_actions_edit_template_link' + ln);

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
    var field = document.getElementById('aow_actions_param_email_template' + ln);
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
    var field1 = document.getElementById('aow_actions_edit_template_link' + ln);
    field1.style.visibility = "visible";
}

function open_email_template_form(ln) {
    currentln = ln;
    URL = "index.php?module=EmailTemplates&action=EditView&inboundEmail=1&return_module=AOW_WorkFlow&base_module=AOW_WorkFlow";
    URL += "&show_js=1";

    windowName = 'email_template';
    windowFeatures = 'width=800' + ',height=600' + ',resizable=1,scrollbars=1';

    win = window.open(URL, windowName, windowFeatures);
    if (window.focus) {
        // put the focus on the popup if the browser supports the focus() method
        win.focus();
    }
}

function edit_email_template_form(ln) {
    currentln = ln;
    var field = document.getElementById('aow_actions_param_email_template' + ln);
    URL = "index.php?module=EmailTemplates&action=EditView&inboundEmail=1&return_module=AOW_WorkFlow&base_module=AOW_WorkFlow";
    if (field.options[field.selectedIndex].value != 'undefined') {
        URL += "&record=" + field.options[field.selectedIndex].value;
    }
    URL += "&show_js=1";

    windowName = 'email_template';
    windowFeatures = 'width=800' + ',height=600' + ',resizable=1,scrollbars=1';

    win = window.open(URL, windowName, windowFeatures);
    if (window.focus) {
        // put the focus on the popup if the browser supports the focus() method
        win.focus();
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
    var elem = document.getElementById("aow_actions_param_email_target_type"+ln);
    if(elem.value === 'Email Address'){
        showElem("aow_actions_param_email"+ln);
        hideElem("aow_actions_param_email_target"+ln);
        hideElem("aow_actions_email_user_span"+ln);
    }else if(elem.value === 'Specify User'){
        hideElem("aow_actions_param_email"+ln);
        hideElem("aow_actions_param_email_target"+ln);
        showElem("aow_actions_email_user_span"+ln);
    }else if(elem.value === 'Related Field'){
        hideElem("aow_actions_param_email"+ln);
        showElem("aow_actions_param_email_target"+ln);
        hideElem("aow_actions_email_user_span"+ln);
    }else if(elem.value === 'Record Email'){
        hideElem("aow_actions_param_email"+ln);
        hideElem("aow_actions_param_email_target"+ln);
        hideElem("aow_actions_email_user_span"+ln);
    }
}
