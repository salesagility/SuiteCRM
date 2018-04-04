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


<form name="projectQuickCreate" id="projectQuickCreate" method="POST" action="index.php">
<input type="hidden" name="module" value="Project">
<input type="hidden" name="quote_id" value="{$REQUEST.quote_id}">
<input type="hidden" name="contact_id" value="{$REQUEST.contact_id}">
<input type="hidden" name="email_id" value="{$REQUEST.email_id}">
<input type="hidden" name="account_id" value="{$REQUEST.account_id}">
<input type="hidden" name="return_action" value="{$REQUEST.return_action}">
<input type="hidden" name="opportunity_id" value="{$REQUEST.opportunity_id}">
<input type="hidden" name="return_module" value="{$REQUEST.return_module}">
<input type="hidden" name="return_id" value="{$REQUEST.return_id}">
<input type="hidden" name="action" value='Save'>
<input type="hidden" name="duplicate_parent_id" value="{$REQUEST.duplicate_parent_id}">
<input id='assigned_user_id' name='assigned_user_id' type="hidden" value="{$ASSIGNED_USER_ID}" />
<input type="hidden" name="to_pdf" value='1'>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td align="left" style="padding-bottom: 2px;">
		<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" type="submit" name="button" {$saveOnclick|default:"onclick=\"return check_form('ProjectQuickCreate');\""} value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " >
		<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" type="submit" name="button" {$cancelOnclick|default:"onclick=\"this.form.action.value='$RETURN_ACTION'; this.form.module.value='$RETURN_MODULE'; this.form.record.value='$RETURN_ID'\""} value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  ">
		<input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" accessKey="{$APP.LBL_FULL_FORM_BUTTON_KEY}" class="button" type="submit" name="button" onclick="this.form.to_pdf.value='0';this.form.action.value='EditView'; this.form.module.value='Project';" value="  {$APP.LBL_FULL_FORM_BUTTON_LABEL}  "></td>
	<td align="right" nowrap><span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span> {$APP.NTC_REQUIRED}</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
<tr>
<td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td valign="top" scope="row"><span>{$MOD.LBL_NAME} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
	<td><span><textarea name='name' cols="50" tabindex='2' rows="1">{$NAME}</textarea></span></td>
	</tr>
	<tr>
	<td valign="top" scope="row" width="15%"><span>{$MOD.LBL_DATE_START} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
	<td width="35%"><span><input name='estimated_start_date' onblur="parseDate(this, '{$CALENDAR_DATEFORMAT}');" id='jscal_field_start' type="text" tabindex='2' size='11' maxlength='10' value="{$START_DATE}"> <span id="jscal_trigger_start" class="suitepicon suitepicon-module-calendar"></span> </span></td>
	<td valign="top" scope="row" width="15%"><span>{$MOD.LBL_DATE_END} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
	<td width="35%"><span><input name='estimated_end_date' onblur="parseDate(this, '{$CALENDAR_DATEFORMAT}');" id='jscal_field_end' type="text" tabindex='2' size='11' maxlength='10' value="{$END_DATE}">
			<span id="jscal_trigger_end" class="suitepicon suitepicon-module-calendar"></span></span></td>
	</tr>	
	<tr>
	<td valign="top" scope="row"><span>{$MOD.LBL_DESCRIPTION}</span></td>
	<td><span><textarea name='description' tabindex='3' cols="50" rows="4">{$DESCRIPTION}</textarea></span></td>
	</tr>
	</table>
	</form>
<script>
	Calendar.setup ({literal}{{/literal}
		inputField : "jscal_field_start", ifFormat : "{$CALENDAR_DATEFORMAT}", showsTime : false, button : "jscal_trigger_start", singleClick : true, step : 1, weekNumbers:false
	{literal}}{/literal});
	Calendar.setup ({literal}{{/literal}
		inputField : "jscal_field_end", ifFormat : "{$CALENDAR_DATEFORMAT}", showsTime : false, button : "jscal_trigger_end", singleClick : true, step : 1, weekNumbers:false
	{literal}}{/literal});
	
	{$additionalScripts}
</script>