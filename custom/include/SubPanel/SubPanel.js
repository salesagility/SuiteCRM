/**
 * Created by salesagility on 27/01/14.
 */

function showSearchPanel(subpanel){

    if(document.getElementById(subpanel+'_search') == null){
        buildSerachPanel(subpanel);
    }

    if(document.getElementById(subpanel+'_search').style.display == 'none'){
        document.getElementById(subpanel+'_search').style.display = '';
    } else {
        document.getElementById(subpanel+'_search').style.display = 'none';
    }


}

function buildSerachPanel(subpanel){
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

    $.ajax({url:"index.php?module=Accounts&action=SubPanelSearch&record=108e60ee-816e-f861-4772-5271284d598d&subpanel=history",
        success:function(result){
            table.innerHTML = result;
            SUGAR.util.evalScript(result);
        }
    });

    //table.innerHTML = "<tr><td aligh='left'>&nbsp;</td><td aligh='right'><input id='search_form_submit' class='button' type='submit' value='Search' name='button' onclick='javascript:showSubPanel(\"history\",\"/SuiteCRM/index.php?module=Accounts&action=DetailView&record=108e60ee-816e-f861-4772-5271284d598d&ajax_load=1&loadLanguageJS=1&Accounts_history_CELL_ORDER_BY=&sort_order=desc&to_pdf=true&action=SubPanelViewer&subpanel=history&layout_def_key=Accounts\",true);return false;' title='Search' tabindex='2'></td></tr>";
    col.appendChild(table);

    
}
