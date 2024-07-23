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

<script type="text/javascript">
	var minutesInterval={$minutes_interval};
</script>

<table width="100%">
	<tr>
		{*TÍTOL*} <th style="text-align:left">
			<h2>{$MOD.LBL_TITLE}</h2>
		</th>
	</tr>
</table>
<br>
<div id="edit_all_recurrences_block" style="display: none;">
	<button type="button" id="btn-edit-all-recurrences" onclick="CAL.edit_all_recurrences();">
		{$MOD.LBL_EDIT_ALL_RECURRENCES} </button>
	<button type="button" id="btn-remove-all-recurrences" onclick="CAL.remove_all_recurrences();">
		{$MOD.LBL_REMOVE_ALL_RECURRENCES} </button>
</div>

<div id="cal-repeat-block">

	<form name="CalendarRepeatForm" id="CalendarRepeatForm" method="POST">
		<input type="hidden" id="module" name="module" value="stic_Events">
		<input type="hidden" id="event_id" name="event_id" value="{$REQUEST.event_id}">
		<input type="hidden" id="action" name="action" value="createPeriodicSessions">
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
						<select name="repeat_start_hour">{html_options options=$repeat_hours selected="9"}</select>
						<span id="repeat-hours-text"></span> :
						<select name="repeat_start_minute">{html_options options=$repeat_minutes selected="0"}</select>
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

			<tr>
				<td width="12.5%" valign="top" scope="row">{$MOD.LBL_TIME_FINAL}:<span
						class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td>
				<td width="37.5%" valign="top">
					<div>
						<input type="text" class="datetimecombo_date" size="11" maxlength="10"
							id="repeat_final_day_input" name="repeat_final_day" value="" required>
						<img border="0" src="index.php?entryPoint=getImage&imageName=jscalendar.gif"
							alt="{$APP.LBL_TIME_FINAL}" id="repeat_final_day_trigger" align="absmiddle">
						<select name="repeat_final_hour">{html_options options=$repeat_hours selected="0"}</select>
						<span id="repeat-hours-text"></span> :
						<select name="repeat_final_minute">{html_options options=$repeat_minutes selected="0"}</select>
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
						<input type="number" size="3" name="repeat_count" value="10"> {$MOD.LBL_REPEAT_OCCURRENCES}
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
		<table class="edit view" border="0" cellpadding="0" cellspacing="0" width="50%">
			<tr id="enable_fields_row">
				<td width="12.5%" valign="top" scope="row">
					{$MOD.LBL_SESSION_ENABLE_FIELDS}
					<span id="session_enable_fields_info" style='position: relative;'
						class="inline-help glyphicon glyphicon-info-sign"></span>
					:
				</td>
				<td width="37.5%" valign="top">
					<input type="checkbox" id="enable_fields">
				</td>
			</tr>
			<tr id="session_name_row">
				<td width="12.5%" valign="top" scope="row">
					{$MOD_SESSION.LBL_NAME}
					<span id="session_name_info" style='position: relative;'
						class="inline-help glyphicon glyphicon-info-sign"></span>
					:
				</td>
				<td width="37.5%" valign="top">
					<input style="width: 290px" type='text' name='session_name' id='session_name' value='' title=''>
				</td>
			</tr>
			<tr id="activity_type_row">
				<td width="12.5%" valign="top" scope="row">{$MOD_SESSION.LBL_ACTIVITY_TYPE}:</td>
				<td width="37.5%" valign="top">
					<select multiple=true class='sqsEnabled' name='activity_type[]' id='activity_type' value=''
						title=''>
						{html_options options=$ACTIVITY_TYPE}
				</td>
			</tr>
			<tr id="color_row">
				<td width="12.5%" valign="top" scope="row">
					{$MOD_SESSION.LBL_COLOR}
					<span id="session_color_empty_info" style='position: relative;'
						class="inline-help glyphicon glyphicon-info-sign"></span>
					:
				</td>
				<td width="37.5%" valign="top">
					<select class='sqsEnabled' name='color' id='color' value='' title=''>
						{html_options options=$COLOR}
				</td>
			</tr>
			<tr id="responsible_row">
				<td width="12.5%" valign="top" scope="row">{$MOD_SESSION.LBL_STIC_RESPONSIBLE}:</td>
				<td width="37.5%" valign="top">
					<input style="width: 210px" type='text' class='sqsEnabled' name='responsible_name'
						id='responsible_name' autocomplete='new-password' value='' title=''>
					<input type='hidden' name='responsible_id' id='responsible_id' value=''>
					<span class='id-ff multiple'>
						<button title='SUGAR.language.get("app_strings", "LBL_SELECT_BUTTON_TITLE")' type='button'
							class='button' name='btn_1' onclick='openSelectPopup("Contacts", "responsible")'>
							<span class='suitepicon suitepicon-action-select' /></span>
					</button>
					<button type='button' name='btn_1' class='button lastChild'
						onclick='clearRow(this.form, "responsible");'>
						<span class='suitepicon suitepicon-action-clear'></span>
						</span>
				</td>
			</tr>
			<tr id="assigned_user_row">
				<td width="12.5%" valign="top" scope="row">{$MOD_SESSION.LBL_ASSIGNED_TO}:</td>
				<td width="37.5%" valign="top">
					<input style="width: 210px" type='text' class='sqsEnabled yui-ac-input assigned_user_data_name'
						name='assigned_user_name' id='assigned_user_name' autocomplete='new-password' value='' title=''>
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
			<tr id="description_row">
				<td width="12.5%" valign="top" scope="row">
					{$MOD_SESSION.LBL_DESCRIPTION}:
				</td>
				<td width="37.5%" valign="top">
					<textarea style="width: 290px; resize: 'both';" rows="4" cols="50" name='description' id='description' value='' title=''></textarea>
				</td>
			</tr>		
		</table>
		<div id="cal-edit-buttons" class="ft">
			<input title="grabar" class="button" type="submit" name="button" value="{$MOD.LBL_SAVE_BUTTON}">
			<input title="Enrera" class="button"
				onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module=stic_Events'); return false;"
				type="submit" name="button" value="{$MOD.LBL_CANCEL_BUTTON}">
		</div>
	</form>
</div>

<script type="text/javascript">
	{literal}

		addQtipFunctionality('#session_enable_fields_info', 'stic_Events', 'LBL_SESSION_ENABLE_FIELDS_INFO');
		addQtipFunctionality('#session_name_info', 'stic_Events', 'LBL_SESSION_NAME_INFO');
		addQtipFunctionality('#session_color_empty_info', 'stic_Events', 'LBL_SESSION_COLOR_EMPTY_INFO');


		buildEditableColorFieldSelectize('color');
		$(document).ready(function() {
			$('#activity_type').selectize();
			$("#session_name_row").hide();
			$("#assigned_user_row").hide();
			$("#responsible_row").hide();
			$("#activity_type_row").hide();
			$("#color_row").hide();
			$("#description_row").hide();
			$("#enable_fields").on("change", function() {
				if ($(this).is(":checked")) {
					$("#session_name_row").show();
					$("#assigned_user_row").show();
					$("#activity_type_row").show();
					$("#color_row").show();
					$("#responsible_row").show();
					$("#description_row").show();
				} else {
					$("#session_name_row").hide();
					$("#assigned_user_row").hide();
					$("#activity_type_row").hide();
					$("#color_row").hide();
					$("#responsible_row").hide();
					$("#description_row").hide();

					$('#session_name').val('');
					$('#description').val('');
					$('#color')[0].selectize.clear();
					$('#activity_type')[0].selectize.clear();
					clearRow(this.form, "responsible");
					clearRow(this.form, "assigned_user")
				}
			});
		});
		// Filters array
		relatedFields = {
			'stic_Sessions_responsible': {
				elementId: 'responsible',
				module: 'Contacts',
			},
			'stic_Sessions_assigned_user': {
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
		// callback function used in the Popup that select events
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
		function setHoursInfo() {

			var start = $('#repeat_start_day_input').val() + '/' + $('[name=repeat_start_hour]').val() + '/' + $(
				'[name=repeat_start_minute]').val()
			start = start.split('/')
			var start = new Date(start[2], start[1], start[0], start[3], start[4] * minutesInterval);
			var final = $('#repeat_final_day_input').val() + '/' + $('[name=repeat_final_hour]').val() + '/' + $(
				'[name=repeat_final_minute]').val()
			final = final.split('/')
			var final = new Date(final[2], final[1], final[0], final[3], final[4] * minutesInterval);
			var difference = final.getTime() - start.getTime();
			if (difference <= 0) {
				$('#info_hours').html("<span style='color:red;display:inline-block;'>Error! </span>")
				return;
			}
			var minutes = Math.round(difference / 60000);
			var hours = Math.floor((parseInt(minutes) / 60))
			var minutes = (parseInt(minutes) % 60)
			hours = parseInt(hours) < 10 ? '0' + hours : hours
			minutes = parseInt(minutes) < 10 ? '0' + minutes : minutes
			$('#info_hours').text(SUGAR.language.get('stic_Events', 'LBL_SESSION_DURATION') + ': ' + hours + 'h ' + minutes +
				'\'')

		}

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
		$('[name=repeat_final_hour]').val('10');

		setHoursInfo()
	{/literal}
</script>