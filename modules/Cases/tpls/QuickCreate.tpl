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


<form name="casesQuickCreate" id="casesQuickCreate" method="POST" action="index.php">
<input type="hidden" name="module" value="Cases">
<input type="hidden" name="contact_id" value="{$REQUEST.contact_id}">
<input type="hidden" name="contact_name" value="{$REQUEST.contact_name}">
<input type="hidden" name="email_id" value="{$REQUEST.email_id}">
<input type="hidden" name="bug_id" value="{$REQUEST.bug_id}">
<input type="hidden" name="return_action" value="{$REQUEST.return_action}">
<input type="hidden" name="return_module" value="{$REQUEST.return_module}">
<input type="hidden" name="return_id" value="{$REQUEST.return_id}">
<input type="hidden" name="action" value='Save'>
<input type="hidden" name="duplicate_parent_id" value="{$REQUEST.duplicate_parent_id}">
<input type="hidden" name="to_pdf" value='1'>
<input id='assigned_user_id' name='assigned_user_id' type="hidden" value="{$ASSIGNED_USER_ID}" />
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td align="left" style="padding-bottom: 2px;">
		<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" type="submit" name="button" {$saveOnclick|default:"onclick=\"return check_form('CasesQuickCreate');\""} value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " >
		<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" type="submit" name="button" {$cancelOnclick|default:"onclick=\"this.form.action.value='$RETURN_ACTION'; this.form.module.value='$RETURN_MODULE'; this.form.record.value='$RETURN_ID'\""} value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  ">
		<input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" accessKey="{$APP.LBL_FULL_FORM_BUTTON_KEY}" class="button" type="submit" name="button" onclick="this.form.to_pdf.value='0';this.form.action.value='EditView'; this.form.module.value='Cases';" value="  {$APP.LBL_FULL_FORM_BUTTON_LABEL}  "></td>
	<td align="right" nowrap><span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span> {$APP.NTC_REQUIRED}</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
<tr>
<td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<th align="left" scope="row" colspan="4"><h4><slot>{$MOD.LBL_CASE_INFORMATION}</slot></h4></th>
	</tr>
	<tr>
	<td valign="top" scope="row"><slot>{$MOD.LBL_SUBJECT} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></slot></td>
	<td><slot><textarea name='name' cols="50" tabindex='1' rows="1">{$NAME}</textarea></slot></td>
	<td scope="row"><slot>{$MOD.LBL_PRIORITY}</slot></td>
	<td  nowrap><slot><select  tabindex='2' name='priority'>{$PRIORITY_OPTIONS}</select></slot></td>
	</tr>
	<tr>
	<td valign="top" scope="row" rowspan="2"><slot>{$MOD.LBL_DESCRIPTION}</slot></td>
	<td rowspan="2"><slot><textarea name='description' tabindex='1' cols="50" rows="4">{$DESCRIPTION}</textarea></slot></td>
	<td scope="row"><slot>{$MOD.LBL_STATUS}</slot></td>
	<td><slot><select tabindex='2' name='status'>{$STATUS_OPTIONS}</select></slot></td>
	</tr>
	<tr>
	{if $REQUEST.account_id != ''}
	<td scope="row"><slot>{$MOD.LBL_ACCOUNT_NAME} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></slot></td>
	<td ><slot>{$REQUEST.parent_name}<input id='account_name' name='account_name' type="hidden" value='{$REQUEST.parent_name}'><input id='account_id' name='account_id' type="hidden" value='{$REQUEST.parent_id}'>&nbsp;</slot></td>
	{else}
	<td scope="row"><slot>{$MOD.LBL_ACCOUNT_NAME} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></slot></td>
	<td ><slot><input class="sqsEnabled" tabindex="1" autocomplete="off" id="account_name" name='account_name' type="text" value="{$ACCOUNT_NAME}">
	<input name='account_id' id="account_id" type="hidden" value='{$ACCOUNT_ID}' />&nbsp;<input tabindex='1' title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="button" class="button" value='{$APP.LBL_SELECT_BUTTON_LABEL}' name="btn1"
			onclick='open_popup("Accounts", 600, 400, "", true, false, {$encoded_popup_request_data}, "", true);' /></slot></td>	
	{/if}
	</tr>
	</table>
	</form>
<script>
	{$additionalScripts}
</script>