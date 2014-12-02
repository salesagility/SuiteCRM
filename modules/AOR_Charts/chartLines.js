function loadChartLine(chart){
    var span = $('<tr></tr>');
    var removeButton = $('<button type="button"><img src="themes/default/images/id-ff-remove-nobg.png" alt=""></button>');
    removeButton.click(function(){
        removeButton.closest('tr').remove();
    });
    var cell = $('<td></td>');
    cell.append(removeButton);
    var id = '';
    if(chart['id']){
        id = chart['id'];
    }
    cell.append("<td><input type='hidden' name='aor_chart_id[]' value='"+id+"'></td>");
    span.append(cell);
    var title = '';
    if(chart['name']){
        title = chart['name'];
    }
    var placeholder = SUGAR.language.translate('AOR_Reports','LBL_CHART_TITLE');
    span.append("<td><input type='text' name='aor_chart_title[]' placeholder='"+placeholder+"' value='"+title+"'></td>");

    var cell = $('<td></td>');
    var select = $("<select name='aor_chart_type[]'></select>");
    $.each(SUGAR.language.languages['app_list_strings']['aor_chart_types'],function(key,value){
        var option = $('<option></option>');
        option.val(key);
        option.text(value);
        if(chart['type'] === key){
            option.attr('selected','selected');
        }

        select.append(option);
    });
    cell.append(select);
    span.append(cell);




    span.append("<td><select name='aor_chart_x_field[]' class='chartDimensionSelect' data-value='"+chart.x_field+"'></select></td>");
    span.append("<td><select name='aor_chart_y_field[]' class='chartDimensionSelect' data-value='"+chart.y_field+"'></select></td>");

    $('#chartLines tbody').append(span);
}

function updateChartDimensionSelects(){
    var options = [];
    for(var x = 0; x < fieldln_count; x++){
        options[$('#aor_fields_field_order'+x).val()] = $('#aor_fields_module_path_display'+x).text() + " - "+$('#aor_fields_label'+x).val();
    }
    $('#chartLines .chartDimensionSelect').each(function(index){
        var select = $(this);
        select.empty();
        $.each(options, function(key,val){
            var selected = '';
            if(key == select.data('value')){
                selected = "selected='selected'";
            }
            select.append($('<option '+selected+' ></option').val(key).text(val));
        });

    });



}