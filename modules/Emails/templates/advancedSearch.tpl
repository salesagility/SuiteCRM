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
<form name="advancedSearchForm" id="advancedSearchForm">
<table cellpadding="4" cellspacing="0" border="0" id='advancedSearchTable'>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td class="advancedSearchTD">
			{$app_strings.LBL_EMAIL_SUBJECT}:<br/>
			<input type="text" class="input" name="name" id="searchSubject" size="20">
		</td>
	</tr>
	<tr>
		<td class="advancedSearchTD">
			{$app_strings.LBL_EMAIL_FROM}:<br/>
			<input type="text" class="input" name="from_addr" id="searchFrom" size="20">
		</td>
	</tr>
	<tr>
		<td class="advancedSearchTD">
			{$app_strings.LBL_EMAIL_TO}:<br/>
			<input type="text" class="input" name="to_addrs" id="searchTo" size="20">
		</td>
	</tr>
    <tr class="toggleClass visible-search-option">
        <td ><a href="javascript:void(0);" onclick="SE.search.toggleAdvancedOptions();">{$mod_strings.LBL_MORE_OPTIONS}</a></td>
        <td>&nbsp;</td>
    </tr>
	<tr class="toggleClass yui-hidden">
		<td class="advancedSearchTD" style="padding-bottom: 2px">
			{$app_strings.LBL_EMAIL_SEARCH_DATE_FROM}:&nbsp;<i>({$dateFormatExample})</i><br/>
			<input name='searchDateFrom' id='searchDateFrom' onblur="parseDate(this, '{$dateFormat}');" maxlength='10' size='11' value="" type="text">&nbsp;
			<span id="searchDateFrom_trigger" class="suitepicon suitepicon-module-calendar" alt="$app_strings.LBL_ENTER_DATE"></span>
		</td>
	</tr>

	<tr class="toggleClass yui-hidden">
		<td class="advancedSearchTD">
			{$app_strings.LBL_EMAIL_SEARCH_DATE_UNTIL}:&nbsp;<i>({$dateFormatExample})</i><br/>
			<input name='searchDateTo' id='searchDateTo' onblur="parseDate(this, '{$dateFormat}');" maxlength='10' size='11' value="" type="text">&nbsp;
			<span id="searchDateTo_trigger" class="suitepicon suitepicon-module-calendar" alt="$app_strings.LBL_ENTER_DATE"></span>
		</td>
	</tr>

    <tr class="toggleClass yui-hidden">
        <td class="advancedSearchTD">
        {sugar_translate label="LBL_ASSIGNED_TO"}: <br/>
        <input name="assigned_user_name" class="sqsEnabled" tabindex="2" id="assigned_user_name" size="" value="{$currentUserName}" type="text" >
        <input name="assigned_user_id" id="assigned_user_id" value="{$currentUserId}" type="hidden">      
        
        <a href="javascript:void(0);">
			<span class="suitepicon suitepicon-action-select" align="absmiddle" border="0" alt=$mod_strings.LBL_EMAIL_SELECTOR onclick='open_popup("Users", 600, 400, "", true, false, {literal}{"call_back_function":"set_return","form_name":"advancedSearchForm","field_to_name_array":{"id":"assigned_user_id","name":"assigned_user_name"}}{/literal}, "single", true);'></span>
        </a>
        </td>
    </tr>
      <tr class="toggleClass yui-hidden">
        <td class="advancedSearchTD">
        {$mod_strings.LBL_HAS_ATTACHMENT}<br/>
        {html_options options=$attachmentsSearchOptions name='attachmentsSearch' id='attachmentsSearch'} 
        </td>
    </tr>
    <tr class="toggleClass yui-hidden">
        <td NOWRAP class="advancedSearchTD">
        {$mod_strings.LBL_EMAIL_RELATE}:<br/>
        {html_options options=$linkBeansOptions name='data_parent_type_search' id='data_parent_type_search'}
        <input id="data_parent_id_search" name="data_parent_id_search" type="hidden" value="">
        <br/><br/>
        <input class="sqsEnabled" id="data_parent_name_search" name="data_parent_name_search" type="text" value="">
        <a href="javascript:void(0);"><img src="{sugar_getimagepath file='id-ff-select.gif'}" align="absmiddle" border="0" alt=$mod_strings.LBL_EMAIL_SELECTOR onclick="SUGAR.email2.composeLayout.callopenpopupForEmail2('_search',{ldelim}'form_name':'advancedSearchForm'{rdelim} );">
         </a>
        </td>
    </tr>
     <tr class="toggleClass yui-hidden">
        <td class="visible-search-option"><a href="javascript:void(0);" onclick="SE.search.toggleAdvancedOptions();">{$mod_strings.LBL_LESS_OPTIONS}</a></td>
        <td>&nbsp;</td>
    </tr>
	<tr>
		<td NOWRAP>
			<br />&nbsp;<br />
			<input type="button" id="advancedSearchButton" class="button" onclick="SUGAR.email2.search.searchAdvanced()" value="   {$app_strings.LBL_SEARCH_BUTTON_LABEL}   ">&nbsp;
			<input type="button" class="button" onclick="SUGAR.email2.search.searchClearAdvanced()" value="   {$app_strings.LBL_CLEAR_BUTTON_LABEL}   ">
		</td>
	</tr>
</table>
</form>