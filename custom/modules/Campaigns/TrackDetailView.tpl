{*
/**
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
 */

/**

 */
*}
<!-- BEGIN: main -->
{$chartResources}
<script>SUGAR.loadChart = true;</script>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
<form action="index.php" method="post" name="DetailView" id="form">
			<input type="hidden" name="module" value="CampaignLog">
			<input type="hidden" name="subpanel_parent_module" value="Campaigns">			
			<input type="hidden" name="record" value="{$ID}">
			<input type="hidden" name="isDuplicate" value=false>
			<input type="hidden" name="action">
			<input type="hidden" name="return_module">
			<input type="hidden" name="return_action">
			<input type="hidden" name="return_id" >
			<input type="hidden" name="campaign_id" value="{$ID}">
			<input type="hidden" name="mode" value="">
			
			{$TRACK_DELETE_BUTTON}
	</td>
		<td align='right'></td>
	<td align='right'>		    
		{* STIC-Custom - JBL - 20240830 - Notifications: Remove buttons *}
		{* https://github.com/SinergiaTIC/SinergiaCRM/pull/44 *}
		{* <input type="button" class="button" id="launch_wizard_button" onclick="javascript:window.location='index.php?module=Campaigns&action=WizardHome&record={$ID}';" value="{$MOD.LBL_TO_WIZARD_TITLE}" /> *}
		{$TRACK_WIZARD_BUTTON}
		{* END STIC-Custom *}
		<input type="button" class="button" id="view_details_button" onclick="javascript:window.location='index.php?module=Campaigns&action=DetailView&record={$ID}';" value="{$MOD.LBL_TODETAIL_BUTTON_LABEL}" />
		<span style="{$DISABLE_LINK}"><input type="button" class="button" id="view_roi_button" onclick="javascript:window.location='index.php?module=Campaigns&action=RoiDetailView&record={$ID}';" value="{$MOD.LBL_TRACK_ROI_BUTTON_LABEL}" /></SPAN>{$ADMIN_EDIT}
	</td>

	<td align='right'>{$ADMIN_EDIT}</td>
</tr>
</table>
<div class="detail view">
<table width="100%" border="0" cellspacing="{$GRIDLINE}" cellpadding="0">
<tr>
{$PAGINATION}
	<td width="20%" scope="row"><span>{$MOD.LBL_NAME}</span></td>
	<td width="30%"><span>{$NAME}</span></td>
	<td width="20%" scope="row"><span>{$MOD.LBL_ASSIGNED_TO}</span></td>
	<td width="30%"><span>{$ASSIGNED_TO}</span></td>
	</tr><tr>
	<td width="20%" scope="row"><span>{$MOD.LBL_CAMPAIGN_STATUS}</span></td>
	<td width="30%"><span>{$STATUS}</span></td>


	<td width="20%" scope="row"><span>{$MOD.LBL_TEAM}</span></td>
	<td width="30%"><span>{$TEAM_NAME}</span></td>


	</tr><tr>
	<td width="20%" scope="row"><span>{$MOD.LBL_CAMPAIGN_START_DATE}</span></td>
	<td width="30%"><span>{$START_DATE}</span></td>
	<td scope="row"><span>{$APP.LBL_DATE_MODIFIED}&nbsp;</span></td>
	<td><span>{$DATE_MODIFIED} {$APP.LBL_BY} {$MODIFIED_BY}</span></td>
	</tr><tr>
	<td width="20%" scope="row"><span>{$MOD.LBL_CAMPAIGN_END_DATE}</span></td>
	<td width="30%"><span>{$END_DATE}</span></td>
	<td scope="row"><span>{$APP.LBL_DATE_ENTERED}&nbsp;</span></td>
	<td><span>{$DATE_ENTERED} {$APP.LBL_BY} {$CREATED_BY}</span></td>
	</tr><tr>
	<td width="20%" scope="row"><span>{$MOD.LBL_CAMPAIGN_TYPE}</span></td>
	<td width="30%"><span>{$TYPE}</span></td>
	<td width="20%" scope="row"><span>&nbsp;</span></td>
	<td width="30%"><span>&nbsp;</span></td>
	</tr><tr>
	<td width="20%" scope="row"><span>&nbsp;</span></td>
	<td width="30%"><span>&nbsp;</span></td>
	<td width="20%" scope="row"><span>&nbsp;</span></td>
	<td width="30%"><span>&nbsp;</span></td>
	</tr><tr>
	<td width="20%" nowrap scope="row"><span>{$MOD.LBL_CAMPAIGN_BUDGET} ({$CURRENCY})</span></td>
	<td width="30%"><span>{$BUDGET}</span></td>
	<td width="20%" nowrap scope="row"><span>{$MOD.LBL_CAMPAIGN_ACTUAL_COST} ({$CURRENCY})</span></td>
	<td width="30%"><span>{$ACTUAL_COST}</span></td>
	</tr><tr>
	<td width="20%" nowrap scope="row"><span>{$MOD.LBL_CAMPAIGN_EXPECTED_REVENUE} ({$CURRENCY})</span></td>
	<td width="30%" nowrap><span>{$EXPECTED_REVENUE}</span></td>
	<td width="20%" nowrap scope="row"><span>{$MOD.LBL_CAMPAIGN_EXPECTED_COST} ({$CURRENCY})</span></td>
	<td width="30%"><span>{$EXPECTED_COST}</span></td>
	</tr><tr>
	</tr><tr>
	<td width="20%" scope="row"><span>&nbsp;</span></td>
	<td width="30%"><span>&nbsp;</span></td>
	<td width="20%" scope="row"><span>&nbsp;</span></td>
	<td width="30%"><span>&nbsp;</span></td>
	</tr>
	<tr>
	<td width="20%" valign="top" scope="row"><span>{$MOD.LBL_CAMPAIGN_OBJECTIVE}</span></td>
	<td colspan="3"><span>{$OBJECTIVE}</span></td>
</tr><tr>
	<td width="20%" valign="top" scope="row"><span>{$MOD.LBL_CAMPAIGN_CONTENT}</span></td>
	<td colspan="3"><span>{$CONTENT}</span></td>
</tr>
</table>
</div>
	<table border='0' width='100%'>
		<tr>
			<td width="10%">{$FILTER_LABEL}</td>
			<td width="70%">{$MKT_DROP_DOWN}</td>
			<td width="20%">&nbsp;</td>			
		</tr>
		<tr>
			<td colspan="3"><div class="reportChartContainer">{$MY_CHART}</div></td>				
		</tr>
	</table>
</form>
<script type="text/javascript" language="javascript">
{literal}
function re_draw_chart(x){
alert(x.value);
}

var toggle = 0;
	function show_more_info(tog){
		elem = document.getElementById('more_info');
		if (tog == 0){
			toggle=1;
			elem.style.display = '';
		}else{
			toggle=0;		
			elem.style.display = 'none';			
		}
	}
{/literal}
</script>

<!-- END: main -->

<!-- BEGIN: subpanel -->
{sugar_getscript file="modules/Campaigns/DetailView.js"}
<span>{$SUBPANEL}</span>
