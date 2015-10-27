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
{literal}

<style type="text/css">

</style>
{/literal}

<!-- Template for reminders  -->
<div style="display:none;">
	<div id="reminder_template">

		<input class="remove-reminder-btn remove-btn" type="button" value="{$MOD.LBL_REMINDERS_REMOVE_REMINDER}" onclick="Reminders.onRemoveClick(this);"><br>
		<label>{$MOD.LBL_REMINDERS_ACTIONS}</label><br>
		<input type="checkbox" class="popup_chkbox" onclick="Reminders.onPopupChkboxClick(this);"><label>{$MOD.LBL_REMINDERS_POPUP}</label><br>
		<input type="checkbox" class="email_chkbox" onclick="Reminders.onEmailChkboxClick(this);"><label>{$MOD.LBL_REMINDERS_EMAIL}</label><br>
		<label>{$MOD.LBL_REMINDERS_WHEN}</label>
		<select tabindex="0" class="timer_sel" onchange="Reminders.onTimerSelChange(this);">
			{html_options options=$fields.reminder_time.options}
		</select>
		<br>
		<ul class="invitees_list"></ul>
		<div class="clear"></div>
		<input class="add-btn" type="button" value="{$MOD.LBL_REMINDERS_ADD_ALL_INVITEES}" onclick="Reminders.onAddAllClick(this);"><br>

	</div>
</div>

<!-- Reminders field in EditViews -->
<div id="reminders">
	<input type="hidden" id="reminders_data" name="reminders_data" />
	<ul id="reminder_view"></ul>
	<input id="reminder_add_btn" class="add-btn" type="button" value="{$MOD.LBL_REMINDERS_ADD_REMINDER}" onclick="Reminders.onAddClick(this);">
</div>

{literal}
<script type="text/javascript">

	$(function(){
		Reminders.init({/literal}{$remindersDataJson}{literal});
	});

</script>
{/literal}