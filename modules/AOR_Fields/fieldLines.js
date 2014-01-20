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


var fieldln = 0;
var fieldln_count = 0;
var report_rel_modules =  new Array();
var report_fields =  new Array();
var report_module = '';

YUI().use('sortable', function(Y) {
    var sortable = new Y.Sortable({
        container: '#fieldLines',
        nodes: 'tbody',
        opacity: '.1'
    });

    Y.DD.DDM.on('drag:end', fieldSort);
});

document.getElementById('report_module').addEventListener("change", showFieldModuleFields, false);

function loadFieldLine(field){

    var prefix = 'aor_fields_';
    var ln = 0;

    ln = insertFieldLine();

    for(var a in field){
        if(document.getElementById(prefix + a + ln) != null){
            if(document.getElementById(prefix + a + ln).type == 'checkbox'){
                if(field[a] == 1){
                    document.getElementById(prefix + a + ln).checked = true;
                } else {
                    document.getElementById(prefix + a + ln).checked = false;
                }

            } else {
                document.getElementById(prefix + a + ln).value = field[a];
            }
        }
    }

    var select_field = document.getElementById('aor_fields_field'+ln);
    document.getElementById('aor_fields_field_label'+ln).innerHTML = select_field.options[select_field.selectedIndex].text;

    /*if (field['value'] instanceof Array) {
        field['value'] = JSON.stringify(field['value'])
    }*/
    showFieldModuleField(ln, field['field_function'], field['label']);

    //getView(ln,action['id']);

}

function showFieldModuleFields(){

    clearFieldLines();

    report_module = document.getElementById('report_module').value;

    if(report_module != ''){

        var callback = {
            success: function(result) {
                report_rel_modules = result.responseText;
            }
        }
        var callback2 = {
            success: function(result) {
                report_fields = result.responseText;
                document.getElementById('btn_FieldLine').disabled = '';
            }
        }

        YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOR_Reports&action=getModuleRelationships&aor_module="+report_module,callback);
        YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOR_Reports&action=getModuleFields&view=EditView&aor_module="+report_module,callback2);

    }

}

function showFieldCurrentModuleFields(ln, value){

    if (typeof value === 'undefined') { value = ''; }

    report_module = document.getElementById('report_module').value;
    var rel_field = document.getElementById('aor_fields_module_path' + ln).value;

    if(report_module != '' && rel_field != ''){

        var callback = {
            success: function(result) {
                var fields = JSON.parse(result.responseText);

                document.getElementById('aor_fields_field'+ln).innerHTML = '';

                var selector = document.getElementById('aor_fields_field'+ln);
                for (var i in fields) {
                    selector.options[selector.options.length] = new Option(fields[i], i);
                }

                if(fields[value] != null ){
                    document.getElementById('aor_fields_field'+ln).value = value;
                }
                if(value == '') showFieldModuleField(ln);
            }
        }

        YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOR_Reports&action=getModuleFields&aor_module="+report_module+"&view=JSON&rel_field="+rel_field+"&aor_value="+value,callback);

    }

}

function showFieldModuleField(ln, function_value, label_value){
    if (typeof function_value === 'undefined') { function_value = ''; }
    if (typeof label_value === 'undefined') { label_value = ''; }

    var aor_field = document.getElementById('aor_fields_field'+ln).value;
    if(aor_field != ''){

        var callback = {
            success: function(result) {
                document.getElementById('aor_fields_fieldFunction'+ln).innerHTML = result.responseText;
                SUGAR.util.evalScript(result.responseText);

                var select_field = document.getElementById('aor_fields_field'+ln);
                if(label_value === ''){
                    document.getElementById('aor_fields_label'+ln).value = select_field.options[select_field.selectedIndex].text;
                }

            },
            failure: function(result) {
                fieldResetLine(ln);
            }
        }

        var aor_field_name = "aor_fields_field_function["+ln+"]";

        YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOR_Reports&action=getModuleFunctionField&view="+action_sugar_grp1+"&aor_module="+report_module+"&aor_fieldname="+aor_field+"&aor_newfieldname="+aor_field_name+"&aor_value="+function_value,callback);

    } else {
        fieldResetLine(ln);
    }
}

function fieldResetLine(ln){
    document.getElementById('aor_fields_display'+ln).checked = true;
    document.getElementById('aor_fields_link'+ln).checked = false;
    document.getElementById('aor_fields_label'+ln).value = '';
    document.getElementById('aor_fields_fieldFunction'+ln).innerHTML = '';
    document.getElementById('aor_fields_sort_by'+ln).value = '';
    document.getElementById('aor_fields_group_by'+ln).checked = false;
}

function showFieldModuleFieldType(ln, value){
    if (typeof value === 'undefined') { value = ''; }

    var callback = {
        success: function(result) {
            document.getElementById('aor_fields_fieldInput'+ln).innerHTML = result.responseText;
            SUGAR.util.evalScript(result.responseText);
            enableQS(false);
        },
        failure: function(result) {
            document.getElementById('aor_fields_fieldInput'+ln).innerHTML = '';
        }
    }

    var aor_field = document.getElementById('aor_fields_field'+ln).value;
    var type_value = document.getElementById("aor_fields_value_type["+ln+"]").value;
    var aor_field_name = "aor_fields_value["+ln+"]";

    YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOR_Reports&action=getModuleFieldType&view="+action_sugar_grp1+"&aor_module="+report_module+"&aor_fieldname="+aor_field+"&aor_newfieldname="+aor_field_name+"&aor_value="+value+"&aor_type="+type_value,callback);

}


/**
 * Insert Header
 */

function insertFieldHeader(){
    tablehead = document.createElement("thead");
    tablehead.id = "fieldLines_head";
    document.getElementById('fieldLines').appendChild(tablehead);

    var x=tablehead.insertRow(-1);
    x.id='fieldLines_head';

    var a=x.insertCell(0);
    //a.style.color="rgb(68,68,68)";

    var b=x.insertCell(1);
    b.style.color="rgb(0,0,0)";
    b.innerHTML=SUGAR.language.get('AOR_Fields', 'LBL_MODULE_PATH');

    var b1=x.insertCell(2);
    b1.style.color="rgb(0,0,0)";
    b1.innerHTML=SUGAR.language.get('AOR_Fields', 'LBL_FIELD');

    var c=x.insertCell(3);
    c.style.color="rgb(0,0,0)";
    c.innerHTML=SUGAR.language.get('AOR_Fields', 'LBL_DISPLAY');

    var d=x.insertCell(4);
    d.style.color="rgb(0,0,0)";
    d.innerHTML=SUGAR.language.get('AOR_Fields', 'LBL_LINK');

    var e=x.insertCell(5);
    e.style.color="rgb(0,0,0)";
    e.innerHTML=SUGAR.language.get('AOR_Fields', 'LBL_LABEL');

    var f=x.insertCell(6);
    f.style.color="rgb(0,0,0)";
    f.innerHTML=SUGAR.language.get('AOR_Fields', 'LBL_FUNCTION');

    var g=x.insertCell(7);
    g.style.color="rgb(0,0,0)";
    g.innerHTML=SUGAR.language.get('AOR_Fields', 'LBL_SORT');

    var h=x.insertCell(8);
    h.style.color="rgb(0,0,0)";
    h.innerHTML=SUGAR.language.get('AOR_Fields', 'LBL_GROUP');
}

function insertFieldLine(){

    if (document.getElementById('fieldLines_head') == null) {
        insertFieldHeader();
    } else {
        document.getElementById('fieldLines_head').style.display = '';
    }


    tablebody = document.createElement("tbody");
    tablebody.id = "aor_fields_body" + fieldln;
    document.getElementById('fieldLines').appendChild(tablebody);


    var x = tablebody.insertRow(-1);
    x.id = 'field_line' + fieldln;

    var a = x.insertCell(0);
    if(action_sugar_grp1 == 'EditView'){
        a.innerHTML = "<button type='button' id='aor_fields_delete_line" + fieldln + "' class='button' value='' tabindex='116' onclick='markFieldLineDeleted(" + fieldln + ")'><img src='themes/default/images/id-ff-remove-nobg.png' alt=''></button><br>";
        a.innerHTML += "<input type='hidden' name='aor_fields_deleted[" + fieldln + "]' id='aor_fields_deleted" + fieldln + "' value='0'><input type='hidden' name='aor_fields_id[" + fieldln + "]' id='aor_fields_id" + fieldln + "' value=''>";
    } else{
        a.innerHTML = fieldln +1;
    }
    a.innerHTML += "<input type='hidden' name='aor_fields_field_order[" + fieldln + "]' id='aor_fields_field_order" + fieldln + "' value='"+fieldln+"'>"
    a.style.width = '5%';

    var b = x.insertCell(1);
    b.style.width = '12%';
    var viewStyle = 'display:none';
    if(action_sugar_grp1 == 'EditView'){viewStyle = '';}
    b.innerHTML = "<select style='width:178px;"+viewStyle+"' name='aor_fields_module_path["+ fieldln +"][0]' id='aor_fields_module_path" + fieldln + "' value='' title='' tabindex='116' onchange='showFieldCurrentModuleFields(" + fieldln + ");'>" + report_rel_modules + "</select>";
    if(action_sugar_grp1 == 'EditView'){viewStyle = 'display:none';}else{viewStyle = '';}
    b.innerHTML += "<span style='width:178px;"+viewStyle+"' id='aor_fields_field_label" + fieldln + "' ></span>";

    var b1 = x.insertCell(2);
    b1.style.width = '12%';
    var viewStyle = 'display:none';
    if(action_sugar_grp1 == 'EditView'){viewStyle = '';}
    b1.innerHTML = "<select style='width:178px;"+viewStyle+"' name='aor_fields_field["+ fieldln +"]' id='aor_fields_field" + fieldln + "' value='' title='' tabindex='116' onchange='showFieldModuleField(" + fieldln + ");'>" + report_fields + "</select>";
    if(action_sugar_grp1 == 'EditView'){viewStyle = 'display:none';}else{viewStyle = '';}
    b1.innerHTML += "<span style='width:178px;"+viewStyle+"' id='aor_fields_field_label" + fieldln + "' ></span>";

    var c = x.insertCell(3);
    c.innerHTML = "<input name='aor_fields_display["+ fieldln +"]' value='0' type='hidden'>";
    c.innerHTML += "<input id='aor_fields_display" + fieldln + "' name='aor_fields_display["+ fieldln +"]' value='1' type='checkbox' CHECKED>";
    c.style.width = '5%';

    var d = x.insertCell(4);
    d.innerHTML = "<input name='aor_fields_link["+ fieldln +"]' value='0' type='hidden'>";
    d.innerHTML += "<input id='aor_fields_link" + fieldln + "' name='aor_fields_link["+ fieldln +"]' value='1' type='checkbox'>";
    d.style.width = '5%';

    var e = x.insertCell(5);
    e.innerHTML = "<input name='aor_fields_label["+ fieldln +"]' id='aor_fields_label" + fieldln + "' size='20' maxlength='150' value='' type='text'>";
    e.style.width = '12%';

    var f = x.insertCell(6);
    f.id='aor_fields_fieldFunction'+fieldln;
    f.style.width = '10%';

    var g=x.insertCell(7);
    g.innerHTML = "<select type='text' name='aor_fields_sort_by["+ fieldln +"]' id='aor_fields_sort_by" + fieldln + "'>"+sort_by_values+"</select>";
    g.style.width = '10%';

    var h=x.insertCell(8);
    h.innerHTML = "<input name='aor_fields_group_by["+ fieldln +"]' value='0' type='hidden'>";
    h.innerHTML += "<input id='aor_fields_group_by" + fieldln + "' name='aor_fields_group_by["+ fieldln +"]' value='1' type='checkbox'>";
    h.style.width = '12%';

    fieldln++;
    fieldln_count++;

    return fieldln -1;
}

function markFieldLineDeleted(ln)
{
    // collapse line; update deleted value
    document.getElementById('aor_fields_body' + ln).style.display = 'none';
    document.getElementById('aor_fields_deleted' + ln).value = '1';
    document.getElementById('aor_fields_delete_line' + ln).onclick = '';

    fieldln_count--;
    if(fieldln_count == 0){
        document.getElementById('fieldLines_head').style.display = "none";
    }
}

function clearFieldLines(){

    if(document.getElementById('fieldLines') != null){
        var cond_rows = document.getElementById('fieldLines').getElementsByTagName('tr');
        var cond_row_length = cond_rows.length;
        var i;
        for (i=0; i < cond_row_length; i++) {
            if(document.getElementById('aor_fields_delete_line'+i) != null){
                document.getElementById('aor_fields_delete_line'+i).click();
            }
        }
    }
}

function fieldSort(){
    if(document.getElementById('fieldLines') != null){
        var cond_rows = document.getElementById('fieldLines').getElementsByTagName('tr');
        var cond_row_length = cond_rows.length;
        var i;
        for (i=0; i < cond_row_length; i++) {
            var input = cond_rows[i].getElementsByTagName('input');
            var j;
            for (j=0; j < input.length; j++) {
                if (input[j].id.indexOf('aor_fields_field_order') != -1) {
                    input[j].value = i;
                }
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

