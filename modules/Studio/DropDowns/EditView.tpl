
{*

/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */




*}


{literal}
<br>
<style type='text/css'>
.slot {
	border-width:1px;border-color:#999999;border-style:solid;padding:0px 1px 0px 1px;margin:2px;cursor:move;

}

.slotB {
	border-width:0;cursor:move;

}
</style>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
<h2 style='margin-bottom:10px;'>{$title}</h2>
<p>{$MOD.LBL_RENAME_TAB_WELCOME}</p><br/>
<table cellspacing="2">
<tr>
<td valign="center">
    <input type="button" value="{$MOD.LBL_BTN_UNDO}" onclick="jstransaction.undo()" name="{$MOD.LBL_BTN_UNDO}" />
</td>
<td valign="center">
    <input type="button" value="{$MOD.LBL_BTN_REDO}" onclick="jstransaction.redo()" name="{$MOD.LBL_BTN_REDO}" />
</td>
<td valign="center">
    <input type="button" value="{$MOD.LBL_BTN_SAVE}"
        onclick='{literal}if(check_form("editdropdown")){document.editdropdown.submit();}{/literal}'
        name="{$MOD.LBL_BTN_SAVE}" />
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class='edit view'>
<tr><td>
<span class='error'>{$error}</span>
<table >
<tr><td colspan='2'>
{if empty($newDropDown)}
<form method='post' action='index.php' name='dropdownsform'>
<input type='hidden' name='action' value='wizard'>
<input type='hidden' name='wizard' value='EditDropDownWizard'>
<input type='hidden' name='option' value='EditDropdown'>
<input type='hidden' name='module' value='Studio'>
<input type='hidden' name='dropdown_name' value='{$dropdown_name}'>

{html_options name='dropdown_lang' options=$dropdown_languages selected=$dropdown_lang onchange="document.dropdownsform.submit();"}
</form>
{/if}
</td></tr>
</table>
</td></tr><tr><td>
{if !empty($dropdown) || !empty($newDropDown)}
<form method='post' action='index.php' name='editdropdown'>
<input type='hidden' name='action' value='wizard'>
<input type='hidden' name='wizard' value='EditDropDownWizard'>
<input type='hidden' name='option' value='SaveDropDown'>
<input type='hidden' name='module' value='Studio'>
<input type='hidden' name='dropdown_lang' value='{$dropdown_lang}'>
{if empty($newDropDown)}
<input type='hidden' name='dropdown_name' value='moduleList'>
{else}
<table><tr><td>
{$MOD.LBL_DROPDOWN_NAME}
</td><td>{$MOD.COLUMN_TITLE_NAME}<input type='text' name='dropdown_name' value='{$dropdown_name}'>
</td></tr><tr><td>
{$MOD.LBL_DROPDOWN_LANGUAGE}</td><td>{html_options name='dropdown_lang' options=$dropdown_languages selected=$dropdown_lang}
</td></tr></table>
{/if}
<table name='tabDropdown' id='tabDropdown'>
<tr><td>{$MOD.LBL_DD_DATABASEVALUE}<hr></td><td>{$MOD.LBL_DD_DISPALYVALUE}<hr></td></tr>
{counter start=0 name="rowCounter" print=false assign="rowCounter"}
{foreach from=$dropdown item="value" key="key"}

<tr><td>
<span id='slot{$rowCounter}' class='slot' style='cursor: move'>
    <span id='slot{$rowCounter}_key'>{$key}</span>
</span>
</td><td>
<span id='slot{$rowCounter}b' >
{if empty($disable_remove)}
    <span onclick='deleteDropDownValue({$rowCounter}, document.getElementById("delete_{$rowCounter}"), true);'>
        {$deleteImage}
    </span>
{/if}
    <span onclick='prepChangeDropDownValue({$rowCounter}, document.getElementById("slot{$rowCounter}_value"));'>{$editImage}</span>
        &nbsp;
    <span id ='slot{$rowCounter}_value' onclick='prepChangeDropDownValue({$rowCounter}, this);'>{$value.lang}</span>
    <span id='slot{$rowCounter}_textspan' style='display:none'>
        <input id='slot{$rowCounter}_text' value='' type='text'  onchange='setDropDownValue({$rowCounter}, this.value, true)' >
        {$value.user_lang}
    </span>
    <input name='slot_{$rowCounter}' id='slot_{$rowCounter}' value='{$rowCounter}' type = 'hidden'>
    <input name='value_{$rowCounter}' id='value_{$rowCounter}' value='{$value.lang}' type = 'hidden'>
    <input type='hidden' name='key_{$rowCounter}' id='key_{$rowCounter}' value='{$key|default:"BLANK"}'>
    <input type='hidden' id='delete_{$rowCounter}' name='delete_{$rowCounter}' value='0'>
 </span>

    </td></tr>
{counter name="rowCounter"}
{/foreach}

{if empty($disable_add)}
<tr><td><input type='text' name='addKey' id='addKey' value=''></td><td><input type='text' name='addValue' id='addValue' value=''><input type='button' onclick='addDropDown();' value='+' class='button'></td>
{/if}
</table>
</table>

<script type="text/javascript" src="{sugar_getjspath file='modules/Studio/JSTransaction.js'}" ></script>
			<script>
			var jstransaction = new JSTransaction();
			</script>

{literal}
            <script src = "include/javascript/yui/build/dragdrop/dragdrop.js" ></script>
			<script type="text/javascript" src="modules/Studio/studiodd.js" ></script>	
			<script type="text/javascript" src="modules/Studio/studio.js" ></script>
			<script>
			var lastField = '';
			var lastRowCount = -1;
			var undoDeleteDropDown = function(transaction){
			    deleteDropDownValue(transaction['row'], document.getElementById(transaction['id']), false);
			}
			jstransaction.register('deleteDropDown', undoDeleteDropDown, undoDeleteDropDown);
			function deleteDropDownValue(rowCount, field, record){
			    if(record){
			        jstransaction.record('deleteDropDown',{'row':rowCount, 'id': field.id });
			    }
			    //We are deleting if the value is 0
			    if(field.value == '0'){
			        field.value = '1';
			        document.getElementById('slot' + rowCount + '_key').style.textDecoration = 'line-through';
			        document.getElementById('slot' + rowCount + '_value').style.textDecoration = 'line-through';
			    }else{
			        field.value = '0';
			        document.getElementById('slot' + rowCount + '_key').style.textDecoration = 'none';
			        document.getElementById('slot' + rowCount + '_value').style.textDecoration = 'none';
			    }


			}
			function prepChangeDropDownValue(rowCount, field){

			    var tempLastField = lastField;
			     if(lastRowCount != -1){
			        setDropDownValue(lastRowCount, lastField.innerHTML, true);
			    }
			     if(tempLastField == field)return;
			    lastField = field;
			    lastRowCount = rowCount;

			    field.style.display="none";

			    var textspan =  document.getElementById('slot' + rowCount + '_textspan');
			    var text = document.getElementById("slot" + rowCount + "_text");
			    text.value=field.innerHTML;
			    textspan.style.display='inline'
			    text.focus();
			}
			var undoDropDownChange = function(transaction){
			    setDropDownValue(transaction['row'], transaction['old'], false);
			}
			var redoDropDownChange = function(transaction){
			    setDropDownValue(transaction['row'], transaction['new'], false);
			}
			jstransaction.register('changeDropDownValue', undoDropDownChange, redoDropDownChange);
			function setDropDownValue(rowCount, val, record){

			    var key = document.getElementById('slot' + rowCount + '_key').innerHTML;
			    if(key == ''){
			        key = 'BLANK';
			    }
			    if(record){
			        jstransaction.record('changeDropDownValue', {'row':rowCount, 'new':val, 'old':document.getElementById('value_'+ rowCount).value});
			    }
			    document.getElementById('value_' + rowCount).value = YAHOO.lang.escapeHTML(val);
			    var text =  document.getElementById('slot' + rowCount + '_text');
			    var textspan =  document.getElementById('slot' + rowCount + '_textspan');
			    var span = document.getElementById('slot' + rowCount + '_value');
			    span.innerHTML  = YAHOO.lang.escapeHTML(val);
			    textspan.style.display = 'none';
			    text.value = '';
			    span.style.display = 'inline';
			    lastField = '';
			    lastRowCount = -1;

			}

			function addDropDown(){
		      var addKey =  document.getElementById('addKey');
		      var keyValue = addKey.value;
		      if(trim(keyValue) == ''){
		          keyValue = 'BLANK';
		      }

		      //Check for the single quote value
		      //Comment out this if block in case you don't want validation
		      //or add other rules as needed (e.g. isDBName() from sugar_3.js)
		      if(/[\']/.test(keyValue)) {
		         alert("{/literal}{$MOD.ERROR_INVALID_KEY_VALUE}{literal}");
		         return false;
		      }

		      var addValue =  document.getElementById('addValue')
		      for(var i = 0; i < slotCount ; i++){
		          if(typeof(document.getElementById('key_' + i)) != 'undefined'){
		              if(document.getElementById('key_' + i).value == keyValue){
		                  alert('key already exists');
		                  return;
		              }
		          }
		      }
		      var table = document.getElementById('tabDropdown');
		      var row = table.insertRow(table.rows.length - 1);
			  var cell = row.insertCell(0);
			  var cell2 = row.insertCell(1);

			  var span1 = document.createElement('span');
			  span1.id = 'slot' + slotCount;
			  span1.className = 'slot';
			  var keyspan = document.createElement('span');
			  keyspan.id = 'slot' + slotCount + '_key'
			  keyspan.innerHTML  = YAHOO.lang.escapeHTML(addKey.value);
			  span1.appendChild(keyspan);
			  var span2 = document.createElement('span');
			  span2.id = 'slot' + slotCount + 'b';
			  var delimage = document.createElement('span');
			  delimage.innerHTML = '{/literal}{$deleteImage}{literal}&nbsp;';
			  delimage.slotCount = slotCount
			  delimage.recordKey = keyValue;
			  delimage.onclick = function(){

			      deleteDropDownValue(this.slotCount, document.getElementById( 'delete_' + this.slotCount), true);
			  };
			  var span2image = document.createElement('span');
			  span2image.innerHTML = '{/literal}{$editImage}{literal}&nbsp;';
			  span2image.slotCount = slotCount
			  span2image.onclick = function(){
			      prepChangeDropDownValue(this.slotCount, document.getElementById('slot' + this.slotCount + '_value'));
			  };
			  var span2inner = document.createElement('span');
			  span2inner.innerHTML = addValue.value;
			  span2inner.id = 'slot' + slotCount + '_value';
			  span2inner.slotCount = slotCount
			  span2inner.onclick = function(){
			      prepChangeDropDownValue(this.slotCount, this);
			  };
			  var text2span = document.createElement('span');
			  text2span.id = 'slot' + slotCount + '_textspan'
			  text2span.style.display = 'none';

			  var text2 = document.createElement('input');
			  text2.type = 'text';
			  text2.id = 'slot' + slotCount + '_text'

			  text2.slotCount = slotCount;
			  text2.onchange = function(){
			      setDropDownValue(this.slotCount, this.value, true);
			  }

			  var text3 = document.createElement('input');
			  text3.type = 'hidden';
			  text3.id = 'value_' + slotCount;
			  text3.name = 'value_' + slotCount;
			  text3.value = addValue.value;

			  var text4 = document.createElement('input');
			  text4.type = 'hidden';
			  text4.id = 'key_' + slotCount;
			  text4.name = 'key_' + slotCount;
			  text4.value = keyValue;

              var text5 = document.createElement('input');
			  text5.type = 'hidden';
			  text5.id = 'delete_' + slotCount  ;
			  text5.name = 'delete_' + slotCount  ;
			  text5.value = '0';

			  var text6 = document.createElement('input');
			  text6.type = 'hidden';
			  text6.id = 'slot_' + slotCount;
			  text6.name = 'slot_' + slotCount;
			  text6.value = slotCount;

			  cell.appendChild(span1);
			  span2.appendChild(delimage);
			  span2.appendChild(span2image);
			  span2.appendChild(span2inner);
			  cell2.appendChild(span2);
			  text2span.appendChild(text2);
			  span2.appendChild(text2span);
			  cell2.appendChild(text3);
			  cell2.appendChild(text4);
			  cell2.appendChild(text5);
			  cell2.appendChild(text6);
			  addKey.value = '';
			  addValue.value = '';
			  yahooSlots["slot" + slotCount] = new ygDDSlot("slot" + slotCount, "studio");
			  slotCount++;
			}
			var slotCount = {/literal}{$rowCounter}{literal};
			var yahooSlots = [];

			function dragDropInit(){
				YAHOO.util.DDM.mode = YAHOO.util.DDM.POINT;

				for(mj = 0; mj <= slotCount; mj++){
					yahooSlots["slot" + mj] = new ygDDSlot("slot" + mj, "studio");
				}
					  // initPointMode();
			}
			YAHOO.util.Event.addListener(window, "load", dragDropInit);


</script>
{/literal}


<div id='logDiv' style='display:none'>
</div>

{/if}
<input type='hidden' name='use_push' value='{$use_push}'>
</form>
</td></tr>
</table>

{if !empty($newDropDown)}
{literal}
<script type="text/javascript">
addToValidate('editdropdown', 'dropdown_name', 'DBName', true, '{/literal}{$MOD.LBL_DROPDOWN_NAME}{literal} [a-zA-Z_0-9]' );
</script>
{/literal}
{/if}