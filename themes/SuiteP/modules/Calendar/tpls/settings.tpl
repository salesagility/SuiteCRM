{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
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
 */
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
<div class="modal fade modal-calendar-settings" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">{$MOD.LBL_SETTINGS_TITLE}</h4>
			</div>
			<div class="modal-body">
				<!--->
				<div class="container-fluid">
					<form name="settings" id="form_settings" method="POST" action="index.php?module=Calendar&action=SaveSettings">

						<div class="panel panel-default ">
							 <div class="panel-heading  panel-heading-collapse">
								<a id="subpanel_title_activities" class="" role="button" data-toggle="collapse" href="#subpanel_settings_settings">
									<div class="col-xs-10 col-sm-11 col-md-11">
										<div>
											{$MOD.LBL_SETTINGS_TITLE}
										</div>
									</div>
								</a>
							</div>
							<div id="subpanel_settings_settings" class="panel-body panel-collapse collapse in">
								<input type="hidden" name="view" value="{$view}">
								<input type="hidden" name="day" value="{$day}">
								<input type="hidden" name="month" value="{$month}">
								<input type="hidden" name="year" value="{$year}">

								<table class='table-responsive'>
									<tr>
										<td scope="row" valign="top" width="55%">
											{$MOD.LBL_SETTINGS_DISPLAY_TIMESLOTS}
										</td>
										<td width="45%">
											<input type="hidden" name="display_timeslots" value="">
											<input type="checkbox" id="display_timeslots" name="display_timeslots" {if $display_timeslots}checked{/if} value="1" tabindex="102" onchange="toggleDisplayTimeslots();">
										</td>
									</tr>
									<tr>
										<td scope="row" valign="top" width="55%">
											{$MOD.LBL_SETTINGS_DISPLAY_SHARED_CALENDAR_SEPARATE}
										</td>
										<td width="45%">
											<input type="hidden" name="shared_calendar_separate" value="">
											<input type="checkbox" id="shared_calendar_separate" name="shared_calendar_separate" {if $shared_calendar_separate}checked{/if} value="1" tabindex="102" >
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
							</div>
						</div>

						<div class="panel panel-default ">
							<div class="panel-heading panel-heading-collapse">
								<a id="subpanel_title_activities" class="" role="button" data-toggle="collapse" href="#subpanel_settings_color">
									<div class="col-xs-10 col-sm-11 col-md-11">
										<div>
											{$MOD.LBL_COLOR_SETTINGS}
										</div>
									</div>
								</a>
							</div>
							<div id="subpanel_settings_color" class="panel-body panel-collapse collapse in">
								<table class="table-responsive">
									<tr>
										<th>Module</th><th>Body</th><th>Border</th><th>Text</th>
									</tr>
									{foreach from=$activity key=name item=def}
										<tr>
											<td>{$def.label}</td>
											<td>
												<input type="text" id="{$name}" name="activity[{$name}][body]" class="color" value="{$def.body}" size="8" />
											</td>
											<td>
												<input type="text" id="{$name}" name="activity[{$name}][border]" class="color" value="{$def.border}" size="8" />
											</td>
											<td>
												<input type="text" id="{$name}" name="activity[{$name}][text]" class="color" value="{$def.text}" size="8" />
											</td>
										</tr>
									{/foreach}
								</table>
							</div>
						</div>
					</div>
				</form>
				<!--->
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">{$MOD.LBL_CANCEL_BUTTON}</button>
				<button id="btn-save-settings" onclick="$('#form_settings).submit();" class="btn btn-danger" type="button">{$MOD.LBL_APPLY_BUTTON}</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

