/**
 * Created by lewis on 13/03/15.
 */

buildEditField();

function buildEditField(){
    $(".inlineEdit").dblclick(function() {
        var field = $(this).attr( "field" );
        var module = $("input[name=return_module]").val();
        var id = $(this).closest('tr').find('[type=checkbox]').attr( "value" );
        var value = $(this).html();
        $(this).addClass("inlineEditActive");

        if(field && module && id){
            $html = loadFieldHTML(field,module,id,value);
        }

        $(this).html($html + "<a class='button' onclick='handleSave(\"" + field + "\",\"" + id + "\",\"" + module + "\")'>Save</a><a class='button' onclick='handleCancel(\"" + field + "\")'>Close</a>");
        $(".inlineEdit").off('dblclick');
    });
}

function getInputValue(field){
    return $("[field=" + field +"]").find("input").val();
}

function handleCancel(field){
    var output_value = getInputValue(field);
    var output = setValueClose(output_value);
}

function handleSave(field,id,module){
    var value = getInputValue(field);
    var output_value = saveFieldHTML(field,module,id,value);
    var output = setValueClose(output_value);
}

function setValueClose(value){
    $(".inlineEditActive").html();
    $(".inlineEditActive").html(value);
    $(".inlineEditActive").removeClass("inlineEditActive");
    buildEditField();
}

function saveFieldHTML(field,module,id,value) {
    $.ajaxSetup({"async": false});
    var result = $.getJSON('index.php',
        {
            'module': 'Home',
            'action': 'saveHTMLField',
            'field': field,
            'current_module': module,
            'id': id,
            'value': value,
            'to_pdf': true
        }
    );
    $.ajaxSetup({"async": true});
    return(result.responseText);

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