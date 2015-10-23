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
/* reminders on meeting and calls */
#reminders .clear {clear:both;}
#reminders .remove-reminder-btn {float: right;}
#reminders #reminder_view {
	list-style-type: none;
	margin: 0;
	padding: 0;
	border: none;
}
#reminders #reminder_view .reminder_item {
	list-style-type: none;
	margin: 10px 0;
	padding: 10px;
	border: 1px solid lightgray;
}
#reminders #reminder_view .reminder_item .invitees_list {
	list-style-type: none;
	margin: 0;
	padding: 0;
	border: none;
	display: block;
}
#reminders #reminder_view .reminder_item .invitees_list .invitees_item {
	list-style-type: none;
	margin: 0;
	padding: 0;
	border: none;
	float: left;
}
#reminders #reminder_view .reminder_item .invitees_list .invitees_item .invitee_btn {
	margin: 4px;
}

</style>
{/literal}


<div style="display:none;">
	<div id="reminder_template">

		<input class="remove-reminder-btn" type="button" value="{$MOD.LBL_REMINDERS_REMOVE_REMINDER}" onclick="Reminders.onRemoveClick(this);"><br>
		<label>{$MOD.LBL_REMINDERS_ACTIONS}</label><br>
		<input type="checkbox" class="popup_chkbox" onclick="Reminders.onPopupChkboxClick(this);"><label>{$MOD.LBL_REMINDERS_POPUP}</label><br>
		<input type="checkbox" class="email_chkbox" onclick="Reminders.onEmailChkboxClick(this);"><label>{$MOD.LBL_REMINDERS_EMAIL}</label><br>
		<label>{$MOD.LBL_REMINDERS_WHEN}</label>
		<select tabindex="0" class="duration_sel" onchange="Reminders.onDurationSelChange(this);">
			{html_options options=$fields.reminder_time.options}
		</select>
		<br>
		<ul class="invitees_list"></ul>
		<div class="clear"></div>
		<input type="button" value="{$MOD.LBL_REMINDERS_ADD_ALL_INVITEES}" onclick="Reminders.onAddAllClick(this);"><br>

	</div>
</div>

<div id="reminders">
	<input type="hidden" id="reminders_data" name="reminders_data" />
	<ul id="reminder_view"></ul>
	<input id="reminder_add_btn" type="button" value="{$MOD.LBL_REMINDERS_ADD_REMINDER}">
</div>

{literal}
<script type="text/javascript">

	var Reminders = {
		getInviteeView: function(id, module, moduleId, relatedValue) {
			if(!id) id = '';
			var inviteeView = '<li class="invitees_item"><button class="invitee_btn" data-invitee-id="' + id + '" data-id="' + moduleId + '" data-module="' + module + '" onclick="Reminders.onInviteeClick(this);"><img src=index.php?entryPoint=getImage&themeName=SuiteR+&imageName='+ module +'.gif"><span class="related-value">' + relatedValue + '</span>&nbsp<span>[x]</span></button></li>';
			return inviteeView;
		},

		addAllInvitees: function(e) {
			var inviteesList = '';
			$('table#schedulerTable tr.schedulerAttendeeRow').each(function(i,e){
				var dataModule = $(e).attr('data-module');
				var dataId = $(e).attr('data-id');
				var relatedValue = $(e).find('td[scope="row"]').first().text();
				inviteesList += Reminders.getInviteeView(false, dataModule, dataId, relatedValue);
			});
			$(e).parent().find('.invitees_list').first().html(inviteesList);
		},

		addInvitees: function(e, invitees) {
			if(!e) e = document.getElementById('reminder_template');
			var inviteesList = '';
			$.each(invitees, function(i,e){
				inviteesList += Reminders.getInviteeView(e.id, e.module, e.module_id, e.value);
			});
			$(e).parent().find('.invitees_list').first().html(inviteesList);
		},

		setCheckboxValue(sel, value) {
			if(!value || value === false || value === 0 || value === '0' || value === '' || (typeof value == 'string' && value.toLowerCase() === 'false') ) {
				value = false;
			}
			else {
				value = true;
			}
			sel.prop('checked', value);
			sel.attr('checked', value);
		},

		setSelectValue: function(sel, value) {
			sel.val(value);
			sel.find('option').prop('selected', false);
			sel.find('option[value="' + value + '"]').attr('selected', 'selected');
			sel.find('option[value="' + value + '"]').prop('selected', true);
		},

		setReminderPopupChkbox: function(e, value) {
			Reminders.setCheckboxValue($(e).find('.popup_chkbox'), value);
		},

		setReminderEmailChkbox: function(e, value) {
			Reminders.setCheckboxValue($(e).find('.email_chkbox'), value);
		},

		setDurationSelectValue: function(e, value) {
			Reminders.setSelectValue(e.find('.duration_sel'), value);
		},

		addReminder: function(e, popup, email, duration, reminderId, invitees) {
			if(!reminderId) reminderId = '';
			Reminders.setReminderPopupChkbox($('#reminder_template'), popup);
			Reminders.setReminderEmailChkbox($('#reminder_template'), email);
			Reminders.setDurationSelectValue($('#reminder_template'), duration);
			if(!invitees) {
				Reminders.addAllInvitees($('#reminder_template'));
			}
			else {
				Reminders.addInvitees(e, invitees);
			}
			$('#reminder_view').append('<li class="reminder_item" data-reminder-id="' + reminderId + '">' + $('#reminder_template').html() + '</li>');
		},

		onAddClick: function(e){
			Reminders.addReminder(e, true, true, 60);
			Reminders.createRemindersPostData();
		},
		onRemoveClick: function(e) {
			$(e).parent().remove();
			Reminders.createRemindersPostData();
		},
		onAddAllClick: function(e) {
			Reminders.addAllInvitees(e);
			Reminders.createRemindersPostData();
		},
		onInviteeClick: function(e) {
			$(e).parent().remove();
			Reminders.createRemindersPostData();
		},

		getInviteesData: function(e) {
			var ret = [];
			$(e).find('.invitee_btn').each(function(i,e){
				ret.push({
					id: $(e).attr('data-invitee-id'),
					module: $(e).attr('data-module'),
					module_id: $(e).attr('data-id')
				});
			});
			return ret;
		},

		createRemindersPostData: function() {
			var reminders = [];
			$('#reminder_view .reminder_item').each(function(i,e) {
				//console.log(e);
				reminders.push({
					id: $(e).attr('data-reminder-id'),
					popup: $(e).find('.popup_chkbox').prop('checked'),
					email: $(e).find('.email_chkbox').prop('checked'),
					duration: $(e).find('.duration_sel').val(),
					invitees: Reminders.getInviteesData(e)
				});
			});
			document.EditView.reminders_data.value = JSON.stringify(reminders);
			console.log('created state:');
			console.log(JSON.stringify(reminders));
		},
		
		init: function(data) {
			if(data) {
				$.each(data, function(i,e){
					Reminders.addReminder(false, e.popup, e.email, e.duration, e.id, e.invitees);
				});
			}
			Reminders.createRemindersPostData();
		},

		onPopupChkboxClick: function(e) {
			Reminders.createRemindersPostData();
		},

		onEmailChkboxClick: function(e) {
			Reminders.createRemindersPostData();
		},

		onDurationSelChange: function(e) {
			Reminders.createRemindersPostData();
		},

	};


	$(function(){
		console.log('server stored state:');
		console.log('{/literal}{$remindersDataJson}{literal}');
		Reminders.init({/literal}{$remindersDataJson}{literal});
		
		$('#reminder_add_btn').click(function(){
			Reminders.onAddClick(this);
		});
	});

</script>
{/literal}