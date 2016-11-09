/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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




function generatepwd(id)
{
    callback = {
        success: function(o)
        {
            checkok=o.responseText;
            if (checkok.charAt(0) != '1')
                YAHOO.SUGAR.MessageBox.show({title: SUGAR.language.get("Users", "LBL_CANNOT_SEND_PASSWORD"), msg: checkok});
            else
                YAHOO.SUGAR.MessageBox.show({title: SUGAR.language.get("Users", "LBL_PASSWORD_SENT"), msg: SUGAR.language.get("Users", "LBL_NEW_USER_PASSWORD_2")} );
        },
        failure: function(o)
        {
            YAHOO.SUGAR.MessageBox.show({title: SUGAR.language.get("Users", "LBL_CANNOT_SEND_PASSWORD"), msg: SUGAR.language.get("app_strings", "LBL_AJAX_FAILURE")});
        }
    }
	PostData = '&to_pdf=1&module=Users&action=GeneratePassword&userId='+id;
	YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback, PostData);	
}

function set_return_user_and_save(popup_reply_data)
{
	var form_name = popup_reply_data.form_name;
	var name_to_value_array;
	if(popup_reply_data.selection_list)
	{
		name_to_value_array = popup_reply_data.selection_list;
	}else if(popup_reply_data.teams){
		name_to_value_array = new Array();
		for (var the_key in popup_reply_data.teams){
			name_to_value_array.push(popup_reply_data.teams[the_key].team_id);
		}
	}else
	{
		name_to_value_array = popup_reply_data.name_to_value_array;
	}
	
	var query_array =  new Array();
	for (var the_key in name_to_value_array)
	{
		if(the_key == 'toJSON')
		{
			/* just ignore */
		}
		else
		{
			query_array.push("record[]="+name_to_value_array[the_key]);
		}
	}
	query_array.push('user_id='+get_user_id(form_name));
	query_array.push('action=AddUserToTeam');
	query_array.push('module=Teams');
	var query_string = query_array.join('&');
	
	var returnstuff = http_fetch_sync('index.php',query_string);
	
	document.location.reload(true);
}

function get_user_id(form_name)
{
	return window.document.forms[form_name].elements['user_id'].value;
}

function user_status_display(field){
	switch (field){
	
		case 'RegularUser':
		    document.getElementById("calendar_options").style.display="";
			document.getElementById("edit_tabs").style.display="";
		    document.getElementById("locale").style.display="";
			document.getElementById("settings").style.display="";
			document.getElementById("information").style.display="";
			break;
			
		case 'GroupUser':
		    document.getElementById("calendar_options").style.display="none";
			document.getElementById("edit_tabs").style.display="none";
		    document.getElementById("locale").style.display="none";
			document.getElementById("settings").style.display="none";
			document.getElementById("information").style.display="none";
            document.getElementById("email_options_link_type").style.display="none";
	    break;

		case 'PortalUser':
		    document.getElementById("calendar_options").style.display="none";
			document.getElementById("edit_tabs").style.display="none";
		    document.getElementById("locale").style.display="none";
			document.getElementById("settings").style.display="none";
			document.getElementById("information").style.display="none";
            document.getElementById("email_options_link_type").style.display="none";
	    break;
	}
}

function confirmDelete() {
    var handleYes = function() {
        SUGAR.util.hrefURL("?module=Users&action=delete&record="+document.forms.DetailView.record.value);
    };

    var handleNo = function() {
        confirmDeletePopup.hide();
        return false;
     };
    var user_portal_group = '{$usertype}';
    var confirm_text = SUGAR.language.get('Users', 'LBL_DELETE_USER_CONFIRM');
    if(user_portal_group == 'GroupUser'){
        confirm_text = SUGAR.language.get('Users', 'LBL_DELETE_GROUP_CONFIRM');
    }

    var confirmDeletePopup = new YAHOO.widget.SimpleDialog("Confirm ", {
                width: "400px",
                draggable: true,
                constraintoviewport: true,
                modal: true,
                fixedcenter: true,
                text: confirm_text,
                bodyStyle: "padding:5px",
                buttons: [{
                        text: SUGAR.language.get('Users', 'LBL_OK'),
                        handler: handleYes,
                        isDefault:true
                }, {
                        text: SUGAR.language.get('Users', 'LBL_CANCEL'),
                        handler: handleNo
                }]
     });
    confirmDeletePopup.setHeader(SUGAR.language.get('Users', 'LBL_DELETE_USER'));
    confirmDeletePopup.render(document.body);
}
