/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2015 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

buildEditField();

//Global Variables.

var inlineEditSaveButtonImg = "themes/SuiteR/images/inline_edit_save_icon.svg";
var inlineEditIcon = $("#inline_edit_icon")[0].outerHTML;
var view = action_sugar_grp1;
var currentModule = module_sugar_grp1;


var clicks = 0;
timer = null;

function buildEditField(){
    $(".inlineEdit a").click(function (e) {
    	
    	if(e.which !== undefined && e.which === 2){
            return;
        }
        
        if(this.id != "inlineEditSaveButton") {
            var linkUrl = $(this).attr("href");
			var linkTarget = $(this).attr("target");
			
            if (typeof clicks == 'undefined') {
                clicks = 0;
            }
            clicks++;

            e.preventDefault();
            // if single click just want default action of following link, but want to wait in case user is actually trying to double click to edit field
            // Proposed fix for issue #364 (click X icon to close redirects to bad url /undefined causing a 404 http error).
            // Fix issue when click a close ( X ) button
            if (typeof linkUrl === "undefined") {
                return false;
            }
            if (clicks == 1) {

                timer = setTimeout(function () {
                    // if reaches end of timeout without another click follow link
					if (linkTarget)
						window.open(linkUrl, linkTarget);
					else
						window.location.href = linkUrl;
                    clicks = 0;             //after action performed, reset counter

                }, 500);

            } else {

                clearTimeout(timer);    //prevent single-click action
                clicks = 0;

            }
        }
    });
    $(".inlineEdit").dblclick(function(e) {
        e.preventDefault();
        //depending on what view you are using will find the id,module,type of field, and field name from the view
        if(view == "DetailView"){
            var field = $(this).attr( "field" );
            var type = $(this).attr( "type" );

            if(currentModule){
                var module = currentModule;
            }else{
                var module = module_sugar_grp1;
            }

            var id = $("input[name=record]").attr( "value" );
        }else{
            var field = $(this).attr( "field" );
            var type = $(this).attr( "type" );
            var module = $("#displayMassUpdate input[name=module]").val();
            var id = $(this).closest('tr').find('[type=checkbox]').attr( "value" );
        }

        //If we find all the required variables to do inline editing.
        if(field && id && module){

            //Do ajax call to retrieve the validation for the field.
            var validation = getValidationRules(field,module,id);
            //Do ajax call to retrieve the html elements of the field.
            var html = loadFieldHTML(field,module,id);

            //If we have the field html append it to the div we clicked.
            if(html){
                $(this).html(validation + "<form name='EditView' id='EditView'><div id='inline_edit_field'>" + html + "</div><a id='inlineEditSaveButton'></a></form>");
                $("#inlineEditSaveButton").load(inlineEditSaveButtonImg);
                //If the field is a relate field we will need to retrieve the extra js required to make the field work.
                if(type == "relate" || type == "parent") {
                    var relate_js = getRelateFieldJS(field, module, id);
                    $(this).append(relate_js);
                    SUGAR.util.evalScript($(this).html());
                    //Needs to be called to enable quicksearch/typeahead functionality on the field.
                    enableQS(true);
                }

                //Add the active class so we know which td we are editing as they all have the inlineEdit class.
                $(this).addClass("inlineEditActive");

                //Put the cursor in the field if possible.
                $("#" + field).focus();
                if(type == "name" || type == "text") {
                    // move focus to end of text (multiply by 2 to make absolute certain its end as some browsers count carriage return as more than 1 character)
                    var strLength = $("#" + field).val().length * 2;
                    $("#" + field)[0].setSelectionRange(strLength, strLength);
                }

                //We can only edit one field at a time currently so turn off the on dblclick event
                $(".inlineEdit").off('dblclick');

                //Call the click away function to handle if the user has clicked off the field, if they have it will close the form.
                clickedawayclose(field,id,module, type);

                //Make sure the data is valid and save the details to the bean.
                validateFormAndSave(field,id,module,type);

            }
        }

    });
}

/**
 * On click event to check if form is valid then submit the form if it is or returns false.
 * @param field - name of the field we are editing
 * @param id - the id of the record we are editing
 * @param module - the module we are editing
 * @param type - the type of the field we are editing.
 */
function validateFormAndSave(field,id,module,type){
    $("#inlineEditSaveButton").on('click', function () {
        var valid_form = check_form("EditView");
        if(valid_form){
            handleSave(field, id, module, type)
            $(document).off('click');
        }else{
            return false
        };
    });
    // also want to save on enter/return being pressed
    $(document).keypress(function(e) {

        if (e.which == 13) {
            e.preventDefault();
            $("#inlineEditSaveButton").click();
        }
    });
}



/**
 * Checks if any of the parent elemenets of the current element have the class inlineEditActive this means they are within
 * the current element and have not clicked away from the field. Note we need to check on .cal_panel too for the calendar popup.
 * @param field - name of the field we are editing
 * @param id - the id of the record we are editing
 * @param module - the module we are editing
 */

function clickedawayclose(field,id,module, type){
    $(document).on('click', function (e) {

        if(!$(e.target).parents().is(".inlineEditActive, .cal_panel") && !$(e.target).hasClass("inlineEditActive")){
            var output_value = loadFieldHTMLValue(field,id,module);
            var user_value = getInputValue(field, type);
            if(user_value != output_value) {
                var r = confirm("You have clicked away from the field you were editing without saving it. Click ok if you're happy to lose your change, or cancel if you would like to continue editing " + field);
                if(r == true) {
                    var output = setValueClose(output_value);
                    $(document).off('click');
                } else {
                    $("#" + field).focus();
                    e.preventDefault();
                }
            } else {
                // user hasn't changed value so can close field without warning them first
                var output = setValueClose(output_value);
                $(document).off('click');
            }
        }

    });
}


/**
 * Depending on what type of field we are editing the parts of the field may differ and need different jquery to pickup the values
 * and format them, for example a date time field.
 *
 * This function will take a field and its type and try find the revlevent parts of the field required to save the value correctly.
 * @param field - name of the field we are editing
 * @param type - the type of the field we are editing.
 * @returns {*}
 */

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
                if($('#'+ field + '_date').val().length > 0){var date = $('#'+ field + '_date').val();}
                else var date = 00;
                if($('#'+ field + '_hours :selected').text().length > 0){var hours = $('#'+ field + '_hours :selected').text();}
                else var hours = 00;
                if($('#'+ field + '_minutes :selected').text().length > 0){var minutes = $('#'+ field + '_minutes :selected').text();}
                else var minutes = 00;
                if($('#'+ field + '_meridiem :selected').text().length > 0){var meridiem = $('#'+ field + '_meridiem :selected').text();}
                else var meridiem = "";
                return date + " " + hours +":"+ minutes + meridiem;
                break;
            case 'date':
                //if($('#'+ field + ' :selected').text().length > 0){
                if($('#'+ field).val().length > 0){
                    return $('#'+ field).val();
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
    } else if(type == "parent" && $('#parent_id').val().length > 0) {
        return $('#parent_id').val();
    }

}


/**
 * Handles the submit of the form.
 * If we have value set pass it through if we don't then send a blank value this is so we can set a field to blank.
 * Save the value to the bean via an ajax call.
 * set the returned value from the ajax call to the td inner html.
 *
 * @param field - name of the field we are editing
 * @param id - the id of the record we are editing
 * @param module - the module we are editing
 * @param type - the type of the field we are editing.
 */

function handleSave(field,id,module,type){
    var value = getInputValue(field,type);
    var parent_type = "";
    if(typeof value === "undefined"){
        var value = "";
    }

    if(type == "parent") {
            parent_type = $('#parent_type').val();
    }


    var output_value = saveFieldHTML(field,module,id,value, parent_type);
    var output = setValueClose(output_value);
}

/**
 * Takes the value and places it inside the td, also inputs the edit icon stuff as this was removed when the field was retrieved.
 * Calls buildEditField() to re add the on dblclick event.
 * @param value
 */

function setValueClose(value){

    $.get('themes/SuiteR/images/inline_edit_icon.svg', function(data) {
        $(".inlineEditActive").html("");
        $(".inlineEditActive").html(value + '<div class="inlineEditIcon">' + inlineEditIcon + '</div>');
        $(".inlineEditActive").removeClass("inlineEditActive");
    });

    buildEditField();
}

/**
 * Ajax call to save the field to the sugar bean.
 * Calls a controller action in /modules/Home/controller.
 * Returns the formatted output value of the field.
 * @param field
 * @param module
 * @param id
 * @param value
 * @returns {*}
 */

function saveFieldHTML(field,module,id,value, parent_type) {
    $.ajaxSetup({"async": false});
    var result = $.getJSON('index.php',
        {
            'module': 'Home',
            'action': 'saveHTMLField',
            'field': field,
            'current_module': module,
            'id': id,
            'value': value,
            'view' : view,
            'parent_type': parent_type,
            'to_pdf': true
        }
    );
    $.ajaxSetup({"async": true});
    return(result.responseText);

}

/**
 * Ajax call to retrieve the html for a field.
 * Calls a controller action in /modules/Home/controller.
 * Returns the edit view field.
 * @param field
 * @param module
 * @param id
 * @param value
 * @returns {*}
 */

function loadFieldHTML(field,module,id) {
    $.ajaxSetup({"async": false});
    var result = $.getJSON('index.php',
        {
            'module': 'Home',
            'action': 'getEditFieldHTML',
            'field': field,
            'current_module': module,
            'id': id,
            'view' : view,
            'to_pdf': true
        }
    );
    $.ajaxSetup({"async": true});
     if(result.responseText){
         try {
             return (JSON.parse(result.responseText));
         } catch(e) {
             return false;
         }

     }else{
         return false;
     }


}

/**
 * Ajax call retrieve the field value from the bean used for closing the input.
 * Calls a controller action in /modules/Home/controller.
 * Returns the formatted output value of the field.
 * @param field
 * @param module
 * @param id
 * @returns {*}
 */

function loadFieldHTMLValue(field,id,module) {
    $.ajaxSetup({"async": false});
    var result = $.getJSON('index.php',
        {
            'module': 'Home',
            'action': 'getDisplayValue',
            'field': field,
            'current_module': module,
            'view': view,
            'id': id,
            'to_pdf': true
        }
    );
    $.ajaxSetup({"async": true});

    return(result.responseText);
}

/**
 * Ajax call to retrieve the field validation js this needs to be done separately as you can't json_encode javascript.
 * Calls a controller action in /modules/Home/controller.
 * Returns the add to validate call for the field..
 * @param field
 * @param module
 * @param id
 * @returns {*}
 */

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

    try {
        var validation = JSON.parse(result.responseText);
    } catch(e) {
        alert("There was an error loading the field. Your session may have timed out. Please log in again to fix this");
        return false;
    }

    return "<script type='text/javascript'>addToValidate('EditView', \"" + field + "\", \"" + validation['type'] + "\", " + validation['required'] + ",\"" + validation['label'] + "\");</script>";
}

/**
 * Ajax call to retrieve js needed for relate fields..
 * Calls a controller action in /modules/Home/controller.
 * Returns the javascript.
 * @param field
 * @param module
 * @param id
 * @returns {*}
 */

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
