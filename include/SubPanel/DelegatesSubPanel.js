/**
 * Created by jerzy on 27/06/16.
 */
/**
 * Created by salesagility on 27/01/14.
 */

function showSearchPanel(subpanel,id){

    //console.log("Test11111111111 " + subpanel + " " + id);
        buildSearchPanel(subpanel,id);

    if(document.getElementById(subpanel+'_search').style.display == 'none'){
        document.getElementById(subpanel+'_search').style.display = '';
    } else {
        document.getElementById(subpanel+'_search').style.display = 'none';
    }
    //console.log("Test2222222222222");

}

function buildSearchPanel(subpanel, id){
    //console.log("Test2222222222222");
    var tables = document.getElementById("list_subpanel_"+subpanel).getElementsByTagName("table");

    var row = tables[0].insertRow(1);
    row.id = subpanel+'_search';
    row.className = "pagination";
    row.style.display = 'none';


    var col = row.insertCell(0);
    col.align = "right";
    col.colSpan = "20";

    var table = document.createElement('table');
    table.width = "100%";


    var label = SUGAR.language.get('FP_events', 'LBL_NAME');
    table.innerHTML += "<form><label>&ensp;" + label
            + "&ensp;<input type='text' id='filter_param_delegates' name='search_params' value=''></label>"
            + "<label>&ensp;<input type='submit' onclick='submitSearch(\"" + subpanel + "\", \"" + id + "\");return false;'  href='' value='submit'></label>"
            + "<input type='submit' onclick='clearSearch(\"" + subpanel + "\", \"" + id + "\");return false;' href='' value='clear'>"
        + "</form>";
    //console.log("Test2 " + subpanel + " " + id);
    SUGAR.util.evalScript(table.innerHTML);

    col.appendChild(table);

}

function submitSearch(subpanel, id){
    current_child_field = subpanel;
    //
    // console.log("Start Submit Search" + current_child_field);
    // console.log("value " + document.getElementById('filter_param_' + current_child_field).value);

    url='index.php?sugar_body_only=1&module=FP_events&subpanel=' + subpanel + '&entryPoint=filter_subpanel&inline=1&record=' + id + '&layout_def_key=FP_events&search_params=' + escape(document.getElementById('filter_param_' + current_child_field).value) ;
    // console.log(url);

    document.getElementById('show_link_' + subpanel).style.display='none';
    document.getElementById('hide_link_' + subpanel).style.display='';

    showSubPanel(subpanel,url,true, 'FP_events');
    showSearchPanel(subpanel,url,true, 'FP_events');
}


function clearSearch(subpanel, id) {
    $('#' + subpanel + '_search input').each(function () {
        var type = $(this).attr("type");

        if ((type == "checkbox" || type == "radio")) {
            $(this).prop('checked', false);
        }
        else if (type != "button" && type != "submit") {
            $(this).val('');
        }
    });

    $('#' + subpanel + '_search select').each(function () {
        var id_temp = $(this).attr("id");
        if ($(this).is("[multiple]")) {
            $("#" + id_temp + " > option").attr("selected", false);
        }
        else {
            $("#" + id_temp).val($("#" + id_temp + " option:first-child").val());
        }
    });
}

