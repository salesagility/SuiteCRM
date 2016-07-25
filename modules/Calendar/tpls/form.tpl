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
<form id="CalendarEditView" name="CalendarEditView" method="POST">

	<input type="hidden" name="current_module" id="current_module" value="Meetings">
	<input type="hidden" name="return_module" id="return_module" value = "Calendar">
	<input type="hidden" name="record" id="record" value="">
	<input type="hidden" name="full_form" value="">
	<input type="hidden" name="user_invitees" id="user_invitees">
	<input type="hidden" name="contact_invitees" id="contact_invitees">
	<input type="hidden" name="lead_invitees" id="lead_invitees">
	<input type="hidden" name="send_invites" id="send_invites">


	<input type="hidden" name="edit_all_recurrences" id="edit_all_recurrences">
	<input type="hidden" name="repeat_parent_id" id="repeat_parent_id">
	<input type="hidden" name="repeat_type" id="repeat_type">
	<input type="hidden" name="repeat_interval" id="repeat_interval">
	<input type="hidden" name="repeat_count" id="repeat_count">
	<input type="hidden" name="repeat_until" id="repeat_until">
	<input type="hidden" name="repeat_dow" id="repeat_dow">


	<div style="padding: 4px 0; font-size: 12px;">
		{literal}
		<input type="radio" id="radio_meeting" value="Meetings" onclick="CAL.change_activity_type(this.value);" checked="true"  name="appttype" tabindex="100"/>
		{/literal}
		<label for="radio_meeting">{$MOD.LBL_CREATE_MEETING}</label>
		{literal}
		<input type="radio" id="radio_call" value="Calls" onclick="CAL.change_activity_type(this.value);" name="appttype" tabindex="100"/>
		{/literal}
		<label for="radio_call">{$MOD.LBL_CREATE_CALL}</label>
	</div>

	<div id="form_content">
		<input type="hidden" name="date_start" id="date_start" value="{$user_default_date_start}">
		<input type="hidden" name="duration_hours" id="duration_hours">
		<input type="hidden" name="duration_minutes" id="duration_minutes">
	</div>

</form>

<script type="text/javascript">
enableQS(false);
{literal}
function cal_isValidDuration(){ 
	form = document.getElementById('CalendarEditView');
	if(typeof form.duration_hours == "undefined" || typeof form.duration_minutes == "undefined")
		return true;
	if(form.duration_hours.value + form.duration_minutes.value <= 0){
		alert('{/literal}{$MOD.NOTICE_DURATION_TIME}{literal}'); 
		return false; 
	} 
	return true;
}
{/literal}
</script>
<script type="text/javascript" src="include/SugarFields/Fields/Datetimecombo/Datetimecombo.js"></script>
