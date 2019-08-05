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

<table width="100%">
<tr>
	<td class='mbLBL' width='30%' >{sugar_translate module="DynamicFields" label="COLUMN_TITLE_NAME"}:</td>
	<td>
	{if $hideLevel == 0}
		<input id="field_name_id" maxlength={if isset($package->name) && $package->name != "studio"}30{else}28{/if} type="text" name="name" value="{$vardef.name}"
		  onchange="
		document.getElementById('label_key_id').value = 'LBL_'+document.getElementById('field_name_id').value.toUpperCase();
		document.getElementById('label_value_id').value = document.getElementById('field_name_id').value.replace(/\_+/g,' ').replace(/^\s\s*/, '').replace(/\s\s*$/, '');
		document.getElementById('field_name_id').value = document.getElementById('field_name_id').value.toLowerCase();" />
	{else}
		<input id= "field_name_id" type="hidden" name="name" value="{$vardef.name}"
		  onchange="
		document.getElementById('label_key_id').value = 'LBL_'+document.getElementById('field_name_id').value.toUpperCase();
		document.getElementById('label_value_id').value = document.getElementById('field_name_id').value.replace(/\_+/g,' ').replace(/^\s\s*/, '').replace(/\s\s*$/, '');
		document.getElementById('field_name_id').value = document.getElementById('field_name_id').value.toLowerCase();"/>
		{$vardef.name}
	{/if}
		<script>
		addToValidate('popup_form', 'name', 'DBName', true,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_NAME"} [a-zA-Z_]' );
		addToValidateIsInArray('popup_form', 'name', 'in_array', true,'{sugar_translate module="DynamicFields" label="ERR_RESERVED_FIELD_NAME"}', '{$field_name_exceptions}', 'u==');
		{if $hideLevel == 0}	
		addToValidateIsInArray('popup_form', 'name', 'in_array', true, '{sugar_translate module="DynamicFields" label="ERR_FIELD_NAME_ALREADY_EXISTS"}', '{$existing_field_names}', 'u==');
		{/if}	
		</script>
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DISPLAY_LABEL"}:</td>
	<td>
		<input id="label_value_id" type="text" name="labelValue" value="{$lbl_value}">
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_LABEL"}:</td>
	<td>
    {if $hideLevel < 1}
	    <input id ="label_key_id" type="text" name="label" value="{$vardef.vname}">
	{else}
		<input type="text" readonly value="{$vardef.vname}" disabled=1>
		<input id ="label_key_id" type="hidden" name="label" value="{$vardef.vname}">
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_HELP_TEXT"}:</td><td>{if $hideLevel < 5 }<input type="text" name="help" value="{$vardef.help}">{else}<input type="hidden" name="help" value="{$vardef.help}">{$vardef.help}{/if}
	</td>
</tr>
<tr>
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_COMMENT_TEXT"}:</td><td>{if $hideLevel < 5 }<input type="text" name="comments" value="{$vardef.comments}">{else}<input type="hidden" name="comment" value="{$vardef.comment}">{$vardef.comment}{/if}
    </td>
</tr>
