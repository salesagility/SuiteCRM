/**
 * Created by lewis on 13/03/15.
 */

buildEditField();

var inlineEditIcon = $("#Layer_1")[0].outerHTML;
console.log(inlineEditIcon);
var view = action_sugar_grp1;

function buildEditField(){
    $(".inlineEdit").dblclick(function(e) {
        e.preventDefault();

        if(view == "DetailView"){
            var field = $(this).attr( "field" );
            var type = $(this).attr( "type" );
            var module = currentModule;
            var id = $("input[name=parent_id]").attr( "value" );
        }else{
            var field = $(this).attr( "field" );
            var type = $(this).attr( "type" );
            var module = $("#displayMassUpdate input[name=module]").val();
            var id = $(this).closest('tr').find('[type=checkbox]').attr( "value" );
        }

        if(field && id && module){

            var validation = getValidationRules(field,module,id);
            var html = loadFieldHTML(field,module,id);

            if(html){
                $(this).html(validation + "<form name='EditView' id='EditView'><div style='float:left;'>" + html + "</div><div style='margin-top:5px; float:right;'><a id='inlineEditSaveButton' class='button' onclick=''>Save</a></div></form>");

                if(type == "relate") {
                    var relate_js = getRelateFieldJS(field, module, id);
                    $(this).append(relate_js);
                    SUGAR.util.evalScript($(this).html());
                    enableQS(true);
                }

                clickedawayclose(field,id,module);
                validateFormAndSave(field,id,module,type);



                $(this).addClass("inlineEditActive");
                $("#" + field).focus(field,id,module);
                $(".inlineEdit").off('dblclick');
            }


        }

    });
}

function validateFormAndSave(field,id,module,type){
    $("#inlineEditSaveButton").on('click', function () {
        var valid_form = check_form("EditView");
        if(valid_form){
            handleSave(field, id, module, type)
        }else{
            return false
        };
    });
}

function clickedawayclose(field,id,module){
    $(document).on('click', function (e) {

        if(!$(e.target).parents().is(".inlineEditActive, .cal_panel") && !$(e.target).hasClass("inlineEditActive")){
            handleCancel(field,id,module);
            $(document).off('click');
        }

    });
}

function getInputValue(field,type){

    if($('#'+ field).length > 0 && type){

        switch(type) {
            case 'relate':
            case 'phone':
            case 'name':
            case 'varchar':
                if($('#'+ field).val().length > 0) {
                    return $('#'+ field).val();
                }
                break;
            case 'enum':
                if($('#'+ field + ' :selected').text().length > 0){
                    return $('#'+ field + ' :selected').text();
                }
                break;
            case 'datetime':
            case 'datetimecombo':

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
            case 'multienum':
                if($('#'+ field + ' :selected').text().length > 0){
                    return $('select#'+field).val();
                }
                break;
            case 'bool':
                if($('#'+ field).is(':checked')){
                   return "on";
                }else{
                    return "off";
                }
                break;
            default:
                if($('#'+ field).val().length > 0) {
                    return $('#'+ field).val();
                }
        }
    }

}

function handleCancel(field,id,module){
    var output_value = loadFieldHTMLValue(field,id,module);
    var output = setValueClose(output_value);
}

function handleSave(field,id,module,type){
    var value = getInputValue(field,type);
    if(typeof value === "undefined"){
        var value = "";
    }
    var output_value = saveFieldHTML(field,module,id,value);
    var output = setValueClose(output_value);
}

function setValueClose(value){

    $.get('themes/SuiteR/images/inline_edit_icon.svg', function(data) {
        $(".inlineEditActive").html("");
        $(".inlineEditActive").html(value + '<div class="inlineEditIcon">Edit ' + inlineEditIcon + '</div>');
        $(".inlineEditActive").removeClass("inlineEditActive");
    });

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


function loadFieldHTML(field,module,id) {
    $.ajaxSetup({"async": false});
    var result = $.getJSON('index.php',
        {
            'module': 'Home',
            'action': 'getEditFieldHTML',
            'field': field,
            'current_module': module,
            'id': id,
            'to_pdf': true
        }
    );
    $.ajaxSetup({"async": true});
     if(result.responseText){
         console.log("here");
         return(JSON.parse(result.responseText));
     }else{
         return false;
     }


}

function loadFieldHTMLValue(field,id,module) {
    $.ajaxSetup({"async": false});
    var result = $.getJSON('index.php',
        {
            'module': 'Home',
            'action': 'getDisplayValue',
            'field': field,
            'current_module': module,
            'id': id,
            'to_pdf': true
        }
    );
    $.ajaxSetup({"async": true});

    return(result.responseText);
}

function getValidationRules(field,module,id){
    $.ajaxSetup({"async": false});
    var result = $.getJSON('index.php',
        {
            'module': 'Home',
            'action': 'getValidationRules',
            'field': field,
            'current_module': module,
            'id': id,
            'to_pdf': true
        }
    );
    $.ajaxSetup({"async": true});

    var validation = JSON.parse(result.responseText);

    return "<script type='text/javascript'>addToValidate('EditView', \"" + field + "\", \"" + validation['type'] + "\", " + validation['required'] + ",\"" + validation['label'] + "\");</script>";
}

function getRelateFieldJS(field, module, id){
    $.ajaxSetup({"async": false});
    var result = $.getJSON('index.php',
        {
            'module': 'Home',
            'action': 'getRelateFieldJS',
            'field': field,
            'current_module': module,
            'id': id,
            'to_pdf': true
        }
    );
    $.ajaxSetup({"async": true});

    SUGAR.util.evalScript(result.responseText);

    return result.responseText;
}