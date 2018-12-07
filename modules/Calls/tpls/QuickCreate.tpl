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


<form name="callsQuickCreate" id="callsQuickCreate" method="POST" action="index.php">
<input type="hidden" name="module" value="Calls">
<input type="hidden" name="record" value="">
<input type="hidden" name="lead_id" value="{$REQUEST.lead_id}">
<input type="hidden" name="contact_id" value="{$REQUEST.contact_id}">
<input type="hidden" name="contact_name" value="{$REQUEST.contact_name}">
<input type="hidden" name="email_id" value="{$REQUEST.email_id}">
<input type="hidden" name="contact_invitees" value="{$REQUEST.contact_id}">
<input type="hidden" name="account_id" value="{$REQUEST.account_id}">			
<input type="hidden" name="opportunity_id" value="{$REQUEST.opportunity_id}">
<input type="hidden" name="acase_id" value="{$REQUEST.acase_id}">
<input type="hidden" name="return_action" value="{$REQUEST.return_action}">
<input type="hidden" name="return_module" value="{$REQUEST.return_module}">
<input type="hidden" name="return_id" value="{$REQUEST.return_id}">
<input type="hidden" name="action" value='Save'>
<input type="hidden" name="duplicate_parent_id" value="{$REQUEST.duplicate_parent_id}">
<!--
CL: Bug fix for 9291 and 9427 - parent_id should be parent_type, not the module type (if set)
-->

{if $REQUEST.parent_id}
	<input type="hidden" name="parent_id" value="{$REQUEST.parent_id}">
{else}
	<input type="hidden" name="parent_id" value="{$REQUEST.return_id}">
{/if}	
{if $REQUEST.parent_type}
	<input type="hidden" name="parent_type" value="{$REQUEST.parent_type}">
{else}
	<input type="hidden" name="parent_type" value="{$REQUEST.return_module}">
{/if}
<input type="hidden" name="parent_name" value="{$REQUEST.parent_name}">
<input type="hidden" name="to_pdf" value='1'>
<input id='assigned_user_id' name='assigned_user_id' type="hidden" value="{$ASSIGNED_USER_ID}" />
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td align="left" style="padding-bottom: 2px;">
		<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" type="submit" name="button" {$saveOnclick|default:"onclick=\"return check_form('CallsQuickCreate');\""} value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " >
		<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" type="submit" name="button" {$cancelOnclick|default:"onclick=\"this.form.action.value='$RETURN_ACTION'; this.form.module.value='$RETURN_MODULE'; this.form.record.value='$RETURN_ID'\""} value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  ">
		<input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" accessKey="{$APP.LBL_FULL_FORM_BUTTON_KEY}" class="button" type="submit" name="button" onclick="this.form.to_pdf.value='0';this.form.action.value='EditView'; this.form.module.value='Calls';" value="  {$APP.LBL_FULL_FORM_BUTTON_LABEL}  "></td>
	<td align="right" nowrap><span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span> {$APP.NTC_REQUIRED}</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
<tr>
<td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<th align="left" scope="row" colspan="4"><h4><span>{$MOD.LBL_NEW_FORM_TITLE}</span></h4></th>
	</tr>
	<tr>
	<td valign="top" scope="row"><span>{$MOD.LBL_SUBJECT} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
	<td><span><textarea name='name' cols="50" tabindex='1' rows="1">{$NAME}</textarea></span></td>
	<td scope="row" width="15%"><span>{$MOD.LBL_STATUS} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
	<td><span><select tabindex="2" name='direction'>{$DIRECTION_OPTIONS}</select> <select tabindex="2" name='status'>{$STATUS_OPTIONS}</select></span></td>
	</tr>
	<tr>
	<td valign="top" scope="row" rowspan="2"><span>{$MOD.LBL_DESCRIPTION}</span></td>
	<td rowspan="2"><span><textarea name='description' tabindex='1' cols="50" rows="4">{$DESCRIPTION}</textarea></span></td>
	<td scope="row"><span>{$MOD.LBL_DATE_TIME}</span></td>
	<td ><span>
		<table  cellpadding="0" cellspacing="0">
		<tr>
		<td nowrap>
		<input name='date_start' id='jscal_field' onblur="parseDate(this, '{$USER_DATEFORMAT}');" tabindex='2' size='11' maxlength='10' type="text" value="{$DATE_START}">
			<span class="suitepicon suitepicon-module-calendar" id="jscal_trigger" alt=$USER_DATEFORMAT></span>&nbsp;</td>
        <td nowrap>
        <select name='time_hour_start' tabindex="2">{$TIME_START_HOUR_OPTIONS}</select>{$TIME_SEPARATOR}
        <select name='time_minute_start' tabindex="2">{$TIME_START_MINUTE_OPTIONS}</select>
        {if $TIME_MERIDIEM}
        <select name='meridiem' tabindex="2">{$TIME_MERIDIEM}</select>
        {/if}
        </td>

        </tr>
        <tr>
        <td nowrap><span class="dateFormat">{$USER_DATEFORMAT}</span></td>
        <td nowrap><span class="dateFormat">{$TIME_FORMAT}</span></td>
        </tr>
        </table></span>
    </td>
	</tr>
	<tr>
	<td scope="row" valign="top"><span>{$MOD.LBL_DURATION} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
	<td valign="top" ><span><input id='duration_hours' name='duration_hours' tabindex="2" size='2' maxlength='2' type="text" value='{$DURATION_HOURS}'> <select tabindex="2" id='duration_minutes' name='duration_minutes'>{$DURATION_MINUTES_OPTIONS}</select> {$MOD.LBL_HOURS_MINS}</span></td>
	</tr>
	</table>
	</form>
<script type="text/javascript">
{literal}
Calendar.setup ({
	inputField : "jscal_field", daFormat : "{/literal}{$CALENDAR_FORMAT}{literal}", onClose: function(cal) { cal.hide(); }, showsTime : false, button : "jscal_trigger", singleClick : true, step : 1, startWeekday: {/literal}{$CALENDAR_FDOW|default:'0'}{literal}, weekNumbers:false
});
{/literal}
	{$additionalScripts}
</script>
