/**
 * Advanced OpenReports, SugarCRM Reporting.
 * @package Advanced OpenReports for SugarCRM
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


var condln = 0;
var condln_count = 0;
var report_fields =  new Array();
var report_module = '';

function loadConditionLine(condition, overrideView){

    var prefix = 'aor_conditions_';
    var ln = 0;

    ln = insertConditionLine();

    for(var a in condition){
        var elem = document.getElementById(prefix + a + ln);
        if(elem != null){
            if(elem.nodeName !== 'INPUT') {
                elem.innerHTML = condition[a];
            }else if(elem.getAttribute('type') === 'checkbox'){
                elem.checked = condition[a] == 1;
            }else {
                elem.value = condition[a];
            }
        }
    }

    if (condition['value'] instanceof Array) {
        condition['value'] = JSON.stringify(condition['value'])
    }

    showConditionModuleField(ln, condition['operator'], condition['value_type'], condition['value'],overrideView);
}

function showConditionCurrentModuleFields(ln, value){

    if (typeof value === 'undefined') { value = ''; }

    report_module = document.getElementById('report_module').value;
    var rel_field = document.getElementById('aor_conditions_module_path' + ln).value;

    if(report_module != '' && rel_field != ''){

        var callback = {
            success: function(result) {
                var fields = JSON.parse(result.responseText);

                document.getElementById('aor_conditions_field'+ln).innerHTML = '';

                var selector = document.getElementById('aor_conditions_field'+ln);
                for (var i in fields) {
                    selector.options[selector.options.length] = new Option(fields[i], i);
                }

                if(fields[value] != null ){
                    document.getElementById('aor_conditions_field'+ln).value = value;
                }

                if(value == '') showConditionModuleField(ln);

            }
        }

        YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOR_Reports&action=getModuleFields&aor_module="+report_module+"&view=JSON&rel_field="+rel_field+"&aor_value="+value,callback);

    }

}

function showConditionModuleField(ln, operator_value, type_value, field_value, overrideView){
    if(overrideView === undefined){
        overrideView = action_sugar_grp1;
    }
    if (typeof operator_value === 'undefined') { operator_value = ''; }
    if (typeof type_value === 'undefined') { type_value = ''; }
    if (typeof field_value === 'undefined') { field_value = ''; }

    var rel_field = document.getElementById('aor_conditions_module_path'+ln).value;
    var aor_field = document.getElementById('aor_conditions_field'+ln).value;
    if(aor_field != ''){

        var callback = {
            success: function(result) {
                document.getElementById('aor_conditions_operatorInput'+ln).innerHTML = result.responseText;
                SUGAR.util.evalScript(result.responseText);
            },
            failure: function(result) {
                document.getElementById('aor_conditions_operatorInput'+ln).innerHTML = '';
            }
        }
        var callback2 = {
            success: function(result) {
                document.getElementById('aor_conditions_fieldTypeInput'+ln).innerHTML = result.responseText;
                SUGAR.util.evalScript(result.responseText);
                document.getElementById('aor_conditions_fieldTypeInput'+ln).onchange = function(){showConditionModuleFieldType(ln, undefined, overrideView);};
            },
            failure: function(result) {
                document.getElementById('aor_conditions_fieldTypeInput'+ln).innerHTML = '';
            }
        }
        var callback3 = {
            success: function(result) {
                document.getElementById('aor_conditions_fieldInput'+ln).innerHTML = result.responseText;
                SUGAR.util.evalScript(result.responseText);
                enableQS(false);
            },
            failure: function(result) {
                document.getElementById('aor_conditions_fieldInput'+ln).innerHTML = '';
            }
        }

        var aor_operator_name = "aor_conditions_operator["+ln+"]";
        var aor_field_type_name = "aor_conditions_value_type["+ln+"]";
        var aor_field_name = "aor_conditions_value["+ln+"]";

        YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOR_Reports&action=getModuleOperatorField&view="+overrideView+"&aor_module="+report_module+"&aor_fieldname="+aor_field+"&aor_newfieldname="+aor_operator_name+"&aor_value="+operator_value+"&rel_field="+rel_field,callback);
        YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOR_Reports&action=getFieldTypeOptions&view="+overrideView+"&aor_module="+report_module+"&aor_fieldname="+aor_field+"&aor_newfieldname="+aor_field_type_name+"&aor_value="+type_value+"&rel_field="+rel_field,callback2);
        YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOR_Reports&action=getModuleFieldType&view="+overrideView+"&aor_module="+report_module+"&aor_fieldname="+aor_field+"&aor_newfieldname="+aor_field_name+"&aor_value="+field_value+"&aor_type="+type_value+"&rel_field="+rel_field,callback3);

    } else {
        document.getElementById('aor_conditions_operatorInput'+ln).innerHTML = ''
        document.getElementById('aor_conditions_fieldTypeInput'+ln).innerHTML = '';
        document.getElementById('aor_conditions_fieldInput'+ln).innerHTML = '';
    }
}

function showConditionModuleFieldType(ln, value, overrideView){
    if(overrideView === undefined){
        overrideView = action_sugar_grp1;
    }
    if (typeof value === 'undefined') { value = ''; }

    var callback = {
        success: function(result) {
            document.getElementById('aor_conditions_fieldInput'+ln).innerHTML = result.responseText;
            SUGAR.util.evalScript(result.responseText);
            enableQS(false);
        },
        failure: function(result) {
            document.getElementById('aor_conditions_fieldInput'+ln).innerHTML = '';
        }
    }

    var rel_field = document.getElementById('aor_conditions_module_path'+ln).value;
    var aor_field = document.getElementById('aor_conditions_field'+ln).value;
    var type_value = document.getElementById("aor_conditions_value_type["+ln+"]").value;
    var aor_field_name = "aor_conditions_value["+ln+"]";

    YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOR_Reports&action=getModuleFieldType&view="+overrideView+"&aor_module="+report_module+"&aor_fieldname="+aor_field+"&aor_newfieldname="+aor_field_name+"&aor_value="+value+"&aor_type="+type_value+"&rel_field="+rel_field,callback);

}


/**
 * Insert Header
 */

function insertConditionHeader(){
    var view = action_sugar_grp1;
    tablehead = document.createElement("thead");
    tablehead.id = "conditionLines_head";
    document.getElementById('conditionLines').appendChild(tablehead);

    var x=tablehead.insertRow(-1);
    x.id='conditionLines_head';

    var a=x.insertCell(0);
    //a.style.color="rgb(68,68,68)";

    var b=x.insertCell(1);
    b.style.color="rgb(0,0,0)";
    b.innerHTML=SUGAR.language.get('AOR_Conditions', 'LBL_MODULE_PATH');

    var c=x.insertCell(2);
    c.style.color="rgb(0,0,0)";
    c.innerHTML=SUGAR.language.get('AOR_Conditions', 'LBL_FIELD');

    var d=x.insertCell(3);
    d.style.color="rgb(0,0,0)";
    d.innerHTML=SUGAR.language.get('AOR_Conditions', 'LBL_OPERATOR');

    var e=x.insertCell(4);
    e.style.color="rgb(0,0,0)";
    e.innerHTML=SUGAR.language.get('AOR_Conditions', 'LBL_VALUE_TYPE');

    var f=x.insertCell(5);
    f.style.color="rgb(0,0,0)";
    f.innerHTML=SUGAR.language.get('AOR_Conditions', 'LBL_VALUE');

    if(view === 'EditView') {
        var h = x.insertCell(-1);
        h.style.color = "rgb(0,0,0)";
        h.innerHTML = SUGAR.language.get('AOR_Conditions', 'LBL_PARAMETER');
    }
}

function insertConditionLine(){
    var view = action_sugar_grp1;
    if (document.getElementById('conditionLines_head') == null) {
        insertConditionHeader();
    } else {
        document.getElementById('conditionLines_head').style.display = '';
    }


    tablebody = document.createElement("tbody");
    tablebody.id = "aor_conditions_body" + condln;
    document.getElementById('conditionLines').appendChild(tablebody);


    var x = tablebody.insertRow(-1);
    x.id = 'product_line' + condln;

    var a = x.insertCell(0);
    if(action_sugar_grp1 == 'EditView'){
        a.innerHTML = "<button type='button' id='aor_conditions_delete_line" + condln + "' class='button' value='' tabindex='116' onclick='markConditionLineDeleted(" + condln + ")'><img src='themes/default/images/id-ff-remove-nobg.png' alt=''></button><br>";
        a.innerHTML += "<input type='hidden' name='aor_conditions_deleted[" + condln + "]' id='aor_conditions_deleted" + condln + "' value='0'><input type='hidden' name='aor_conditions_id[" + condln + "]' id='aor_conditions_id" + condln + "' value=''>";
    } else{
        a.innerHTML = condln +1 + "<input class='aor_conditions_id' type='hidden' name='aor_conditions_id[" + condln + "]' id='aor_conditions_id" + condln + "' value=''>";
    }
    a.style.width = '5%';


    var b = x.insertCell(1);
    b.style.width = '15%';
    var viewStyle = 'display:none';
    if(action_sugar_grp1 == 'EditView'){viewStyle = '';}
    b.innerHTML = "<input type='hidden' name='aor_conditions_module_path["+ condln +"]' id='aor_conditions_module_path" + condln + "' value=''>";
    if(action_sugar_grp1 == 'EditView'){viewStyle = 'display:none';}else{viewStyle = '';}
    b.innerHTML += "<span style='width:178px;' id='aor_conditions_module_path_display" + condln + "' ></span>";


    var c = x.insertCell(2);
    c.style.width = '15%';
    var viewStyle = 'display:none';
    if(action_sugar_grp1 == 'EditView'){viewStyle = '';}
    c.innerHTML = "<input type='hidden' name='aor_conditions_field["+ condln +"]' id='aor_conditions_field" + condln + "' value=''>";
    if(action_sugar_grp1 == 'EditView'){viewStyle = 'display:none';}else{viewStyle = '';}
    c.innerHTML += "<span style='width:178px;' id='aor_conditions_field_label" + condln + "' ></span>";


    var d = x.insertCell(3);
    d.id='aor_conditions_operatorInput'+condln;
    d.style.width = '15%';

    var e = x.insertCell(4);
    e.id='aor_conditions_fieldTypeInput'+condln;
    e.style.width = '15%';

    var f = x.insertCell(5);
    f.id='aor_conditions_fieldInput'+condln;
    f.style.width = '30%';


    if(view === 'EditView') {
        var h = x.insertCell(-1);
        h.innerHTML += "<input id='aor_conditions_parameter" + condln + "' name='aor_conditions_parameter[" + condln + "]' value='1' type='checkbox'>";
        h.style.width = '10%';
    }
    condln++;
    condln_count++;

    return condln -1;
}

function markConditionLineDeleted(ln)
{
    // collapse line; update deleted value
    document.getElementById('aor_conditions_body' + ln).style.display = 'none';
    document.getElementById('aor_conditions_deleted' + ln).value = '1';
    document.getElementById('aor_conditions_delete_line' + ln).onclick = '';

    condln_count--;
    if(condln_count == 0){
        document.getElementById('conditionLines_head').style.display = "none";
    }
}

function clearConditionLines(){

    if(document.getElementById('conditionLines') != null){
        var cond_rows = document.getElementById('conditionLines').getElementsByTagName('tr');
        var cond_row_length = cond_rows.length;
        var i;
        for (i=0; i < cond_row_length; i++) {
            if(document.getElementById('aor_conditions_delete_line'+i) != null){
                document.getElementById('aor_conditions_delete_line'+i).click();
            }
        }
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

function date_field_change(field){
    if(document.getElementById(field + '[1]').value == 'now'){
        hideElem(field + '[2]');
        hideElem(field + '[3]');
    } else {
        showElem(field + '[2]');
        showElem(field + '[3]');
    }
}

function addNodeToConditions(node){
    loadConditionLine(
        {
            'label' : node.name,
            'module_path' : node.module_path,
            'module_path_display' : node.module_path_display,
            'field' : node.id,
            'field_label' : node.name});
}