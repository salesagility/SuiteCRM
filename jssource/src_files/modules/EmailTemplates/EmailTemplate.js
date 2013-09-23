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

var focus_obj = false;
var label = SUGAR.language.get('app_strings', 'LBL_DEFAULT_LINK_TEXT');

function remember_place(obj) {
  focus_obj = obj;
}

function showVariable() {
	document.EditView.variable_text.value = 
		document.EditView.variable_name.options[document.EditView.variable_name.selectedIndex].value; 
}

function addVariables(the_select,the_module) {
	the_select.options.length = 0;
	for(var i=0;i<field_defs[the_module].length;i++) {
		var new_option = document.createElement("option");
		new_option.value = "$"+field_defs[the_module][i].name;
		new_option.text= field_defs[the_module][i].value;
		the_select.options.add(new_option,i);
	}
	showVariable();
}
function toggle_text_only(firstRun) {
	if (typeof(firstRun) == 'undefined')
		firstRun = false;
	var text_only = document.getElementById('text_only');
    //Initialization of TinyMCE
    if(firstRun){
        setTimeout("tinyMCE.execCommand('mceAddControl', false, 'body_text');", 500);
        var tiny = tinyMCE.getInstanceById('body_text');
    }
	//check to see if the toggle textonly flag is checked
    if(document.getElementById('toggle_textonly').checked == true) {
        //hide the html div (containing TinyMCE)
        document.getElementById('body_text_div').style.display = 'none';
        document.getElementById('toggle_textarea_option').style.display = 'none';
        document.getElementById('text_div').style.display = 'block';
        text_only.value = 1; 
    } else {
        //display the html div (containing TinyMCE)
        document.getElementById('body_text_div').style.display = 'inline';
        document.getElementById('toggle_textarea_option').style.display = 'inline';
        document.getElementById('text_div').style.display = 'none';
        
        text_only.value = 0;                     
    }
    update_textarea_button();
}

function update_textarea_button()
{
	if(document.getElementById('text_div').style.display == 'none') {
		document.getElementById('toggle_textarea_elem').value = toggle_textarea_elem_values[0];
	} else {
		document.getElementById('toggle_textarea_elem').value = toggle_textarea_elem_values[1];
	}
}

function toggle_textarea_edit(obj)
{
	if(document.getElementById('text_div').style.display == 'none')
	{
        document.getElementById('text_div').style.display = 'block';
	} else {
        document.getElementById('text_div').style.display = 'none';
	}
	update_textarea_button();
}



//This function checks that tinyMCE is initilized before setting the text (IE bug)
function setTinyHTML(text) {
    var tiny = tinyMCE.getInstanceById('body_text');
                
    if (tiny.getContent() != null) {
        tiny.setContent(text)
    } else {
        setTimeout(setTinyHTML(text), 1000);
    }
}

function stripTags(str) {
	var theText = new String(str);

	if(theText != 'undefined') {
		return theText.replace(/<\/?[^>]+>/gi, '');
	}
}
/*
 * this function will insert variables into text area 
*/
function insert_variable_text(myField, myValue) {
	//IE support
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = myValue;
	}
	//MOZILLA/NETSCAPE support
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		myField.value = myField.value.substring(0, startPos)
		+ myValue
		+ myField.value.substring(endPos, myField.value.length);
	} else {
		myField.value += myValue;
	}
}

/*
 * This function inserts variables into a TinyMCE instance
 */
function insert_variable_html(text) {
	var inst = tinyMCE.getInstanceById("body_text");
	if (inst)
                    inst.getWin().focus();
	//var html = inst.getContent(true);
	//inst.setContent(html + text);
	inst.execCommand('mceInsertRawHTML', false, text);
}

function insert_variable_html_link(text) {

	the_label = document.getElementById('url_text').value;
	if(typeof(the_label) =='undefined'){
		the_label = label;	
	}

	//remove surounding parenthesis around the label
	if(the_label[0] == '{' && the_label[the_label.length-1] == '}'){
		the_label = the_label.substring(1,the_label.length-1);
	}
	
	var thelink = "<a href='" + text + "' > "+the_label+" </a>";
	insert_variable_html(thelink);
}	
/*
 * this function will check to see if text only flag has been checked.
 * If so, the it will call the text insert function, if not, then it
 * will call the html (tinyMCE eidtor) insert function
*/
function insert_variable(text) {
	//if text only flag is checked, then insert into text field
	if(document.getElementById('toggle_textonly').checked == true){
		//use text version insert 
		insert_variable_text(document.getElementById('body_text_plain'), text) ;
	}else{
		//use html version insert 
		insert_variable_html(text) ;
	}
}			

