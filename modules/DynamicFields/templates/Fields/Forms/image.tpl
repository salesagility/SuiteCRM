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


{include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}

<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_IMAGE_WIDTH"}:</td>
	<td>
		<input id ="width" type="text" name="width" 
		{if !$vardef.width && !$vardef.height}
			value="120"
		{else}
			value="{$vardef.width}"
		{/if}
		>
		{sugar_help text=$mod_strings.LBL_POPHELP_IMAGE_WIDTH FIXX=300 FIXY=200}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_IMAGE_HEIGHT"}:</td>
	<td>
		<input id ="height" type="text" name="height" 
		{if !$vardef.width && !$vardef.height}
			value=""
		{else}
			value="{$vardef.height}"
		{/if}
		>
		{sugar_help text=$mod_strings.LBL_POPHELP_IMAGE_HEIGHT FIXX=300 FIXY=220}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_IMAGE_BORDER"}:</td>
	<td>	
		<input type="checkbox" id ="border" name="border" value="1" {if !empty($vardef.border)}checked{/if}/>
	</td>
</tr>
{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}