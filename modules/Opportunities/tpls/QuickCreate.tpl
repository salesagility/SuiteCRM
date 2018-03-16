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


<form name="opportunitiesQuickCreate" id="opportunitiesQuickCreate" method="POST" action="index.php">
<input type="hidden" name="module" value="Opportunities">
<input type="hidden" name="record" value="">
<input type="hidden" name="contact_id" value="{$REQUEST.contact_id}">
<input type="hidden" name="contact_name" value="{$REQUEST.contact_name}">
<input type="hidden" name="email_id" value="{$REQUEST.email_id}">
<input type="hidden" name="return_action" value="{$REQUEST.return_action}">
<input type="hidden" name="return_module" value="{$REQUEST.return_module}">
<input type="hidden" name="return_id" value="{$REQUEST.return_id}">
<input type="hidden" name="action" value='Save'>
<input type="hidden" name="duplicate_parent_id" value="{$REQUEST.duplicate_parent_id}">
<input name='currency_id' type='hidden' value='{$CURRENCY_ID}'>
<input id='assigned_user_id' name='assigned_user_id' type="hidden" value="{$ASSIGNED_USER_ID}" />
<input type="hidden" name="to_pdf" value='1'>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td align="left" style="padding-bottom: 2px;">
		<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" type="submit" name="button" {$saveOnclick|default:"onclick=\"return check_form('OpportunitiesQuickCreate');\""} value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " >
		<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" type="submit" name="button" {$cancelOnclick|default:"onclick=\"this.form.action.value='$RETURN_ACTION'; this.form.module.value='$RETURN_MODULE'; this.form.record.value='$RETURN_ID'\""} value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  ">
		<input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" accessKey="{$APP.LBL_FULL_FORM_BUTTON_KEY}" class="button" type="submit" name="button" onclick="this.form.to_pdf.value='0';this.form.action.value='EditView'; this.form.module.value='Opportunities';" value="  {$APP.LBL_FULL_FORM_BUTTON_LABEL}  "></td>
	<td align="right" nowrap><span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span> {$APP.NTC_REQUIRED}</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
<tr>
<td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="15%" scope="row"><span>{$MOD.LBL_OPPORTUNITY_NAME} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
	<td width="35%" ><span><input name='name' type="text" tabindex='1' size='35' maxlength='50' value=""></span></td>
	<td width="20%" scope="row"><span>{$MOD.LBL_AMOUNT} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
	<td width="30%" ><span><input name='amount' tabindex='2' size='15' maxlength='25' type="text" value=''></span></td>
	</tr><tr>
	<td scope="row"><span>{$MOD.LBL_DATE_CLOSED}&nbsp;<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
	<td ><span><input name='date_closed' onblur="parseDate(this, '{$CALENDAR_DATEFORMAT}');" id='jscal_field' type="text" tabindex='1' size='11' maxlength='10' value=""> <span id="jscal_trigger" class="suitepicon suitepicon-module-calendar"></span> <span class="dateFormat">{$USER_DATEFORMAT}</span></span></td>
	<td scope="row"><span>{$MOD.LBL_LEAD_SOURCE}</span></td>
	<td ><span><select tabindex='2' name='lead_source'>{$LEAD_SOURCE_OPTIONS}</select></span></td>
	</tr>
	<tr>
	<td scope="row"><span>{$MOD.LBL_SALES_STAGE} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
	<td ><span><select tabindex='1' name='sales_stage' id='opportunities_sales_stage'>{$SALES_STAGE_OPTIONS}</select></span></td>
	<td scope="row"><span>{$MOD.LBL_PROBABILITY}</span></td>
	<td ><span><input name='probability' id='opportunities_probability' tabindex='2' size='4' maxlength='3' type="text" value=''></span></td>
	</tr><tr>
	<td scope="row"><span>{$MOD.LBL_ACCOUNT_NAME} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
	<td ><span>{$REQUEST.parent_name}<input id='account_name' name='account_name' type="hidden" value='{$REQUEST.parent_name}'><input id='account_id' name='account_id' type="hidden" value='{$REQUEST.parent_id}'>&nbsp;</span></td>
	<td></td>
	<td></td>
	</tr>
</table>
</span></td></tr></table>
	</form>
<script>
{literal}
	Calendar.setup ({
		inputField : "jscal_field", ifFormat : "{/literal}{$CALENDAR_DATEFORMAT}{literal}", showsTime : false, button : "jscal_trigger", singleClick : true, step : 1, weekNumbers:false
	});
	prob_array = {/literal}{$prob_array}{literal}
	document.getElementById('opportunities_sales_stage').onchange = function() {
			if(typeof(document.getElementById('opportunities_sales_stage').value) != "undefined" && prob_array[document.getElementById('opportunities_sales_stage').value]) {
				document.getElementById('opportunities_probability').value = prob_array[document.getElementById('opportunities_sales_stage').value];
			} 
		};
{/literal}

	{$additionalScripts}
</script>