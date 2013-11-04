/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/




/**
 * Helper function used in send_backs to close the popup window if closePopup is true.
 */
function closePopup() {
	var closePopup = window.opener.get_close_popup();
	if (closePopup)
	{
		window.close();
	}	
}

/**
 * Bug: 48726
 * Helper function used in send_backs to show confirm dialog with appropriate message. 
 * Collects label data from the the parent window.
 * 
 * If similar bugs appear, please refer to Bug 48726, and use these helper functions.
 */
function confirmDialog(arrayContents, formName) {
	var newData = '';
	var labels = '';
	var oldData = '';
	eval("var data = {" + arrayContents.join(",") + "}");
	var opener = window.opener.document;
	for (var key in data)
	{
		var displayValue = replaceHTMLChars(data[key]);
		if (opener.forms[formName] && opener.getElementById(key + '_label') != null && !key.match(/account/))
		{
	        var dataLabel = opener.getElementById(key + '_label').innerHTML.replace(/\n/gi,'').replace(/<\/?[^>]+(>|$)/g, "");
	        labels += dataLabel + ' \n';
			newData += dataLabel + ' ' + displayValue + '\n';
			if(window.opener.document.forms[formName].elements[key]) {
				oldData += dataLabel + ' ' + opener.forms[formName].elements[key].value + '\n';
			}
		}
	}

	var popupConfirm = 0;
	if (data['account_id'] && (newData.split("\n").length - 1) > 2)
	{
		if(newData != oldData && oldData != labels)
		{
			if(confirm(SUGAR.language.get('app_strings', 'NTC_OVERWRITE_ADDRESS_PHONE_CONFIRM') + '\n\n' + newData))
			{
				popupConfirm = 1;
			} else {
				popupConfirm = -1;	
			}
		}
	}
	
	return popupConfirm;
}

function send_back(module, id)
{
	var associated_row_data = associated_javascript_data[id];

	// cn: bug 12274 - stripping false-positive security envelope
	eval("var temp_request_data = " + window.document.forms['popup_query_form'].request_data.value);
	if(temp_request_data.jsonObject) {
		var request_data = temp_request_data.jsonObject;
	} else {
		var request_data = temp_request_data; // passed data that is NOT incorrectly encoded via JSON.encode();
	}
	// cn: end bug 12274 fix
	
	var passthru_data = Object();
	if(typeof(request_data.passthru_data) != 'undefined')
	{
		passthru_data = request_data.passthru_data;
	}
	var form_name = request_data.form_name;
	var field_to_name_array = request_data.field_to_name_array;
	
	var call_back_function = eval("window.opener." + request_data.call_back_function);
	var array_contents = Array();

	// constructs the array of values associated to the bean that the user clicked
    var fill_array_contents = function(the_key, the_name)
    {
        var the_value = '';
        if (module != '' && id != '') {
            if (associated_row_data['DOCUMENT_NAME'] && the_key.toUpperCase() == "NAME") {
                the_value = associated_row_data['DOCUMENT_NAME'];
            } else if ((the_key.toUpperCase() == 'USER_NAME' || the_key.toUpperCase() == 'LAST_NAME' || the_key.toUpperCase() == 'FIRST_NAME')
                        && typeof(is_show_fullname) != 'undefined' && is_show_fullname && form_name != 'search_form') {
                        //if it is from searchform, it will search by assigned_user_name like 'ABC%', then it will return nothing
                the_value = associated_row_data['FULL_NAME'];
            } else {
                the_value = associated_row_data[the_key.toUpperCase()];
            }
        }

        if (typeof(the_value) == 'string') {
            the_value = the_value.replace(/\r\n|\n|\r/g, '\\n');
        }

        array_contents.push('"' + the_name + '":"' + the_value + '"');
    }

	for(var the_key in field_to_name_array)
	{
		if(the_key != 'toJSON')
		{
            if (YAHOO.lang.isArray(field_to_name_array[the_key])) {
                for (var i = 0; i < field_to_name_array[the_key].length; i++) {
                    fill_array_contents(the_key, field_to_name_array[the_key][i]);
                }
            }
            else {
                fill_array_contents(the_key, field_to_name_array[the_key]);
            }
		}
	}

	var popupConfirm = confirmDialog(array_contents, form_name);
	
	eval("var name_to_value_array = {" + array_contents.join(",") + "}");
	
	closePopup();

	var result_data = {"form_name":form_name,"name_to_value_array":name_to_value_array,"passthru_data":passthru_data,"popupConfirm":popupConfirm};
	call_back_function(result_data);
}

function send_back_teams(module, form, field, error_message, request_data, form_team_id)
{	
	var array_contents = Array();
	
	if(form_team_id){
		array_contents.push(form_team_id);
	}else{
		var j=0;
		for (i = 0; i < form.elements.length; i++){
			if(form.elements[i].name == field) { 
				if (form.elements[i].checked == true) {
					array_contents.push(form.elements[i].value);
				}
			}
		}
	}
	
	if (array_contents.length ==0 ) {
		window.alert(error_message);	
		return;
	}
	
    var field_to_name_array = request_data.field_to_name_array;
    var array_teams = new Array();
    for(team_id in array_contents) {
    	if(typeof array_contents[team_id] == 'string') {
		    var team = {"team_id" : associated_javascript_data[array_contents[team_id]].ID, 
		                "team_name" : associated_javascript_data[array_contents[team_id]].NAME};
		    array_teams.push(team);
    	}
	}
	
	var passthru_data = Object();
	
	if(typeof request_data.call_back_function == 'undefined' && typeof request_data == 'object') {
		request_data = YAHOO.lang.JSON.parse(request_data.value);
	}	
	
	if(typeof(request_data.passthru_data) != 'undefined')
	{
		passthru_data = request_data.passthru_data;
	}
	
	var form_name = request_data.form_name;
	var field_name = request_data.field_name;

	closePopup();
	
	var call_back_function = eval("window.opener." + request_data.call_back_function);
	var result_data={"form_name":form_name,"field_name":field_name,"teams":array_teams,"passthru_data":passthru_data};
	call_back_function(result_data);

}

function send_back_selected(module, form, field, error_message, request_data)
{
	var array_contents = Array();
	var j=0;
	for (i = 0; i < form.elements.length; i++){
		if(form.elements[i].name == field) { 
			if (form.elements[i].checked == true) {
				++j;
				array_contents.push('"' + "ID_" + j  + '":"' + form.elements[i].value + '"');
			}
		}
	}
	
	if (array_contents.length ==0 ) {
		window.alert(error_message);	
		return;
	}
	
	eval("var selection_list_array = {" + array_contents.join(",") + "}");
	
	// cn: bug 12274 - stripping false-positive security envelope
	eval("var temp_request_data = " + window.document.forms['popup_query_form'].request_data.value);

	if(temp_request_data.jsonObject) {
		var request_data = temp_request_data.jsonObject;
	} else {
		var request_data = temp_request_data; // passed data that is NOT incorrectly encoded via JSON.encode();
	}

	// cn: end bug 12274 fix

	var passthru_data = Object();
	if(typeof(request_data.passthru_data) != 'undefined')
	{
		passthru_data = request_data.passthru_data;
	}
	var form_name = request_data.form_name;
	var field_to_name_array = request_data.field_to_name_array;
	
	closePopup();
	
	var call_back_function = eval("window.opener." + request_data.call_back_function);
	var result_data={"form_name":form_name,"selection_list":selection_list_array ,"passthru_data":passthru_data,"select_entire_list":form.select_entire_list.value,"current_query_by_page":form.current_query_by_page.value};
	call_back_function(result_data);
}



function toggleMore(spanId, img_id, module, action, params){
	toggle_more_go = function() {
				oReturn = function(body, caption, width, theme) {
					
					$(".ui-dialog").find(".open").dialog("close");

					var el = '#'+spanId+ ' img';
					if (action == 'DisplayInlineTeams')
					{
					    el = '#'+spanId;
					}
					var $dialog = $('<div class="open"></div>')
					.html(body)
					.dialog({
						autoOpen: false,
						title: caption,
						width: 300,
						position: {
						    my: 'right top',
						    at: 'left top',
						    of: $(el)
					  }
					});

					var width = $dialog.dialog( "option", "width" );
					var pos = $(el).offset();
					var ofWidth = $(el).width();

					if((pos.left + ofWidth) - 40 < width) {
					    $dialog.dialog("option","position",{my: 'left top',at: 'right top',of: $(el)})	;
					}

					$dialog.dialog('open');

				}
				
		success = function(data) {
					eval(data.responseText);

					SUGAR.util.additionalDetailsCache[spanId] = new Array();
					SUGAR.util.additionalDetailsCache[spanId]['body'] = result['body'];
					SUGAR.util.additionalDetailsCache[spanId]['caption'] = result['caption'];
					SUGAR.util.additionalDetailsCache[spanId]['width'] = result['width'];
					SUGAR.util.additionalDetailsCache[spanId]['theme'] = result['theme'];
					ajaxStatus.hideStatus();
					return oReturn(SUGAR.util.additionalDetailsCache[spanId]['body'], SUGAR.util.additionalDetailsCache[spanId]['caption'], SUGAR.util.additionalDetailsCache[spanId]['width'], SUGAR.util.additionalDetailsCache[spanId]['theme']);
				}

				if(typeof SUGAR.util.additionalDetailsCache[spanId] != 'undefined')
					return oReturn(SUGAR.util.additionalDetailsCache[spanId]['body'], SUGAR.util.additionalDetailsCache[spanId]['caption'], SUGAR.util.additionalDetailsCache[spanId]['width'], SUGAR.util.additionalDetailsCache[spanId]['theme']);

				if(typeof SUGAR.util.additionalDetailsCalls[spanId] != 'undefined') // call already in progress
					return;
				ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'));
				url = 'index.php?module='+module+'&action='+action+'&'+params;
				SUGAR.util.additionalDetailsCalls[spanId] = YAHOO.util.Connect.asyncRequest('GET', url, {success: success, failure: success});

				return false;
	}
	SUGAR.util.additionalDetailsRpcCall = window.setTimeout('toggle_more_go()', 250);
}

// The following line of code was copy / pasted in a whole bunch of modules.
SUGAR.util.doWhen("window.document.forms['popup_query_form'] != null "
        + "&& typeof(window.document.forms['popup_query_form'].request_data) != 'undefined'",
    function() {
        /* initialize the popup request from the parent */
        if(window.document.forms['popup_query_form'].request_data.value == "")
        {
            window.document.forms['popup_query_form'].request_data.value = window.opener.get_popup_request_data();
        }
    }
);
$(document).ready(function(){
    $("ul.clickMenu").each(function(index, node){
        $(node).sugarActionMenu();
    });
});