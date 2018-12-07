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


{include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}
<tr>
	<td nowrap="nowrap">{sugar_translate module="DynamicFields" label="LBL_DROP_DOWN_LIST"}:</td>
	<td>
	{if $hideLevel < 5}
		{html_options name="ext1" id="ext1" selected=$cf.ext1 values=$dropdowns output=$dropdowns onChange="dropdownChanged(this.value);"}
	{else}
		<input type='hidden' name='ext1' value='$cf.ext1'>{$cf.ext1}
	{/if}
	</td>
</tr>
<tr>
	<td nowrap="nowrap">{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}:</td>
	<td>
	{if $hideLevel < 5}
		{html_options name="default_value" id="default_value" selected=$cf.default_value options=$selected_dropdown }
	{else}
		<input type='hidden' name='default_value' value='$cf.default_value'>{$cf.default_value}
	{/if}
	</td>
</tr>
<tr>
	<td nowrap="nowrap">{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DISPLAYED_ITEM_COUNT"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' name='ext2' id='ext2' value='{$cf.ext2|default:5}'>
		<script>addToValidate('popup_form', 'ext2', 'int', false,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DISPLAYED_ITEM_COUNT"}' );</script>
	{else}
		<input type='hidden' name='ext2' value='{$cf.ext2}'>{$cf.ext2}
	{/if}
	</td>
</tr>
<tr>
	<td nowrap="nowrap">{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MASS_UPDATE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type="checkbox" name="mass_update" value="1" {if !empty($cf.mass_update)}checked{/if}/>
	{else}
		<input type="checkbox" name="mass_update" value="1" disabled {if !empty($cf.mass_update)}checked{/if}/>
	{/if}
	</td>
</tr>

{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}
<script>dropdownChanged(document.getElementById('ext1').options[document.getElementById('ext1').options.selectedIndex]);</script>

