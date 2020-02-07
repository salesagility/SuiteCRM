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
    
var emailln = 0;

function show_emailField(cln, value){
    if (typeof value === 'undefined') { value = ''; }

    flow_module = 'AOR_Scheduled_Reports';
    var aor_emailtype = document.getElementById('email_recipients_email_target_type'+cln).value;
    if(aor_emailtype != ''){
        var callback = {
            success: function(result) {
                document.getElementById('emailLine_field'+cln).innerHTML = result.responseText;
                SUGAR.util.evalScript(result.responseText);
                enableQS(false);
            },
            failure: function(result) {
                document.getElementById('emailLine_field'+cln).innerHTML = '';
            }
        };
        
        var aor_field_name = "email_recipients[email]["+cln+"]";

        YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOW_WorkFlow&action=getEmailField&aow_module="+flow_module+"&aow_newfieldname="+aor_field_name+"&aow_type="+aor_emailtype+"&aow_value="+value,callback);
    }
    else {
        document.getElementById('emailLine_field'+cln).innerHTML = '';
    }
}

function load_emailline(to, type, value){
    cln = add_emailLine();
    document.getElementById("email_recipients_email_target_type"+cln).value = type;
    show_emailField(cln, value);
}

function add_emailLine(){

    var aor_email_type_list = document.getElementById("aor_email_type_list").value;
    var aor_email_to_list = document.getElementById("aor_email_to_list").value;

    tablebody = document.createElement("tbody");
    tablebody.id = 'emailLine_body' + emailln;
    document.getElementById('emailLine_table').appendChild(tablebody);

    var x = tablebody.insertRow(-1);
    x.id = 'emailLine'+'_line' + emailln;

    var a = x.insertCell(0);
    a.innerHTML = "<button type='button' id='emailLine_delete" + emailln+"' class='button' value='Remove Line' tabindex='116' onclick='clear_emailLine(this);'><span class='suitepicon suitepicon-action-minus'></span></button> ";

    a.innerHTML += "<select tabindex='116' name='email_recipients[email_target_type]["+emailln+"]' id='email_recipients_email_target_type"+emailln+"' onchange='show_emailField(" + emailln + ");'>" + aor_email_type_list + "</select> ";

    a.innerHTML += "<span id='emailLine_field"+emailln+"'><input id='email_recipients[email]["+emailln+"]' type='text' tabindex='116' size='25' name='email_recipients[email]["+emailln+"]'></span>";


    emailln++;

    return emailln -1;

}

function clear_emailLine(cln){

    document.getElementById('emailLine_table').deleteRow(cln.parentNode.parentNode.rowIndex);
}

function clear_emailLines(){

    var email_rows = document.getElementById('emailLine_table').getElementsByTagName('tr');
    var email_row_length = email_rows.length;
    var i;
    for (i=0; i < email_row_length; i++) {
        document.getElementById('emailLine_table').deleteRow(email_rows[i]);
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