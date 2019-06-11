<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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



$viewdefs['Schedulers']['EditView'] = array(
    'templateMeta' => array(
                            'maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30'),
                                           ),
                            'includes'=> array(
                                            array('file'=>'modules/Schedulers/Schedulers.js'),
                                         ),
                           ),

    'panels' => array(
            'default'=>array(
                           array('name', 'status'),
                           array('job_function', "job_url"),
                           array('adv_interval'),
                           array(array('name'=>'job_interval', 'label' => 'LBL_INTERVAL', 'customCode'=>'
				<div id="job_interval_advanced">
				<script>
					var adv_interval = {$adv_interval};
				</script>
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td>{$MOD.LBL_MINS}</td>
						<td>{$MOD.LBL_HOURS}</td>
						<td>{$MOD.LBL_DAY_OF_MONTH}</td>
						<td>{$MOD.LBL_MONTHS}</td>
						<td>{$MOD.LBL_DAY_OF_WEEK}</td>
					</tr><tr>
						<td><input name="mins" maxlength="25" type="text" size="3" value="{$mins}"></td>
						<td><input name="hours" maxlength="25" type="text" size="3" value="{$hours}"></td>
						<td><input name="day_of_month" maxlength="25" type="text" size="3" value="{$day_of_month}"></td>
						<td><input name="months" maxlength="25" type="text" size="3" value="{$months}"></td>
						<td><input name="day_of_week" maxlength="25" type="text" size="3" value="{$day_of_week}"></td>
					</tr><tr>
						<td colspan="5">
							<em>{$MOD.LBL_CRONTAB_EXAMPLES}</em>
						</td>
					</tr>
				</table>
				</div>
				')),
                array(array('name'=>'job_interval', 'label' => 'LBL_INTERVAL','customCode'=>'
				<div id="job_interval_basic">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td valign="top" width="25%">
							&nbsp;{$MOD.LBL_EVERY}&nbsp;
							<select name="basic_interval">{html_options options=$basic_intervals selected=$basic_interval}</select>&nbsp;
							<select name="basic_period">{html_options options=$basic_periods selected=$basic_period}</select>
						</td>
						<td valign="top" width="25%">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td><span><input type="checkbox" name="all" value="true" id="all" {$ALL} onClick="allDays();">&nbsp;<i>{$MOD.LBL_ALL}</i></span></td>
							</tr>
							<tr>
								<td><span><input type="checkbox" name="mon" value="true" id="mon" {$MON}>&nbsp;{$MOD.LBL_MON}</span></td>
							</tr>
							<tr>
								<td><span><input type="checkbox" name="tue" value="true" id="tue"  {$TUE}>&nbsp;{$MOD.LBL_TUE}</span></td>
							</tr>
							<tr>
								<td><span><input type="checkbox" name="wed" value="true" id="wed"  {$WED}>&nbsp;{$MOD.LBL_WED}</span></td>
							</tr>
						</table>
						</td>

						<td valign="top" width="25%">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td><span><input type="checkbox" name="thu" value="true" id="thu"  {$THU}>&nbsp;{$MOD.LBL_THU}</span></td>
							</tr>
							<tr>
								<td><span><input type="checkbox" name="fri" value="true" id="fri"  {$FRI}>&nbsp;{$MOD.LBL_FRI}</span></td>
							</tr>
							<tr>
								<td><span><input type="checkbox" name="sat" value="true" id="sat"  {$SAT}>&nbsp;{$MOD.LBL_SAT}</span></td>
							</tr>
							<tr>
								<td><span><input type="checkbox" name="sun" value="true" id="sun"  {$SUN}>&nbsp;{$MOD.LBL_SUN}</span></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
				</div>
				'))
                           ),
            'lbl_adv_options'=>array(
                            array(array('name' => 'catch_up', 'prefix' => '{sugar_help text=$MOD.LBL_CATCH_UP_WARNING}')),
                               array('date_time_start','time_from'),
                               array('date_time_end','time_to'),
                               ),
    ),

);
