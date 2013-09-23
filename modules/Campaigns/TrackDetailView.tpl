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

/*********************************************************************************

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
		<input type="button" class="button" id="launch_wizard_button" onclick="javascript:window.location='index.php?module=Campaigns&action=WizardHome&record={$ID}';" value="{$MOD.LBL_TO_WIZARD_TITLE}" />
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
	<td width="20%" scope="row"><slot>{$MOD.LBL_NAME}</slot></td>
	<td width="30%"><slot>{$NAME}</slot></td>
	<td width="20%" scope="row"><slot>{$MOD.LBL_ASSIGNED_TO}</slot></td>
	<td width="30%"><slot>{$ASSIGNED_TO}</slot></td>
	</tr><tr>
	<td width="20%" scope="row"><slot>{$MOD.LBL_CAMPAIGN_STATUS}</slot></td>
	<td width="30%"><slot>{$STATUS}</slot></td>
<!-- BEGIN: pro -->
	<td width="20%" scope="row"><slot>{$MOD.LBL_TEAM}</slot></td>
	<td width="30%"><slot>{$TEAM_NAME}</slot></td>
<!-- END: pro -->
<!-- BEGIN: open_source -->
	<td width="20%" scope="row"><slot>&nbsp;</slot></td>
	<td width="30%"><slot>&nbsp;</slot></td>
<!-- END: open_source -->
	</tr><tr>
	<td width="20%" scope="row"><slot>{$MOD.LBL_CAMPAIGN_START_DATE}</slot></td>
	<td width="30%"><slot>{$START_DATE}</slot></td>
	<td scope="row"><slot>{$APP.LBL_DATE_MODIFIED}&nbsp;</slot></td>
	<td><slot>{$DATE_MODIFIED} {$APP.LBL_BY} {$MODIFIED_BY}</slot></td>
	</tr><tr>
	<td width="20%" scope="row"><slot>{$MOD.LBL_CAMPAIGN_END_DATE}</slot></td>
	<td width="30%"><slot>{$END_DATE}</slot></td>
	<td scope="row"><slot>{$APP.LBL_DATE_ENTERED}&nbsp;</slot></td>
	<td><slot>{$DATE_ENTERED} {$APP.LBL_BY} {$CREATED_BY}</slot></td>
	</tr><tr>
	<td width="20%" scope="row"><slot>{$MOD.LBL_CAMPAIGN_TYPE}</slot></td>
	<td width="30%"><slot>{$TYPE}</slot></td>
	<td width="20%" scope="row"><slot>&nbsp;</slot></td>
	<td width="30%"><slot>&nbsp;</slot></td>
	</tr><tr>
	<td width="20%" scope="row"><slot>&nbsp;</slot></td>
	<td width="30%"><slot>&nbsp;</slot></td>
	<td width="20%" scope="row"><slot>&nbsp;</slot></td>
	<td width="30%"><slot>&nbsp;</slot></td>
	</tr><tr>
	<td width="20%" nowrap scope="row"><slot>{$MOD.LBL_CAMPAIGN_BUDGET} ({$CURRENCY})</slot></td>
	<td width="30%"><slot>{$BUDGET}</slot></td>
	<td width="20%" nowrap scope="row"><slot>{$MOD.LBL_CAMPAIGN_ACTUAL_COST} ({$CURRENCY})</slot></td>
	<td width="30%"><slot>{$ACTUAL_COST}</slot></td>
	</tr><tr>
	<td width="20%" nowrap scope="row"><slot>{$MOD.LBL_CAMPAIGN_EXPECTED_REVENUE} ({$CURRENCY})</slot></td>
	<td width="30%" nowrap><slot>{$EXPECTED_REVENUE}</slot></td>
	<td width="20%" nowrap scope="row"><slot>{$MOD.LBL_CAMPAIGN_EXPECTED_COST} ({$CURRENCY})</slot></td>
	<td width="30%"><slot>{$EXPECTED_COST}</slot></td>
	</tr><tr>
	</tr><tr>
	<td width="20%" scope="row"><slot>&nbsp;</slot></td>
	<td width="30%"><slot>&nbsp;</slot></td>
	<td width="20%" scope="row"><slot>&nbsp;</slot></td>
	<td width="30%"><slot>&nbsp;</slot></td>
	</tr>
	<tr>
	<td width="20%" valign="top" scope="row"><slot>{$MOD.LBL_CAMPAIGN_OBJECTIVE}</slot></td>
	<td colspan="3"><slot>{$OBJECTIVE}</slot></td>
</tr><tr>
	<td width="20%" valign="top" scope="row"><slot>{$MOD.LBL_CAMPAIGN_CONTENT}</slot></td>
	<td colspan="3"><slot>{$CONTENT}</slot></td>
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
<slot>{$SUBPANEL}</slot>
