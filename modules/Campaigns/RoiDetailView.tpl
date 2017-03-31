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
<!-- BEGIN: main -->

{$chartResources}
<script>SUGAR.loadChart = true;</script>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
<form action="index.php" method="post" name="DetailView" id="form">
			<input type="hidden" name="module" value="CampaignLog">
			<input type="hidden" name="record" value="{$ID}">
			<input type="hidden" name="isDuplicate" value=false>
			<input type="hidden" name="action">
			<input type="hidden" name="return_module">
			<input type="hidden" name="return_action">
			<input type="hidden" name="return_id" >
			<input type="hidden" name="campaign_id" value="{$ID}">
			<input type="hidden" name="mode" value="">
			<input id="deleteTestEntriesButtonId" title="{$MOD.LBL_TRACK_DELETE_BUTTON_TITLE}" class="button" onclick="this.form.module.value='Campaigns'; this.form.action.value='Delete';this.form.return_module.value='Campaigns'; this.form.return_action.value='TrackDetailView';this.form.mode.value='Test';return confirm('{$MOD.LBL_TRACK_DELETE_CONFIRM}');" type="submit" name="button" value="  {$MOD.LBL_TRACK_DELETE_BUTTON_LABEL}  ">
	</td>
	<td align='right'><span style="{$DISABLE_LINK}" >
		<input type="button" class="button" id="launch_wizard_button" onclick="javascript:window.location='index.php?module=Campaigns&action=WizardHome&record={$ID}';" value="{$MOD.LBL_TO_WIZARD_TITLE}" />
		<input type="button" class="button" id="view_status_button" onclick="javascript:window.location='index.php?module=Campaigns&action=TrackDetailView&record={$ID}';" value="{$MOD.LBL_TRACK_BUTTON_LABEL}" /></SPAN>{$ADMIN_EDIT}
		<input type="button" class="button" id="view_details_button" onclick="javascript:window.location='index.php?module=Campaigns&action=DetailView&record={$ID}';" value="{$MOD.LBL_TODETAIL_BUTTON_LABEL}" />
	</td>
	</form>
	<td align='right'>{$ADMIN_EDIT}</td>
</tr>
</table>
<p>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail view">
<tr>
{$PAGINATION}
	<td width="20%"><span>{$MOD.LBL_NAME}</span></td>
	<td width="30%"><span>{$NAME}</span></td>
	<td width="20%"><span>{$MOD.LBL_ASSIGNED_TO}</span></td>
	<td width="30%"><span>{$ASSIGNED_TO}</span></td>
	</tr><tr>
	<td width="20%"><span>{$MOD.LBL_CAMPAIGN_STATUS}</span></td>
	<td width="30%"><span>{$STATUS}</span></td>
	<td width="20%"><span>&nbsp;</span></td>
	<td width="30%"><span>&nbsp;</span></td>
	</tr><tr>
	<td width="20%"><span>{$MOD.LBL_CAMPAIGN_START_DATE}</span></td>
	<td width="30%"><span>{$START_DATE}</span></td>
	<td ><span>{$APP.LBL_DATE_MODIFIED}&nbsp;</span></td>
	<td ><span>{$DATE_MODIFIED} {$APP.LBL_BY} {$MODIFIED_BY}</span></td>
	</tr><tr>
	<td width="20%"><span>{$MOD.LBL_CAMPAIGN_END_DATE}</span></td>
	<td width="30%"><span>{$END_DATE}</span></td>
	<td ><span>{$APP.LBL_DATE_ENTERED}&nbsp;</span></td>
	<td ><span>{$DATE_ENTERED} {$APP.LBL_BY} {$CREATED_BY}</span></td>
	</tr><tr>
	<td width="20%"><span>{$MOD.LBL_CAMPAIGN_TYPE}</span></td>
	<td width="30%"><span>{$TYPE}</span></td>
	<td width="20%"><span>&nbsp;</span></td>
	<td width="30%"><span>&nbsp;</span></td>
	</tr><tr>
	<td width="20%"><span>&nbsp;</span></td>
	<td width="30%"><span>&nbsp;</span></td>
	<td width="20%"><span>&nbsp;</span></td>
	<td width="30%"><span>&nbsp;</span></td>
	</tr><tr>
	<td width="20%" nowrap><span>{$MOD.LBL_CAMPAIGN_BUDGET} ({$CURRENCY})</span></td>
	<td width="30%"><span>{$BUDGET}</span></td>
	<td width="20%" nowrap><span>{$MOD.LBL_CAMPAIGN_IMPRESSIONS}</span></td>
	<td width="30%" nowrap><span>{$IMPRESSIONS}</span></td>
	</tr><tr>
	<td width="20%" nowrap><span>{$MOD.LBL_CAMPAIGN_EXPECTED_COST} ({$CURRENCY})</span></td>
	<td width="30%"><span>{$EXPECTED_COST}</span></td>
		<td width="20%" nowrap><span>{$MOD.LBL_CAMPAIGN_OPPORTUNITIES_WON}</span></td>
	<td width="30%"><span>{$OPPORTUNITIES_WON}</span></td>
	</tr><tr>
	</tr><tr>
	<td width="20%" nowrap><span>{$MOD.LBL_CAMPAIGN_ACTUAL_COST} ({$CURRENCY})</span></td>
	<td width="30%"><span>{$ACTUAL_COST}</span></td>
	<td width="20%" nowrap><span>{$MOD.LBL_CAMPAIGN_COST_PER_IMPRESSION} ({$CURRENCY})</span></td>
	<td width="30%" nowrap><span>{$COST_PER_IMPRESSION}</span></td>
	</tr><tr>
	<td width="20%" nowrap><span>{$MOD.LBL_CAMPAIGN_EXPECTED_REVENUE} ({$CURRENCY})</span></td>
	<td width="30%" nowrap><span>{$EXPECTED_REVENUE}</span></td>
	<td width="20%" nowrap><span>{$MOD.LBL_CAMPAIGN_COST_PER_CLICK_THROUGH} ({$CURRENCY})</span></td>
	<td width="30%"><span>{$COST_PER_CLICK_THROUGH}</span></td>
	</tr><tr>
	<td width="20%"><span>&nbsp;</span></td>
	<td width="30%"><span>&nbsp;</span></td>
	<td width="20%"><span>&nbsp;</span></td>
	<td width="30%"><span>&nbsp;</span></td>
	</tr>
<!--
	<tr>
	<td width="20%" valign="top" valign="top"><span>{$MOD.LBL_CAMPAIGN_OBJECTIVE}</span></td>
	<td colspan="3"><span>{$OBJECTIVE}</span></td>
</tr><tr>
	<td width="20%" valign="top" valign="top"><span>{$MOD.LBL_CAMPAIGN_CONTENT}</span></td>
	<td colspan="3"><span>{$CONTENT}</span></td>
</tr>
-->
</table>
</p>
<div align=center class="reportChartContainer">{$MY_CHART_ROI}</div>

<!-- END: main -->
