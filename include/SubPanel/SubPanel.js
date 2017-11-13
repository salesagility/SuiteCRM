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
    var module = get_module_name();

    var row = tables[0].insertRow(1);
    row.id = subpanel+'_search';
    row.className = "pagination";
    row.style.display = 'none';


    var col = row.insertCell(0);
    col.align = "right";
    col.colSpan = "20";

    var table = document.createElement('table');
    table.width = "100%";

    $.ajax({url:"index.php?module="+module+"&action=SubPanelSearch&subpanel="+subpanel,
        success:function(result){
            table.innerHTML += result;
            SUGAR.util.evalScript(result);
        }
    });

    col.appendChild(table);

}

function submitSearch(subpanel) {
    var submit_data = [];
    var module = get_module_name();
    var id = get_record_id();
    submit_data.push(module);

    $('#'+subpanel+'_search input,select').each(function() {
        var type = $(this).attr("type");

        if ((type == "checkbox" || type == "radio")) {
            if($(this).is(":checked")) submit_data.push($(this).attr("name")+'='+$(this).val());
        }
        else if (type != "button" && type != "submit") {
            if ($(this).val() != '') submit_data.push($(this).attr("name")+'='+encodeURIComponent($(this).val()));
        }
    });

    var url = 'index.php?sugar_body_only=1&module='+module+'&subpanel='+subpanel+'&action=SubPanelViewer&inline=1&record='+id + '&layout_def_key='+submit_data.join('&');
    showSubPanel(subpanel,url,true);
}

function clearSearch(subpanel) {

    $('#'+subpanel+'_search input').each(function() {
        var type = $(this).attr("type");

        if ((type == "checkbox" || type == "radio")) {
            $(this).prop('checked', false);
        }
        else if (type != "button" && type != "submit") {
            $(this).val('');
        }
    });
	
	$('#'+subpanel+'_search select').each(function() {
        var id_temp = $(this).attr("id");
		if ($(this).is("[multiple]"))
		{
			$("#"+id_temp+" > option").attr("selected",false);
		}
		else
		{
			$("#"+id_temp).val( $("#"+id_temp+" option:first-child").val() );
		}
    });   

}