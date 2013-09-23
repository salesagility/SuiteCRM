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


var actln = 0;
var actln_count = 0;

document.getElementById('flow_module').addEventListener("change", showActions, false);

function showActions(){

    flow_module = document.getElementById('flow_module').value;

    if(flow_module != ''){
        document.getElementById('btn_ActionLine').disabled = '';
    } else{
        document.getElementById('btn_ActionLine').disabled = 'disabled';
    }
}


function loadActionLine(action){

    var prefix = 'aow_actions_';
    var ln = 0;

    ln = insertActionLine();

    for(var a in action){
        if(document.getElementById(prefix + a + ln) != null){
            document.getElementById(prefix + a + ln).value = action[a];
        }
    }

    getView(ln,action['id']);

}

function insertActionLine(){

    /*if (document.getElementById(actionLines_head') != null) {
     document.getElementById('actionLines_head').style.display = "";
     }*/

    var app_list_actions=document.getElementById("app_list_actions").value;

    var tableBody = document.createElement("tr");
    tableBody.id = "aow_actions_group_body"+actln;
    document.getElementById('actionLines').appendChild(tableBody);

    var a=tableBody.insertCell(0);
    var table = document.createElement("table");
    table.id = "aow_actions_table" + actln;
    table.style.border = '1px grey solid';
    table.style.borderRadius = '4px';
    table.style.whiteSpace = 'nowrap';
    table.border="1";
    table.width = '950';
    a.appendChild(table);

    tablebody = document.createElement("tbody");
    tablebody.id = "aow_actions_body" + actln;
    table.appendChild(tablebody);


    var x = tablebody.insertRow(-1);
    x.id = 'action_line' + actln;

    var a1 = x.insertCell(0);
    a1.scope="row";
    a1.innerHTML= SUGAR.language.get('AOW_Actions', 'LBL_SELECT_ACTION')+"&nbsp;:&nbsp;<select name='aow_actions_action[" + actln + "]' id='aow_actions_action" + actln + "' onchange='getView(" + actln + ");'>"+ app_list_actions +"</select>";

    var b1 = x.insertCell(1);
    b1.scope="row";
    b1.innerHTML= SUGAR.language.get('AOW_Actions', 'LBL_NAME')+"&nbsp;:&nbsp;<input name='aow_actions_name[" + actln + "]' id='aow_actions_name" + actln + "' type='text'>";

    var c1 = x.insertCell(2);
    c1.scope="row";
    c1.innerHTML = "<span style='float: right;'><a style='cursor: pointer;' id='aow_actions_delete_line" + actln + "' tabindex='116' onclick='markActionLineDeleted(" + actln + ")'><img src='themes/default/images/id-ff-clear.png' alt='X'></a></span>"
    c1.innerHTML += "<input type='hidden' name='aow_actions_deleted[" + actln + "]' id='aow_actions_deleted" + actln + "' value='0'><input type='hidden' name='aow_actions_id[" + actln + "]' id='aow_actions_id" + actln + "' value=''>";


    var y = tablebody.insertRow(-1);
    y.id = 'action_parameter_line' + actln;

    var a2 = y.insertCell(0);
    a2.colSpan = 2;
    a2.innerHTML = "<div id ='action_parameter"+ actln+"' ></div>"



    actln++;
    actln_count++;

    return actln -1;
}

function markActionLineDeleted(ln){

    // collapse line; update deleted value
    document.getElementById('aow_actions_group_body' + ln).style.display = 'none';
    document.getElementById('aow_actions_deleted' + ln).value = '1';
    document.getElementById('aow_actions_delete_line' + ln).onclick = '';

    actln_count--;
    /*if(actln_count == 0){
     document.getElementById('actionLines_head').style.display = "none";
     }*/
}


function getView(ln, id){
    if (typeof id === 'undefined') { id = ''; }

    var callback = {
        success: function(result) {
            document.getElementById('action_parameter' + ln).innerHTML = result.responseText;
            if(document.getElementById('aow_script'+ln) != null){
                eval(document.getElementById('aow_script'+ln).innerHTML);
            }
        }
    }

    var action = document.getElementById('aow_actions_action' + ln).value;
    var module = document.getElementById('flow_module').value;

    var connectionObject = YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOW_WorkFlow&action=getAction&id="+id+"&aow_action="+action+"&line="+ln+"&aow_module="+module,callback);
}