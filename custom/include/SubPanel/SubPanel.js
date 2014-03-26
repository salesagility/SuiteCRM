/**
 * Created by salesagility on 27/01/14.
 */

function showSearchPanel(subpanel){

    if(document.getElementById(subpanel+'_search') == null){
        buildSearchPanel(subpanel);
    }

    if(document.getElementById(subpanel+'_search').style.display == 'none'){
        document.getElementById(subpanel+'_search').style.display = '';
    } else {
        document.getElementById(subpanel+'_search').style.display = 'none';
    }


}

function buildSearchPanel(subpanel){
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

    $.ajax({url:"index.php?module=Accounts&action=SubPanelSearch&subpanel="+subpanel,
        success:function(result){
            table.innerHTML += result;
            SUGAR.util.evalScript(result);
        }
    });

    col.appendChild(table);

}

function submitSearch(subpanel) {
    var inputValues = [];
    $('#'+subpanel+'_search input,select').each(function() {
        var type = $(this).attr("type");

        if ((type == "checkbox" || type == "radio")) {
            if($(this).is(":checked")) inputValues.push($(this).val());
        }
        else if (type != "button" && type != "submit") {
            inputValues.push($(this).val());
        }
    })
    alert(inputValues.join(','));
}