{*
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 *}

{literal}
	<style>
		#cal-repeat-block table {
			background: transparent;
		}

		.selectize-control {
			width: 290px !important;
		}
	</style>
{/literal}

<h1>{$MOD.LBL_PERIODIC_WORK_CALENDAR_TITLE}</h1>
<br /><br />

<div id="cal-repeat-block">

	<form name="CalendarRepeatForm" id="CalendarRepeatForm" method="POST">
		<input type="hidden" id="module" name="module" value="stic_Work_Calendar">
		<input type="hidden" id="employeeId" name="employeeId" value="{$REQUEST.employeeId}">
		<input type="hidden" id="employeeIds" name="employeeIds" value="{$REQUEST.uid}">
		<input type="hidden" id="action" name="action" value="createPeriodicWorkCalendarRecords">
		<input type="hidden" name="repeat_parent_id">

		<table class="edit view" width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="12.5%" valign="top" scope="row">{$MOD.LBL_TIME_START}:<span
						class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td>
				<td width="37.5%" valign="top">
					<div>
						<input type="text" class="datetimecombo_date" size="11" maxlength="10"
							id="repeat_start_day_input" name="repeat_start_day" value="" required>
						<img border="0" src="index.php?entryPoint=getImage&imageName=jscalendar.gif"
							alt="{$APP.LBL_TIME_START}" id="repeat_start_day_trigger" align="absmiddle">
						<select id="repeat_start_hour" name="repeat_start_hour">{html_options options=$repeat_hours selected="9"}</select>
						<span id="repeat-hours-text"> :</span>
						<select id="repeat_start_minute" name="repeat_start_minute">{html_options options=$repeat_minutes selected="0"}</select>
						<span id="repeat-minutes-text"></span>

						<script type="text/javascript">
							Calendar.setup ({literal}{{/literal}
							inputField: "repeat_start_day_input",
								ifFormat: "%d/%m/%Y",
								daFormat: "%d/%m/%Y",
								button: "repeat_start_day_trigger",
								singleClick: true,
								dateStr: "",
								step: 1,
								startWeekday: {$CALENDAR_FDOW|default:'1'},
								weekNumbers: false
							{literal}}{/literal});
						</script>
					</div>
				</td>
			</tr>

			<tr id='endDateRow'>
				<td width="12.5%" valign="top" scope="row">{$MOD.LBL_TIME_FINAL}:<span
						class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td>
				<td width="37.5%" valign="top">
					<div>
						<input type="text" class="datetimecombo_date" size="11" maxlength="10"
							id="repeat_final_day_input" name="repeat_final_day" value="" required>
						<img border="0" src="index.php?entryPoint=getImage&imageName=jscalendar.gif"
							alt="{$APP.LBL_TIME_FINAL}" id="repeat_final_day_trigger" align="absmiddle">
						<select id="repeat_final_hour" name="repeat_final_hour">{html_options options=$repeat_hours selected="18"}</select>
						<span id="repeat-hours-text">:</span>
						<select id="repeat_final_minute" name="repeat_final_minute">{html_options options=$repeat_minutes selected="0"}</select>
						<span id="repeat-minutes-text"></span>
						<span id="info_hours" style="font-weight:bolder"></span>

						<script type="text/javascript">
							Calendar.setup ({literal}{{/literal}
							inputField: "repeat_final_day_input",
								ifFormat: "%d/%m/%Y",
								daFormat: "%d/%m/%Y",
								button: "repeat_final_day_trigger",
								singleClick: true,
								dateStr: "",
								step: 1,
								startWeekday: {$CALENDAR_FDOW|default:'1'},
								weekNumbers: false
							{literal}}{/literal});
						</script>
					</div>
				</td>
			</tr>
			{if !empty($selectedEmployees)}
				<tr id="assigned_user_row">
					<td width="12.5%" valign="top" scope="row">{$MOD_WORK_CALENDAR.LBL_ASSIGNED_TO}:</td></td>
					<td>
						{foreach from=$selectedEmployees key=k item=name}
							{$name} <br />
						{/foreach}			
					</td>
				</tr>
			{else}
				<tr id="assigned_user_row">
					<td width="12.5%" valign="top" scope="row">{$MOD_WORK_CALENDAR.LBL_ASSIGNED_TO}:<span
							class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td>
					<td width="37.5%" valign="top">
						<input style="width: 210px" type='text' class='sqsEnabled yui-ac-input assigned_user_data_name'
							name='assigned_user_name' id='assigned_user_name' autocomplete='new-password' value='' title='' required>
						<input type='hidden' name='assigned_user_id' id='assigned_user_id' value=''>
						<span class='id-ff multiple'>
							<button title='SUGAR.language.get("app_strings", "LBL_SELECT_BUTTON_TITLE")' type='button'
								class='button' name='btn_1' onclick='openSelectPopup("Users", "assigned_user")'>
								<span class='suitepicon suitepicon-action-select' /></span>
						</button>
						<button type='button' name='btn_1' class='button lastChild'
							onclick='clearRow(this.form, "assigned_user");'>
							<span class='suitepicon suitepicon-action-clear'></span>
							</span>
					</td>
				</tr>
			{/if}			
			<tr id="type_row">
				<td width="12.5%" valign="top" scope="row">{$MOD_WORK_CALENDAR.LBL_TYPE}:<span
						class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td></td>
				<td width="37.5%" valign="top">
					<select class='sqsEnabled' name='type' id='type' value='' title=''  required>
						{html_options options=$TYPE}
				</td>
			</tr>
			<tr id="description_row">
				<td width="12.5%" valign="top" scope="row">
					{$MOD_WORK_CALENDAR.LBL_DESCRIPTION}:
				</td>
				<td width="37.5%" valign="top">
					<textarea style="width: 290px; resize: 'both';" rows="4" cols="50" name='description' id='description' value='' title=''></textarea>
				</td>
			</tr>					
			<tr>
				<td width="12.5%" valign="top" scope="row">{$MOD.LBL_REPEAT_TYPE}:</td>
				<td width="37.5%" valign="top">
					<select name="repeat_type"
						onchange="toggle_repeat_type();">{html_options options=$APPLIST.repeat_type_dom}</select>
				</td>
			</tr>

			<tr id="repeat_interval_row" style="display: none;">
				<td width="12.5%" valign="top" scope="row">{$MOD.LBL_REPEAT_INTERVAL}:</td>
				<td width="37.5%" valign="top">
					<select name="repeat_interval">{html_options options=$repeat_intervals selected="1"}</select> <span
						id="repeat-interval-text"></span>
				</td>
			</tr>

			<tr id="repeat_end_row" style="display: none;">
				<td width="12.5%" valign="top" scope="row">{$MOD.LBL_REPEAT_END}:</td>
				<td width="37.5%" valign="top">
					<div>
						<input type="radio" name="repeat_end_type" value="number" id="repeat_count_radio" checked
							onclick="toggle_repeat_end();" style="position: relative; top: -5px;">
						{$MOD.LBL_REPEAT_END_AFTER}
						<input type="number" size="3" name="repeat_count" value="1"> {$MOD.LBL_REPEAT_OCCURRENCES}
					</div>

					<div>
						<input type="radio" name="repeat_end_type" id="repeat_until_radio" value="date"
							onclick="toggle_repeat_end();" style="position: relative; top: -5px;">
						{$MOD.LBL_REPEAT_END_BY}
						<input type="text" class="date_input" size="11" maxlength="10" id="repeat_until_input"
							name="repeat_until" value="" disabled>
						<img border="0" src="index.php?entryPoint=getImage&imageName=jscalendar.gif"
							alt="{$APP.LBL_ENTER_DATE}" id="repeat_until_trigger" align="absmiddle"
							style="display: none;">

						<script type="text/javascript">
							Calendar.setup ({literal}{{/literal}
							inputField: "repeat_until_input",
								ifFormat: "%d/%m/%Y",
								daFormat: "%d/%m/%Y",
								button: "repeat_until_trigger",
								singleClick: true,
								dateStr: "",
								step: 1,
								startWeekday: {$CALENDAR_FDOW|default:'1'},
								weekNumbers: false
							{literal}}{/literal});
						</script>
					</div>
				</td>
			</tr>

			<tr id="repeat_dow_row" style="display: none;">
				<td width="12.5%" valign="top" scope="row">{$MOD.LBL_REPEAT_DOW}:</td>
				<td width="37.5%" valign="top">
					{foreach name=dow from=$dow key=i item=d}
						{$d.label} <input type="checkbox" name="repeat_dow_{$d.index}" id="repeat_dow[]"
							style="margin-right: 10px;">
					{/foreach}
				</td>
			</tr>
		</table>
		<div id="cal-edit-buttons" class="ft">
			<input class="button" type="submit" name="button" value="{$MOD.LBL_SAVE_BUTTON}">
			<input class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?module=stic_Work_Calendar&action=index'); return false;"
				type="submit" name="button" value="{$MOD.LBL_CANCEL_BUTTON}">
		</div>
	</form>
</div>

<script type="text/javascript">
	{literal}
		var allDayTypes = ['vacation', 'holiday', 'personal', 'sick', 'leave'];
		var type = document.getElementById("type");

		// Store default values in previous values
		var previousType = type.value;
		var previousStartDateHours = "09";
		var previousStartDateMinutes = "00";
		var previousEndDateHours = "18";
		var previousEndDateMinutes = "00";

		type.addEventListener("change", function() 
		{
			// Elements
			repeatStartHour = document.getElementById('repeat_start_hour');
			repeatStartMinute = document.getElementById('repeat_start_minute');
			repeatFinalHour = document.getElementById('repeat_final_hour');
			repeatFinalMinute = document.getElementById('repeat_final_minute');

			if (!allDayTypes.includes(type.value)) 
			{
				if (allDayTypes.includes(previousType)) {      // Set the previous values if the previous type was not type: all day
					// Recover previous values
					repeatStartHour.value=previousStartDateHours;
					repeatStartMinute.value=previousStartDateMinutes;
					repeatFinalHour.value=previousEndDateHours;
					repeatFinalMinute.value=previousEndDateMinutes;
					
					// Show fields neccesary with timed type records
					repeatStartHour.style.display='inline-block';
					repeatStartMinute.style.display='inline-block';
					document.getElementById('repeat-hours-text').style.display='inline-block';
					document.getElementById('endDateRow').style.display='table-row';

				}
			} 
			else 
			{    
				if (!allDayTypes.includes(previousType)) {   
					// Store in previous values
					previousStartDateHours = repeatStartHour.value;
					previousStartDateMinutes = repeatStartMinute.value;
					previousEndDateHours = repeatFinalHour.value;
					previousEndDateMinutes = repeatFinalMinute.value;

					// Set all day values
					repeatStartHour.value='0';
					repeatStartMinute.value='0';
					repeatFinalHour.value='0';
					repeatFinalMinute.value='0';
					
					// Hide fields not neccesary with all day type records
					repeatStartHour.style.display='none';
					repeatStartMinute.style.display='none';
					document.getElementById('repeat-hours-text').style.display='none';
					document.getElementById('endDateRow').style.display='none';
				}
			}
			previousType = type.value;
		});


		// Filters array
		relatedFields = {
			'stic_Work_Calendar_assigned_user': {
				elementId: 'assigned_user',
				module: 'Users',
			},
		};

		// The SQS functions add the autocompletion functionality for the related input records
		if (typeof sqs_objects == 'undefined') {
			var sqs_objects = new Array;
		}

		for (var key in relatedFields) {
			sqs_objects["CalendarRepeatForm_" + relatedFields[key].elementId + "_name"] = {
				id: relatedFields[key].elementId,
				form: "CalendarRepeatForm",
				method: "query",
				modules: [relatedFields[key].module],
				group: "or",
				field_list: ["name", "id"],
				populate_list: [relatedFields[key].elementId + "_name", relatedFields[key].elementId + "_id"],
				conditions: [{
					name: "name",
					op: "like_custom",
					begin: "%",
					end: "%",
					value: "",
				}, ],
				order: "name",
				limit: "30",
				no_match_text: "No Match",
			};
			QSProcessedFieldsArray["CalendarRepeatForm_" + relatedFields[key].elementId + "_name"] = false;
		}

		SUGAR.util.doWhen(
			"typeof(sqs_objects) != 'undefined'",
			enableQS
		);
		// callback function used in the Popup that select employees/users
		function openSelectPopup(module, field) {
			var popupRequestData = {
				call_back_function: "callbackSelectPopup",
				form_name: "CalendarRepeatForm",
				field_to_name_array: {
					id: field + "_id",
					name: field + "_name",
				},
			};
			open_popup(module, 600, 400, "", true, false, popupRequestData);
		}

		var fromPopupReturn = false;
		// callback function used after the Popup that select events
		function callbackSelectPopup(popupReplyData) {
			fromPopupReturn = true;
			var nameToValueArray = popupReplyData.name_to_value_array;
			// It fills the data of the events
			Object.keys(nameToValueArray).forEach(function(key, index) {
				$('#' + key).val(nameToValueArray[key]);
			}, nameToValueArray);
		}

		// Clear related field
		function clearRow(form, field) {
			SUGAR.clearRelateField(form, field + '_name', field + '_id');
		}

		function toggle_repeat_type() {

			if (typeof validate != "undefined" && typeof validate['CalendarRepeatForm'] != "undefined")
				validate['CalendarRepeatForm'] = undefined;

			if (document.forms['CalendarRepeatForm'].repeat_type.value == "") {
				document.getElementById("repeat_interval_row").style.display = "none";
				document.getElementById("repeat_end_row").style.display = "none";
			} else {
				document.getElementById("repeat_interval_row").style.display = "";
				document.getElementById("repeat_end_row").style.display = "";
				toggle_repeat_end();
			}

			var repeat_dow_row = document.getElementById("repeat_dow_row");
			if (document.forms['CalendarRepeatForm'].repeat_type.value == "Weekly") {
				repeat_dow_row.style.display = "";
			} else {
				repeat_dow_row.style.display = "none";
			}

			var intervalTextElm = document.getElementById('repeat-interval-text');
			if (intervalTextElm && typeof SUGAR.language.languages.app_list_strings['repeat_intervals'] != 'undefined') {
				intervalTextElm.innerHTML = SUGAR.language.languages.app_list_strings['repeat_intervals'][document.forms[
					'CalendarRepeatForm'].repeat_type.value];
			}
		}

		function toggle_repeat_end() {
			if (document.getElementById("repeat_count_radio").checked) {
				document.forms['CalendarRepeatForm'].repeat_until.setAttribute("disabled", "disabled");
				document.forms['CalendarRepeatForm'].repeat_count.removeAttribute("disabled");
				document.getElementById("repeat_until_trigger").style.display = "none";

				if (typeof validate != "undefined" && typeof validate['CalendarRepeatForm'] != "undefined") {
					removeFromValidate('CalendarRepeatForm', 'repeat_until');
				}
				addToValidateMoreThan('CalendarRepeatForm', 'repeat_count', 'int', true,'{/literal}{$MOD.LBL_REPEAT_COUNT}{literal}', 1);
			} else {
				document.forms['CalendarRepeatForm'].repeat_count.setAttribute("disabled", "disabled");
				document.forms['CalendarRepeatForm'].repeat_until.removeAttribute("disabled");
				document.getElementById("repeat_until_trigger").style.display = "";

				if (typeof validate != "undefined" && typeof validate['CalendarRepeatForm'] != "undefined") {
					removeFromValidate('CalendarRepeatForm', 'repeat_count');
				}
				addToValidate('CalendarRepeatForm', 'repeat_until', 'date', true,'{/literal}{$MOD.LBL_REPEAT_UNTIL}{literal}');
			}

			// prevent an issue when a calendar date picker is hidden under a dialog
			var editContainer = document.getElementById('cal-edit_c');
			if (editContainer) {
				var pickerContainer = document.getElementById('container_repeat_until_trigger_c');
				if (pickerContainer) {
					pickerContainer.style.zIndex = editContainer.style.zIndex + 1;
				}
			}
		}


		// added feedback to date and hours select
		function setHoursInfo() 
		{
			var start = $('#repeat_start_day_input').val() + '/' + $('[name=repeat_start_hour]').val() + '/' + $(
				'[name=repeat_start_minute]').val()
			start = start.split('/')
			var start = new Date(start[2], start[1], start[0], start[3], start[4]);
			var final = $('#repeat_final_day_input').val() + '/' + $('[name=repeat_final_hour]').val() + '/' + $(
				'[name=repeat_final_minute]').val()
			final = final.split('/')
			var final = new Date(final[2], final[1], final[0], final[3], final[4]);
			var difference = final.getTime() - start.getTime();
			if (difference <= 0) {
				$('#info_hours').html("<span style='color:red;display:inline-block;'>ERROR. " + SUGAR.language.get('stic_Work_Calendar', 'LBL_END_DATE_ERROR') + "</span>")
				return;
			}
			if ((difference / 3600000) > 24) {
				$('#info_hours').html("<span style='color:red;display:inline-block;'>ERROR. " + SUGAR.language.get('stic_Work_Calendar', 'LBL_END_DATE_EXCEEDS_24_HOURS') + "</span>")
				return;
			}
			var minutes = Math.round(difference / 60000);
			var hours = Math.floor((parseInt(minutes) / 60))
			var minutes = (parseInt(minutes) % 60)
			hours = parseInt(hours) < 10 ? '0' + hours : hours
			minutes = parseInt(minutes) < 10 ? '0' + minutes : minutes
			$('#info_hours').text(SUGAR.language.get('stic_Work_Calendar', 'LBL_WORK_CALENDAR_DURATION') + ': ' + hours + 'h ' + minutes + '\'')
		}

		document.getElementById("CalendarRepeatForm").addEventListener("submit", function(event) {
			if (!allDayTypes.includes(type.value) && $('#info_hours').text().includes('ERROR')) {
				event.preventDefault();
				alert(SUGAR.language.get('stic_Work_Calendar', 'LBL_ERROR_IN_VALIDATION'));
			}
		});

		$('[name=repeat_start_hour]').off('change')
		$('[name=repeat_start_hour],[name=repeat_final_hour],[name=repeat_start_minute],[name=repeat_final_minute]').on(
			'change',
			function() {
				setHoursInfo();

			})
		var currentStartDate = $('#repeat_start_day_input').val();
		$('BODY').on('click', '#container_repeat_start_day_trigger a', function() {
			$('#repeat_final_day_input').val($('#repeat_start_day_input').val());
			setHoursInfo();
		})

		$('BODY').on('click', '#container_repeat_final_day_trigger a', function() {
			setHoursInfo();
		})

		$('#repeat_start_day_input,#repeat_final_day_input').on('change', function() {
			setHoursInfo();
		})

		$('#repeat_start_day_input').val(new Date().toLocaleDateString());
		$('#repeat_final_day_input').val(new Date().toLocaleDateString());

		setHoursInfo()
	{/literal}
</script>