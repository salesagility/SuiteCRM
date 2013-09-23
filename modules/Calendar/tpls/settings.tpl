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

<script type="text/javascript">
{literal}
function toggleDisplayTimeslots() {
	if (document.getElementById('display_timeslots').checked) {
		$(".time_range_options_row").css('display', '');
	} else {
		$(".time_range_options_row").css('display', 'none');
	}
}

$(function() {
	toggleDisplayTimeslots();
});

{/literal}
</script>

<div id="settings_dialog" style="width: 450px; display: none;">
	<div class="hd">{$MOD.LBL_SETTINGS_TITLE}</div>
	<div class="bd">
	<form name="settings" id="form_settings" method="POST" action="index.php?module=Calendar&action=SaveSettings">
		<input type="hidden" name="view" value="{$view}">
		<input type="hidden" name="day" value="{$day}">
		<input type="hidden" name="month" value="{$month}">
		<input type="hidden" name="year" value="{$year}">
		
		<table class='edit view tabForm'>
				<tr>
					<td scope="row" valign="top" width="55%">
						{$MOD.LBL_SETTINGS_DISPLAY_TIMESLOTS}
					</td>
					<td width="45%">	
						<input type="hidden" name="display_timeslots" value="">
						<input type="checkbox" id="display_timeslots" name="display_timeslots" {if $display_timeslots}checked{/if} value="1" tabindex="102" onchange="toggleDisplayTimeslots();">
					</td>
				</tr>
				<tr class="time_range_options_row">
					<td scope="row" valign="top">
						{$MOD.LBL_SETTINGS_TIME_STARTS}
					</td>
					<td>
						<div id="d_start_time_section">
							<select size="1" id="day_start_hours" name="day_start_hours" tabindex="102">
								{$TIME_START_HOUR_OPTIONS}
							</select>&nbsp;:
							
							<select size="1" id="day_start_minutes" name="day_start_minutes"  tabindex="102">
								{$TIME_START_MINUTES_OPTIONS}
							</select>
								&nbsp;
							{$TIME_START_MERIDIEM}
						</div>
					</td>
				</tr>
				<tr class="time_range_options_row">
					<td scope="row" valign="top">
						{$MOD.LBL_SETTINGS_TIME_ENDS}
					</td>
					<td>
						<div id="d_end_time_section">
							<select size="1" id="day_end_hours" name="day_end_hours" tabindex="102">
								{$TIME_END_HOUR_OPTIONS}
							</select>&nbsp;:
							
							<select size="1" id="day_end_minutes" name="day_end_minutes"  tabindex="102">
								{$TIME_END_MINUTES_OPTIONS}
							</select>
								&nbsp;
							{$TIME_END_MERIDIEM}
						</div>
					</td>
				</tr>
				<tr>
					<td scope="row" valign="top">
						{$MOD.LBL_SETTINGS_CALLS_SHOW}
					</td>
					<td>	
						<select size="1" name="show_calls" tabindex="102">
							<option value='' {if !$show_calls}selected{/if}>{$MOD.LBL_NO}</option>
							<option value='true' {if $show_calls}selected{/if}>{$MOD.LBL_YES}</option>								
						</select>
					</td>
				</tr>
				<tr>
					<td scope="row" valign="top">
						{$MOD.LBL_SETTINGS_TASKS_SHOW}
					</td>
					<td>	
						<select size="1" name="show_tasks" tabindex="102">
							<option value='' {if !$show_tasks}selected{/if}>{$MOD.LBL_NO}</option>
							<option value='true' {if $show_tasks}selected{/if}>{$MOD.LBL_YES}</option>								
						</select>
					</td>
				</tr>
				<tr>
					<td scope="row" valign="top">
						{$MOD.LBL_SETTINGS_COMPLETED_SHOW}
					</td>
					<td>	
						<select size="1" name="show_completed" tabindex="102">
							<option value='' {if !$show_completed}selected{/if}>{$MOD.LBL_NO}</option>
							<option value='true' {if $show_completed}selected{/if}>{$MOD.LBL_YES}</option>								
						</select>
					</td>
				</tr>
		</table>
	</form>
	
	
	<div style="text-align: right;">
		<button id="btn-save-settings" class="button" type="button">{$MOD.LBL_APPLY_BUTTON}</button>&nbsp;
		<button id="btn-cancel-settings" class="button" type="button">{$MOD.LBL_CANCEL_BUTTON}</button>&nbsp;
	</div>
	</div>
</div>
