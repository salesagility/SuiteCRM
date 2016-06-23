{*
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

*}
<form name="editProperty" id="editProperty" onsubmit='return false;'>
<input type='hidden' name='module' value='ModuleBuilder'>
<input type='hidden' name='action' value='saveProperty'>
<input type='hidden' name='view_module' value='{$view_module}'>
{if isset($view_package)}<input type='hidden' name='view_package' value='{$view_package}'>{/if}
<input type='hidden' name='subpanel' value='{$subpanel}'>
<input type='hidden' name='to_pdf' value='true'>

{if isset($MB)}
<input type='hidden' name='MB' value='{$MB}'>
<input type='hidden' name='view_package' value='{$view_package}'>
{/if}

{literal}
<script>
	function saveAction() {
		for(var i=0;i<document.editProperty.elements.length;i++)
		{
			var field = document.editProperty.elements[i];
			if (field.className.indexOf('save') != -1 )
			{
				if (field.value != 'no_change')
				{
					var property = field.name.substring('editProperty_'.length);
					var id = field.id.substring('editProperty_'.length);
					document.getElementById(id).innerHTML = YAHOO.lang.escapeHTML(field.value);
				}
			}
		}
	}
	

	function switchLanguage( language )
	{
{/literal}
        var request = 'module=ModuleBuilder&action=editProperty&view_module={$editModule}&selected_lang=' + language ;
        {foreach from=$properties key='key' item='property'}
                request += '&id_{$key}={$property.id}&name_{$key}={$property.name}&title_{$key}={$property.title}&label_{$key}={$property.label}' ;
        {/foreach}
{literal}
        ModuleBuilder.getContent( request ) ;
    }

</script>
{/literal}

<table>

	{foreach from=$properties key='key' item='property'}
	<tr>
		<td width = "50%" align='right'>{if isset($property.title)}{$property.title}{else}{$property.name}{/if}:</td>
		<td>
			<input class='save' type='hidden' name='{$property.name}' id='editProperty_{$id}{$property.id}' value='no_change'>
			{if isset($property.hidden)}
				{$property.value}
			{else}
				<input onchange='document.getElementById("editProperty_{$id}{$property.id}").value = this.value' value='{$property.value}'>
			{/if}
		</td>	
	</tr>
	{/foreach}
	<tr>
		<td><input class="button" type="Button" name="save" value="{$APP.LBL_SAVE_BUTTON_LABEL}" onclick="saveAction(); ModuleBuilder.submitForm('editProperty'); ModuleBuilder.closeAllTabs();"></td>
	</tr>
</table>
</form>

<script>
ModuleBuilder.helpSetup('layoutEditor','property', 'east');
</script>


