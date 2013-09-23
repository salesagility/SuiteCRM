{*
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




*}

<br />
<script type="text/javascript" src="{sugar_getjspath file='modules/Studio/JSTransaction.js'}" ></script>
<script>
	var jstransaction = new JSTransaction();
</script>
<script type="text/javascript" src="{sugar_getjspath file='modules/Studio/studiotabgroups.js'}"></script>
<script type="text/javascript" src="{sugar_getjspath file='modules/Studio/ygDDListStudio.js'}"></script>
<script type="text/javascript" src="{sugar_getjspath file='modules/Studio/studiodd.js'}" ></script>
<script type="text/javascript" src="{sugar_getjspath file='modules/Studio/studio.js'}" ></script>
{literal}
<style type='text/css'>
.slot {
	border-width:1px;border-color:#999999;border-style:solid;padding:0px 1px 0px 1px;margin:2px;cursor:move;

}


.slotSub {
	border-width:1px;border-color:#006600;border-style:solid;padding:0px 1px 0px 1px;margin:2px;cursor:move;

}
.slotB {
	border-width:0;cursor:move;

}
.listContainer
{
	margin-left: 4;
	padding-left: 4;
	margin-right: 4;
	padding-right: 4;
	list-style-type: none;
}

 ul.listContainer
{
	margin-left: 10px;
	margin-right: 10px;
	padding-left: 0;
}

div.noBullet li, .nobullet
{
    list-style-type: none;
}

ul#trash
{
    padding: 0px;
    margin: 0px;
}

.tdContainer{
	border: thin solid gray;
	padding: 10;
}

</style>
{/literal}
<h2 >{$title}</h2>
<p>{$MOD.LBL_GROUP_TAB_WELCOME}</p>
<br/>
<table cellspacing=2>
<button style='cursor:default' onmousedown='this.className="buttonOn";return false;'
            onmouseup='this.className="button"' onmouseout='this.className="button"'
            onclick='studiotabs.generateForm("edittabs");document.edittabs.submit()'>
            {$MOD.LBL_BTN_SAVEPUBLISH}</button>
</table>
<p />
<form name='edittabs' id='edittabs' method='POST' action='index.php'>
<input type="hidden" name="slot_count" id="slot_count" value="" />
<table  cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td width="100%" class='dataLabel' colspan=2>
	{$MOD.LBL_TABGROUP_LANGUAGE}&nbsp;
	{html_options name='grouptab_lang' options=$available_languages selected=$tabGroupSelected_lang onchange=" tabLanguageChange(this)"}
	{sugar_help text=$MOD.LBL_TAB_GROUP_LANGUAGE_HELP}
	</td>
</tr>
</table>
<table><tr><td valign='top' nowrap class="edit view" style="width: auto;">
<table  cellpadding="0" cellspacing="0" width="100%"   id='s_field_delete'>
							<tr><td ><ul id='trash' class='listContainer'>
<li class='nobullet' id='trashcan'><table>
  <tr>
	<td>{$recycleImage}</td>
	<td><br />{$MOD.LBL_DELETE_MODULE}</td>
  </tr>
  </table></li>

</ul>
						</td></tr></table>


<div class='noBullet' style="padding-left: 20px;"><h2>{$MOD.LBL_MODULES}</h2>
<ul class='listContainer'>
{counter start=0 name="modCounter" print=false assign="modCounter"}
{foreach from=$availableModuleList key='key' item='value'}


<li  id='modSlot{$modCounter}'><span class='slotB'>{$value.label}</span></li>
<script>
tabLabelToValue['{$value.label}'] = '{$value.value}';
subtabModules['modSlot{$modCounter}'] = '{$value.label}'</script>
{counter name="modCounter"}
{/foreach}
</ul>
</td>
<td valign='top' nowrap>
<table class='tableContainer' id='groupTable'><tr>
{counter start=0 name="tabCounter" print=false assign="tabCounter"}

{foreach from=$tabs item='tab' key='tabName'}
{if $tabCounter > 0 && $tabCounter % 6 == 0}
</tr><tr>
{/if}
<td valign='top' class='tdContainer'>
<div id='slot{$tabCounter}' class='noBullet'><h2 id='handle{$tabCounter}' ><span id='tabname_{$tabCounter}' class='slotB'>{$tab.labelValue}</span><br><span id='tabother_{$tabCounter}'><span onclick='studiotabs.editTabGroupLabel({$tabCounter}, false)'>{$editImage}</span>&nbsp;
{if $tab.label != $otherLabel }
	<span onclick='studiotabs.deleteTabGroup({$tabCounter})'>{$deleteImage}</span>
{/if}
</span></h2><input type='hidden' name='tablabelid_{$tabCounter}' id='tablabelid_{$tabCounter}'  value='{$tab.label}'><input type='text' name='tablabel_{$tabCounter}' id='tablabel_{$tabCounter}' style='display:none' value='{$tab.labelValue}' onblur='studiotabs.editTabGroupLabel({$tabCounter}, true)'>
<ul id='ul{$tabCounter}' class='listContainer'>
{counter start=0 name="subtabCounter" print=false assign="subtabCounter"}
{foreach from=$tab.modules key='list' item='name'}

<li id='subslot{$tabCounter}_{$subtabCounter}' class='listStyle' name='{$list}'><span class='slotB' >{$availableModuleList[$list].label}</span></li>
<script>subtabModules['subslot{$tabCounter}_{$subtabCounter}'] = '{$availableModuleList[$list].label}'</script>
{counter name="subtabCounter"}
{/foreach}
<li class='noBullet' id='noselectbottom{$tabCounter}'>&nbsp;</li>
<script>subtabCount[{$tabCounter}] = {$subtabCounter};</script>
</ul>
</div>
<div id='slot{$tabCounter}b'>
<input type='hidden' name='slot_{$tabCounter}' id='slot_{$tabCounter}' value ='{$tabCounter}'>
<input type='hidden' name='delete_{$tabCounter}' id='delete_{$tabCounter}' value ='0'>
</div>
{counter name="tabCounter"}
</td>
{/foreach}

</tr>
<tr><td><input type='button' class='button' onclick='addTabGroup()' value='{$MOD.LBL_ADD_GROUP}'></td></tr>
</table>

</td>
</table>



<span class='error'>{$error}</span>



{literal}


		<script>
		function tabLanguageChange(sel){
			var partURL = window.location.href;
			if(partURL.search(/&lang=\w*&/i) != -1){
				partURL = partURL.replace(/&lang=\w*&/i, '&lang='+ sel.value+'&');
			}else if(partURL.search(/&lang=\w*/i) != -1){
				partURL = partURL.replace(/&lang=\w*/i, '&lang='+ sel.value);
			}else{
				partURL = window.location.href + '&lang='+ sel.value;
			}
			window.location.href = partURL;
		}

		function addTabGroup(){
			var table = document.getElementById('groupTable');
		  	var rowIndex = table.rows.length - 1;
		  	var rowExists = false;
		  	for(var i = 0; i < rowIndex;i++){
		  		if(table.rows[i].cells.length < 6){
		  			rowIndex = i;
		  			rowExists = true;
		  		}
		  	}

		  	if(!rowExists)table.insertRow(rowIndex);
		  	cell = table.rows[rowIndex].insertCell(table.rows[rowIndex].cells.length);
		  	cell.className='tdContainer';
		  	cell.vAlign='top';
		  	var slotDiv = document.createElement('div');
		  	slotDiv.id = 'slot'+ slotCount;
		  	var header = document.createElement('h2');
		  	header.id = 'handle' + slotCount;
		  	headerSpan = document.createElement('span');
		  	headerSpan.innerHTML = '{/literal}{$TGMOD.LBL_NEW_GROUP}{literal}';
		  	headerSpan.id = 'tabname_' + slotCount;
		  	header.appendChild(headerSpan);
		  	header.appendChild(document.createElement('br'));
		  	headerSpan2 = document.createElement('span');
		  	headerSpan2.id = 'tabother_' + slotCount;
		  	subspan1 = document.createElement('span');
		  	subspan1.slotCount=slotCount;
		  	subspan1.innerHTML = '{/literal}{$editImage}{literal}&nbsp;';
		  	subspan1.onclick= function(){
		  		studiotabs.editTabGroupLabel(this.slotCount, false);
		  	};
		  	subspan2 = document.createElement('span');
		  	subspan2.slotCount=slotCount;
		  	subspan2.innerHTML = '{/literal}{$deleteImage}{literal}&nbsp;';
		  	subspan2.onclick= function(){
		  		studiotabs.deleteTabGroup(this.slotCount);
		  	};
		  	headerSpan2.appendChild(subspan1);
		  	headerSpan2.appendChild(subspan2);

		  	var editLabel = document.createElement('input');
		  	editLabel.style.display = 'none';
		  	editLabel.type = 'text';
		  	editLabel.value = '{/literal}{$TGMOD.LBL_NEW_GROUP}{literal}';
		  	editLabel.id = 'tablabel_' + slotCount;
		  	editLabel.name = 'tablabel_' + slotCount;
		  	editLabel.slotCount = slotCount;
		  	editLabel.onblur = function(){
		  		studiotabs.editTabGroupLabel(this.slotCount, true);
		  	}

		  	var list = document.createElement('ul');
		  	list.id = 'ul' + slotCount;
		  	list.className = 'listContainer';
		  	header.appendChild(headerSpan2);
		  	var li = document.createElement('li');
		  	li.id = 'noselectbottom' + slotCount;
		  	li.className = 'noBullet';
		  	li.innerHTML = '{/literal}{$TGMOD.LBL_DROP_HERE}{literal}';
		  	list.appendChild(li);

		  	slotDiv.appendChild(header);
		  	slotDiv.appendChild(editLabel);
		  	slotDiv.appendChild(list);
			var slotB = document.createElement('div');
		  	slotB.id = 'slot' + slotCount + 'b';
		  	var slot = document.createElement('input');
		  	slot.type = 'hidden';
		  	slot.id =  'slot_' + slotCount;
		  	slot.name =  'slot_' + slotCount;
		  	slot.value = slotCount;
		  	var deleteSlot = document.createElement('input');
		  	deleteSlot.type = 'hidden';
		  	deleteSlot.id =  'delete_' + slotCount;
		  	deleteSlot.name =  'delete_' + slotCount;
		  	deleteSlot.value = 0;
		  	slotB.appendChild(slot);
		  	slotB.appendChild(deleteSlot);
		  	cell.appendChild(slotDiv);
		  	cell.appendChild(slotB);

		  	yahooSlots["slot" + slotCount] = new ygDDSlot("slot" + slotCount, "mainTabs");
			yahooSlots["slot" + slotCount].setHandleElId("handle" + slotCount);
		  	yahooSlots["noselectbottom"+ slotCount] = new ygDDListStudio("noselectbottom"+ slotCount , "subTabs", -1);
		  	subtabCount[slotCount] = 0;
		  	slotCount++;
		  	ygDDListStudio.prototype.updateTabs();
		}

		var slotCount = {/literal}{$tabCounter}{literal};
		var modCount = {/literal}{$modCounter}{literal};
		var subSlots = [];
		var yahooSlots = [];

		function dragDropInit(){

			YAHOO.util.DDM.mode = YAHOO.util.DDM.POINT;

			for(mj = 0; mj <= slotCount; mj++){
				yahooSlots["slot" + mj] = new ygDDSlot("slot" + mj, "mainTabs");
				yahooSlots["slot" + mj].setHandleElId("handle" + mj);

				yahooSlots["noselectbottom"+ mj] = new ygDDListStudio("noselectbottom"+ mj , "subTabs", -1);
				for(msi = 0; msi <= subtabCount[mj]; msi++){
					yahooSlots["subslot"+ mj + '_' + msi] = new ygDDListStudio("subslot"+ mj + '_' + msi, "subTabs", 0);

				}

			}
			for(msi = 0; msi <= modCount ; msi++){
					yahooSlots["modSlot"+ msi] = new ygDDListStudio("modSlot" + msi, "subTabs", 1);

			}
			var trash1  = new ygDDListStudio("trashcan" , "subTabs", 'trash');
			ygDDListStudio.prototype.updateTabs();

		}

		YAHOO.util.DDM.mode = YAHOO.util.DDM.INTERSECT;
		YAHOO.util.Event.addListener(window, "load", dragDropInit);

</script>
{/literal}
	<input type='hidden' name='action' value='SaveTabs'>
	<input type='hidden' name='module' value='Studio'>
</form>


