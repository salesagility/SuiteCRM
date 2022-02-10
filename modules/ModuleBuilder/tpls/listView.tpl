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
<form name='edittabs' id='edittabs' method='POST' action='index.php'>
{literal}
<script>
studiotabs.reset();
</script>
{/literal}
<input type='hidden' name='action' value={$action}>
<input type='hidden' name='view' value={$view}>
<input type='hidden' name='module' value='{$module}'>
<input type='hidden' name='subpanel' value='{$subpanel}'>
<input type='hidden' name='subpanelLabel' value='{$subpanelLabel}'>
<input type='hidden' name='local' value='{$local}'>
<input type='hidden' name='view_module' value='{$view_module}'>
{if $fromPortal}
    <input type='hidden' name='PORTAL' value='1'>
{/if}
<input type='hidden' name='view_package' value='{$view_package}'>
<input type='hidden' name='to_pdf' value='1'>
<link rel="stylesheet" type="text/css" href="modules/ModuleBuilder/tpls/ListEditor.css"/>

<table id="editor-content" class="list-editor">
<tr><td colspan=3>{$buttons}</td></tr>
{if isset($subpanel) && isset($subpanel_label)}
<tr>
    <td colspan=3>
    <span class='mbLBL'>{sugar_translate label='LBL_SUBPANEL_TITLE'}</span>
    <input id ="subpanel_title" type="text" name="subpanel_title" value="{$subpanel_title}">
    <input id ="subpanel_title_key" type="hidden" name="subpanel_title_key" value="{$subpanel_label}">
    </td>
</tr>
{/if}
<tr>

{counter start=0 name="groupCounter" print=false assign="groupCounter"}
{foreach from=$groups key='label' item='list'}
    {counter name="groupCounter"}
{/foreach}
{math assign="groupWidth" equation="100/$groupCounter-3"}

{counter start=0 name="slotCounter" print=false assign="slotCounter"}
{counter start=0 name="modCounter" print=false assign="modCounter"}

{foreach from=$groups key='label' item='list'}

<td id={$label}  width="30%" VALIGN="top" style="float: left; border: 1px gray solid; padding:4px; margin-right:4px; margin-top: 8px;  overflow-x: hidden;">
<h3 >{$label}</h3>
<ul id='ul{$slotCounter}' style="overflow-y: auto; overflow-x: hidden;">

{foreach from=$list key='key' item='value'}

<li name="width={$value.width}%" id='subslot{$modCounter}' class='draggable' >
    <table width='100%'>
        <tr>
            <td id='subslot{$modCounter}label' style="font-weight: bold;">
            {if $MB}
            {if !empty($value.label)}{$current_mod_strings[$value.label]}{elseif !empty($value.vname)}{$current_mod_strings[$value.vname]}{else}{$key}{/if}
            {else}
            {if !empty($value.label)}{sugar_translate label=$value.label module=$language}{elseif !empty($value.vname)}{sugar_translate label=$value.vname module=$language}{else}{$key}{/if}
            {/if}
            </td>
            <td></td>
            <td align="right" class="editIcon">
                <button class="suitepicon suitepicon-action-edit" style="cursor: pointer;"
				onclick="var value_label = document.getElementById('subslot{$modCounter}label').innerHTML.replace(/^\s+|\s+$/g,''); 
				    {if !($view|substr:-6 == "search") }
					var value_width = document.getElementById('subslot{$modCounter}width').innerHTML;
					{/if}
					ModuleBuilder.getContent('module=ModuleBuilder&action=editProperty&view_module={$view_module|escape:'url'}'+
							'{if isset($subpanel)}&subpanel={$subpanel|escape:'url'}{/if}'+
							'{if $MB}&MB={$MB|escape:'url'}&view_package={$view_package|escape:'url'}{/if}'+
							'&id_label=subslot{$modCounter}label'+
							'&name_label=label_'+
							  '{if isset($value.label)}{$value.label|escape:'url'}'+
							  '{elseif !empty($value.vname)}{$value.vname|escape:'url'}'+
							  '{else}{$key|escape:'url'}{/if}'+
							'&title_label={$MOD.LBL_LABEL_TITLE}&value_label=' + encodeURIComponent(value_label)
							{if ($view|substr:-6 != "search") }
							+ '&id_width=subslot{$modCounter}width&name_width={$MOD.LBL_WIDTH|escape:'url'}&value_width=' + encodeURIComponent(value_width)
							{/if}
					);return false;"
				>
            </td>
            </tr>
            <tr class='fieldValue'>
                {if empty($hideKeys)}<td>[{$key}]</td>{/if}
                <td align="right" colspan="2" class="percentage">
					{if $view|substr:-6 == "search" }
					<span style="display:none" id='subslot{$modCounter}width'>{$value.width}</span>	<span style="display:none">%</span>
					{else}
					<span id='subslot{$modCounter}width'>{$value.width}</span> <span>%</span>
					{/if}
				</td>
        </tr>
    </table>
</li>

<script>
studiotabs.tabLabelToValue['{$value.label}|{$key}'] = '{$key}';
if(typeof(studiotabs.subtabModules['subslot{$modCounter}']) == 'undefined')studiotabs.subtabModules['subslot{$modCounter}'] = '{$value.label}|{$key}';
</script>

{counter name="modCounter"}
{/foreach}

<li id='topslot{$slotCounter}' class='noBullet'>&nbsp;</li>

</ul>
</td>

{counter name="slotCounter"}
{/foreach}
</td>
</tr></table>

<script>

{literal}
function dragDropInit(){
    studiotabs.fields = {};
    studiotabs.slotCount = {/literal}{$slotCounter};
    studiotabs.modCount = {$modCounter};
    {literal}
    for(msi = 0; msi < studiotabs.slotCount ; msi++){
        studiotabs.fields["topslot"+ msi] = new Studio2.ListDD("topslot" + msi, "subTabs", true);
    }
    for(msi = 0; msi < studiotabs.modCount ; msi++){
            studiotabs.fields["subslot"+ msi] = new Studio2.ListDD("subslot" + msi, "subTabs", false);
    }

    if(studiotabs.modCount > 0) {
        studiotabs.fields["subslot" + (msi - 1)].updateTabs();
    }
};

resizeDDLists = function() {
	var Dom = YAHOO.util.Dom;
	if (!Dom.get('ul0'))
            return;
    var body = document.getElementById('mbtabs');
    for(var msi = 0; msi < studiotabs.slotCount ; msi++){
        var targetHeight =  body.offsetHeight - (Dom.getY("ul" + msi) - Dom.getY(body)) - 20;
        if (SUGAR.isIE) {
            targetHeight -= 10;
        }

        if (targetHeight > 0 )
        	Dom.setStyle("ul" + msi, "height", targetHeight + "px");
    }
	Studio2.scrollZones = {}
	for (var i = 0; Dom.get("ul" + i); i++){
		Studio2.scrollZones["ul" + i] = Studio2.getScrollZones("ul" + i);
	}
};

function countListFields() {
	var count = 0;
	var divs = document.getElementById( 'ul0' ).getElementsByTagName( 'li' ) ;		
	for ( var j=0;j<divs.length;j++) {
		if (divs[j].className == 'draggable') count++;
	}
	return count;
};

{/literal}
dragDropInit();
setTimeout(resizeDDLists, 100);
ModuleBuilder.helpRegister('edittabs');
ModuleBuilder.helpRegisterByID('content', 'div');
studiotabs.view = '{$view}';
ModuleBuilder.helpSetup('{$helpName}', '{$helpDefault}');
if('{$from_mb}')
    ModuleBuilder.helpUnregisterByID('savebtn');
ModuleBuilder.MBpackage = '{$view_package}';
</script>



<div id='logDiv' style='display:none'>
</div>

{$additionalFormData}

</form>


