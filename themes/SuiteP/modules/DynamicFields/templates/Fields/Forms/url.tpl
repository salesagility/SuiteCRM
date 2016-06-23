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
{include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}
<input type=hidden id='ext3' name='ext3' value='{$vardef.gen}'>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_GENERATE_URL"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='checkbox' id='gencheck' {if $vardef.gen}checked=true{/if} name='genCheck' value="0" onclick="
			if(this.checked) {ldelim}
				 YAHOO.util.Dom.setStyle('fieldListHelper', 'display', '');
                 YAHOO.util.Dom.get('ext3').value = 1;
			{rdelim} else {ldelim}
				YAHOO.util.Dom.setStyle('fieldListHelper', 'display', 'none');
                YAHOO.util.Dom.get('ext3').value = 0;
			{rdelim}">
	{else}
		<input type='checkbox' name='ext3' {if $vardef.gen}checked=true{/if} disabled>
	{/if}
	</td>
</tr>
<tr id='fieldListHelper' {if !$vardef.gen}style="display:none"{/if}>
	<td></td>
	<td>{html_options name="flo" id="fieldListOptions" options=$fieldOpts}
		<input type='button' class='button' value="Insert Field" onclick="
			YAHOO.util.Dom.get('default').value += '{ldelim}' + YAHOO.util.Dom.get('fieldListOptions').value + '{rdelim}'
		"></td> 
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' name='default' id='default' value='{$vardef.default}' maxlength='{$vardef.len|default:50}'>
	{else}
		<input type='hidden' id='default' name='default' value='{$vardef.default}'>{$vardef.default}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MAX_SIZE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' name='len' value='{$vardef.len|default:255}' onchange="forceRange(this,1,255);changeMaxLength(document.getElementById('default'),this.value);">
		{literal}
		<script>
		function forceRange(field, min, max){
			field.value = parseInt(field.value);
			if(field.value == 'NaN')field.value = max;
			if(field.value > max) field.value = max;
			if(field.value < min) field.value = min;
		}
		function changeMaxLength(field, length){
			field.maxLength = parseInt(length);
			field.value = field.value.substr(0, field.maxLength);
		}
		</script>
		{/literal}
	{else}
		<input type='hidden' name='len' value='{$vardef.len}'>{$vardef.len}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_LINK_TARGET"}:</td>
	<td>
	{if $hideLevel < 5}
		<select name='ext4' id='ext4'>
            {$TARGET_OPTIONS}
        </select>
	{else}
		<select name='extdis' id='extdis' disabled>
            <option value='{$LINK_TARGET}'>{$LINK_TARGET_LABEL}</option>
        </select>
        <input type='hidden' name='ext4' value='{$LINK_TARGET}'>
	{/if}
	</td>
</tr>

{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}