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
<table class="h3Row" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td nowrap>
<h3>{$mod.LBL_MODIFY_SEARCH}</h3></td><td width='100%'>
<IMG height='1' width='1' src='include/images/blank.gif' alt=''>
</td>
</tr>
</table>
<form name='SearchForm' method='POST' id='SearchForm'>
 	<input type='hidden' name='source_id' id='source_id' value='{$source_id}' />
 	<input type='hidden' name='merge_module' value='{$module}' />
 	<input type='hidden' name='record' value='{$RECORD}' />
 	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tabForm">
{if !empty($search_fields) }
 	<tr>
 	 {counter assign=field_count start=0 print=0} 
	 {foreach from=$search_fields key=field_name item=field_value} 
	 	{counter assign=field_count}
		{if ($field_count % 3 == 1 && $field_count != 1)}
		</tr><tr>
		{/if}
		<td nowrap="nowrap" width='10%' class="dataLabel">
		{$field_value.label}: 
		</td>
		<td nowrap="nowrap" width='30%' class="dataField">
		<input type='text' onkeydown='checkKeyDown(event);' name='{$field_name}' value='{$field_value.value}'/>
		</td>
	 {/foreach}
{else}
     {$mod.ERROR_NO_SEARCHDEFS_MAPPING}
{/if}
</table>
<input type='button' name='btn_search' id='btn_search' title="{$APP.LBL_SEARCH_BUTTON_LABEL}" accessKey="{$APP.LBL_SEARCH_BUTTON_KEY}" class="button" onClick="javascript:SourceTabs.search();" value="      {$APP.LBL_SEARCH_BUTTON_LABEL}      "/>&nbsp;
<input type='button' name='btn_clear' title="{$APP.LBL_CLEAR_BUTTON_LABEL}" class="button" onClick="javascript:SourceTabs.clearForm();" value="{$APP.LBL_CLEAR_BUTTON_LABEL}"/>
</form>