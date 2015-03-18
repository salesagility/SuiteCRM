/**
 * Created by lewis on 13/03/15.
 */

buildEditField();

function buildEditField(){
    $(".inlineEdit").dblclick(function() {
        var field = $(this).attr( "field" );
        var type = $(this).attr( "type" );
        var module = $("input[name=return_module]").val();
        var id = $(this).closest('tr').find('[type=checkbox]').attr( "value" );
        $(this).addClass("inlineEditActive");

        if(field && module && id){
            var html = loadFieldHTML(field,module,id);
            console.log(html);
        }

        $(this).html(html + "<a class='button' onclick='handleSave(\"" + field + "\",\"" + id + "\",\"" + module + "\",\"" + type + "\")'>Save</a><a class='button' onclick='handleCancel(\"" + field + "\")'>Close</a>");
        $(".inlineEdit").off('dblclick');
    });
}

function getInputValue(field,type){

    if($('#'+ field).length > 0 && type){

        switch(type) {
            case 'phone':
            case 'name':
            case 'varchar':
                if($('#'+ field).val().length > 0) {
                    return $('#'+ field).val();
                }
                break;
            case 'enum':
            case 'multienum':
                console.log('#'+ field + ' :selected');
                if($('#'+ field + ' :selected').text().length > 0){
                    return $('#'+ field + ' :selected').text();
                }
                break;
            case 'datetime':
            case 'datetimecombo':

                console.log('#'+ field + '_date :selected');

                if($('#'+ field + '_date').val().length > 0){
                    var date = $('#'+ field + '_date').val();

                }
                if($('#'+ field + '_hours :selected').text().length > 0){
                    var hours = $('#'+ field + '_hours :selected').text();
                }
                if($('#'+ field + '_minutes :selected').text().length > 0){
                    var minutes = $('#'+ field + '_minutes :selected').text();
                }
                if($('#'+ field + '_meridiem :selected').text().length > 0){
                    var meridiem = $('#'+ field + '_meridiem :selected').text();
                }
                return date + " " + hours +":"+ minutes + meridiem;

                break;
            case 'date':
                if($('#'+ field + ' :selected').text().length > 0){
                    return $('#'+ field + ' :selected').text();
                }
                break;
            default:
                if($('#'+ field).val().length > 0) {
                    return $('#'+ field).val();
                }
        }
    }

}

function handleCancel(field){
    var output_value = getInputValue(field);
    var output = setValueClose(output_value);
}

function handleSave(field,id,module,type){
    var value = getInputValue(field,type);
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