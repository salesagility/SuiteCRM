/**
 * Created by lewis on 13/03/15.
 */

$(".inlineEdit").dblclick(function() {

    var field = $(this).attr( "field" );
    var module = $("input[name=return_module]").val();
    var id = $(this).closest('tr').find('[type=checkbox]').attr( "value" );
    var value = $(this).html();

    if(field && module && id){
        $html = loadFieldHTML(field,module,id,value);
    }

    $(this).html($html + "<a onclick='handleSave(\"" +field + "\")'>Save</a>");

    $(".inlineEdit").off('dblclick');

});

function handleSave(field){

    var value = $("." + field).val();
    alert(value);
}


function saveFieldHTML(field,module,id,value) {
    $.ajaxSetup({"async": false});
    var result = $.getJSON('index.php',
        {
            'module': 'Home',
            'action': 'getEditFieldHTML',
            'field': field,
            'current_module': module,
            'id': id,
            'value': value,
            'to_pdf': true
        }
    );
    $.ajaxSetup({"async": true});

    return(JSON.parse(result.responseText));

}


function loadFieldHTML(field,module,id,value) {
    $.ajaxSetup({"async": false});
    var result = $.getJSON('index.php',
        {
            'module': 'Home',
            'action': 'getEditFieldHTML',
            'field': field,
            'current_module': module,
            'id': id,
            'value': value,
            'to_pdf': true
        }
    );
    $.ajaxSetup({"async": true});

    return(JSON.parse(result.responseText));

}