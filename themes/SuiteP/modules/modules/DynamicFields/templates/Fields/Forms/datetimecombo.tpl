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

{include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}
{literal}
<script language="Javascript">
	function timeValueUpdate(){
		var fieldname = 'defaultTime';
		var timeseparator = ':';
		var newtime = '';
		
		id = fieldname + '_hours';
		h = window.document.getElementById(id).value;
		id = fieldname + '_minutes';
		m = window.document.getElementById(id).value;
		
		id = fieldname + '_meridiem';
		ampm = '';
		if(document.getElementById(id)) {
		   ampm = document.getElementById(id).value;
		}
		newtime = h + timeseparator + m + ampm;
		document.getElementById(fieldname).value = newtime;
		
	}
</script>
{/literal}
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}:</td>
	<td>
	{if $hideLevel < 5}
		{html_options name='defaultDate' id='defaultDate_date' options=$default_values selected=$default_date}
	{else}
		<input type='hidden' name='defaultDate' value='{$default_date}'>{$default_date}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'></td>
	<td>
	{if $hideLevel < 5}
		  <div>
			{html_options name='defaultHours'  size='1' id='defaultTime_hours' options=$default_hours_values onchange="timeValueUpdate();"  selected=$default_hours}
		   :
		 {html_options  name='defaultMinutes'   size='1'  id='defaultTime_minutes' options=$default_minutes_values onchange="timeValueUpdate();"  selected=$default_minutes}
		 {if $show_meridiem === true}
		 {html_options  name='defaultMeridiem'  size='1'  id='defaultTime_meridiem' options=$default_meridiem_values onchange="timeValueUpdate();"  selected=$default_meridiem}
		 {/if}
		</div>
		<input type='hidden' name='defaultTime' id='defaultTime' value="{$defaultTime}">
	{else}
		<input type='hidden' name='defaultTime' id='defaultTime' value='{$defaultTime}'>{$defaultTime}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MASS_UPDATE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type="checkbox" id="massupdate" name="massupdate" value="1" {if !empty($vardef.massupdate)}checked{/if}/>
	{else}
		<input type="checkbox" id="massupdate" name="massupdate" value="1" disabled {if !empty($vardef.massupdate)}checked{/if}/>
	{/if}
	</td>
</tr>
{if $range_search_option_enabled}
<tr>	
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_ENABLE_RANGE_SEARCH"}:</td>
    <td>
        <input type='checkbox' name='enable_range_search' value=1 {if !empty($vardef.enable_range_search) }checked{/if} {if $hideLevel > 5}disabled{/if} />
        {if $hideLevel > 5}<input type='hidden' name='enable_range_search' value='{$vardef.enable_range_search}'>{/if}
    </td>	
</tr>
{/if}
<script>
addToValidateBinaryDependency('popup_form',"defaultDate_date", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_DATE} {$APP.LBL_OR} {$APP.LBL_HOURS}" ,"defaultTime_hours");
addToValidateBinaryDependency('popup_form',"defaultTime_hours", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_HOURS} {$APP.LBL_OR} {$APP.LBL_MINUTES}" ,"defaultTime_minutes");
addToValidateBinaryDependency('popup_form', "defaultTime_minutes", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_MINUTES} {$APP.LBL_OR} {$APP.LBL_MERIDIEM}","defaultTime_meridiem");
</script>
{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}