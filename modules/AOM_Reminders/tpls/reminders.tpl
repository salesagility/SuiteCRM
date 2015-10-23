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

<div style="display:none;">
	<div id="reminder_template">

		<input type="button" value="Remove reminder [x]" onclick="Reminders.onRemoveClick(this);"><br>
		<label>Actions:</label><br>
		<input type="checkbox" class="popup_chkbox" checked><label>Send invitees a popup or a desktop notification</label><br>
		<input type="checkbox" class="email_chkbox" checked><label>Send invitees an email</label><br>
		<label>When:</label>
		<select tabindex="0" class="duration_sel">
			<option label="1 minute prior" value="60">1 minute prior</option>
			<option label="5 minutes prior" value="300">5 minutes prior</option>
			<option label="10 minutes prior" value="600">10 minutes prior</option>
			<option label="15 minutes prior" value="900">15 minutes prior</option>
			<option label="30 minutes prior" value="1800">30 minutes prior</option>
			<option label="1 hour prior" value="3600">1 hour prior</option>
			<option label="2 hours prior" value="7200">2 hours prior</option>
			<option label="3 hours prior" value="10800">3 hours prior</option>
			<option label="5 hours prior" value="18000">5 hours prior</option>
			<option label="1 day prior" value="86400">1 day prior</option>
		</select>
		<br>
		<ul class="invitees_list"></ul>
		<input type="button" value="[+] Add All Invitees" onclick="Reminders.onAddAllClick(this);"><br>

	</div>
</div>

<div id="reminders">
	<input type="hidden" id="reminders_data" name="reminders_data" />
	<ul id="reminder_view"></ul>
	<input id="reminder_add_btn" type="button" value="Add reminder">
</div>

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

		addReminder: function(e, reminderId, invitees) {
			if(!reminderId) reminderId = '';
			if(!invitees) {
				Reminders.addAllInvitees($('#reminder_template'));
			}
			else {
				Reminders.addInvitees(e, invitees);
			}
			$('#reminder_view').append('<li class="reminder_item" data-reminder-id="' + reminderId + '">' + $('#reminder_template').html() + '</li>');
		},

		onAddClick: function(e){
			Reminders.addReminder(e);
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
			console.log(JSON.stringify(reminders));
		},
		
		init: function(data) {
			$.each(data, function(i,e){
				Reminders.addReminder(false, e.id, e.invitees);
			});
			Reminders.createRemindersPostData();
		},

	};


	$(function(){
		Reminders.init({/literal}{$remindersDataJson}{literal});
		
		$('#reminder_add_btn').click(function(){
			Reminders.onAddClick(this);
		});
	});

</script>
{/literal}