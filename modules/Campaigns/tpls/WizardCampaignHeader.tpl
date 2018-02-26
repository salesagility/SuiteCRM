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

/*********************************************************************************

 ********************************************************************************/
*}

	<!-- Begin Campaign Diagnostic Link -->	
	<!-- {$CAMPAIGN_DIAGNOSTIC_LINK} -->
	<!-- End Campaign Diagnostic Link -->
	<div class="template-panel">
		<div class="template-panel-container panel">
			<div class="template-container-full">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<th  colspan="4"><h4 class="header-4">{$MOD.LBL_WIZ_NEWSLETTER_TITLE_STEP1} </h4></th>
					</tr>
		<tr>
			<td  colspan="3"><label class="wizard-step-info">{$MOD.LBL_STEP_INFO_CAMPAIGN_HEADER} </label></td>
			<td colspan="1" class="emptyField">&nbsp;</td>
		</tr>
		<tr>
			<td width="17%" scope="col"><span sugar='slot1'>{$MOD.LBL_NAME} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span sugar='slot'></td>
			<td width="33%" ><span sugar='slot1b'><input id='name' name='wiz_step1_name' aria-required="true"  title='{$MOD.LBL_NAME}' {$DISABLED}  size='50' maxlength='50' type="text" value="{$CAMP_NAME}" ></span sugar='slot'></td>
			<td width="15%" scope="col"><span sugar='slot2'>{$APP.LBL_ASSIGNED_TO}</span sugar='slot'></td>
			<td width="35%" ><span sugar='slot2b'><input class="sqsEnabled" autocomplete="off" id="assigned_user_name" name="wiz_step1_assigned_user_name"  title='{$APP.LBL_ASSIGNED_TO}' type="text" value="{$ASSIGNED_USER_NAME}"><input id='assigned_user_id' name='wiz_step1_assigned_user_id' type="hidden" value="{$ASSIGNED_USER_ID}" />
		<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="button" class="button" value='{$APP.LBL_SELECT_BUTTON_LABEL}' name=btn1
			   onclick='open_popup("Users", 600, 400, "", true, false, {$encoded_users_popup_request_data});' /></span sugar='slot'>
			</td>
		</tr>
		<tr>
			<td width="15%" scope="col"><span sugar='slot3'>{$MOD.LBL_CAMPAIGN_STATUS} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span sugar='slot'></td>
			<td width="35%" ><span sugar='slot3b'><select id='status' name='wiz_step1_status'  aria-required="true" title='{$MOD.LBL_CAMPAIGN_STATUS}'>{$STATUS_OPTIONS}</select></span sugar='slot'></td>
		</tr>

					{if $campaign_type == 'survey'}
						<tr>
							<td width="15%" scope="col"><span sugar='slot3'>{$MOD.LBL_CAMPAIGN_SURVEY} <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span sugar='slot'></td>
							<td width="35%" >
								<span sugar='slot2b'>
									<input class="sqsEnabled" autocomplete="off" id="survey_name" name="wiz_step1_survey_name"  title='{$MOD.LBL_CAMPAIGN_SURVEY}' type="text" value="{$SURVEY_NAME}">
									<input id='survey_id' name='wiz_step1_survey_id' type="hidden" value="{$SURVEY_ID}"  title='{$MOD.LBL_CAMPAIGN_SURVEY}'/>
									<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="button" class="button" value='{$APP.LBL_SELECT_BUTTON_LABEL}' name=btn1 onclick='open_popup("Surveys", 600, 400, "", true, false, {$encoded_surveys_popup_request_data});' />
								</span sugar='slot'>
							</td>
					</tr>
					{/if}

					<tr{if $HIDE_CAMPAIGN_TYPE} style="display: none;"{/if}>
						<td scope="col"><span sugar='slot6'>{$MOD.LBL_CAMPAIGN_TYPE} </td>
						<td><span sugar='slot6b'><{$SHOULD_TYPE_BE_DISABLED} id='campaign_type' title='{$MOD.LBL_CAMPAIGN_TYPE}' name='wiz_step1_campaign_type' >{$CAMPAIGN_TYPE_OPTIONS}</select></span sugar='slot'></td>
					</tr>
					<tr class="emptyRow">
						<td width="15%"><span sugar='slot9'>&nbsp;</span></span sugar='slot'></td>
						<td width="35%" ><span sugeeear='slot9b'>&nbsp;</span sugar='slot'></td>
						<td ><span sugar='slot10'>&nbsp;</span sugar='slot'></td>
						<td><span sugar='slot10b'>&nbsp;</span sugar='slot'></td>
					</tr>
					<tr>
						<td valign="top" scope="row"><span sugar='slot10'>{$MOD.LBL_CAMPAIGN_CONTENT}</span sugar='slot'></td>
						<td colspan="3"><span sugar='slot10a'><textarea id='wiz_content' name='wiz_step1_content' title='{$MOD.LBL_CAMPAIGN_CONTENT}'  cols="110" rows="5">{$CONTENT}</textarea></span sugar='slot'></td>
					</tr>
					<tr>
						<td scope="row">&nbsp;</td>
						<td>&nbsp;</td>
						<td scope="row">&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					</table>
			</div>
		</div>


		{if $campaign_type != "general"}
		<div class="template-panel-container panel">
				<div class="template-container-full">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th colspan="4" align="left" ><h4 class="header-4">{$MOD.LBL_WIZ_NEWSLETTER_TITLE_STEP2}</h4></th>
							</tr>
							<tr class="emptyRow"><td class="wizard-step-info" colspan="3"><label>{$MOD.LBL_WIZARD_BUDGET_MESSAGE}</label></td><td>&nbsp;</td></tr>
							<tr class="emptyRow"><td class="datalabel" colspan="4">&nbsp;</td></tr>
							<tr>
								<td scope="col"><span sugar='slot14'>{$MOD.LBL_CAMPAIGN_BUDGET}</span sugar='slot'></td>
								<td ><span sugar='slot14b'><input type="text" size="10" maxlength="15" id="budget" name="wiz_step2_budget" title="{$MOD.LBL_CAMPAIGN_BUDGET}" value="{$CAMP_BUDGET}"></span sugar='slot'></td>
								<td scope="col"><span sugar='slot15'>{$MOD.LBL_CAMPAIGN_ACTUAL_COST}</span sugar='slot'></td>
								<td ><span sugar='slot15b'><input type="text" size="10" maxlength="15" id="actual_cost" name="wiz_step2_actual_cost" title="{$MOD.LBL_CAMPAIGN_ACTUAL_COST}" value="{$CAMP_ACTUAL_COST}"></span sugar='slot'></td>
							</tr>
							<tr>
								<td scope="col"><span sugar='slot16'>{$MOD.LBL_CAMPAIGN_EXPECTED_REVENUE}</span sugar='slot'></td>
								<td ><span sugar='slot16b'><input type="text" size="10" maxlength="15" id="expected_revenue" name="wiz_step2_expected_revenue" title="{$MOD.LBL_CAMPAIGN_EXPECTED_REVENUE}" value="{$CAMP_EXPECTED_REVENUE}"></span sugar='slot'></td>
								<td scope="col"><span sugar='slot17'>{$MOD.LBL_CAMPAIGN_EXPECTED_COST}</span sugar='slot'></td>
								<td ><span sugar='slot17b'><input type="text" size="10" maxlength="15" id="expected_cost" name="wiz_step2_expected_cost" title="{$MOD.LBL_CAMPAIGN_EXPECTED_COST}" value="{$CAMP_EXPECTED_COST}"></span sugar='slot'></td>
							</tr>
							<tr>
								<td scope="col"><span sugar='slot18'>{$MOD.LBL_CURRENCY}</span sugar='slot'></td>
								<td><span sugar='slot18b'><select title='{$MOD.LBL_CURRENCY}' name='wiz_step2_currency_id' id='currency_id'   onchange='ConvertItems(this.options[selectedIndex].value);'>{$CURRENCY}</select></span sugar='slot'></td>
								<td scope="col"><span sugar='slot17'>{$MOD.LBL_CAMPAIGN_IMPRESSIONS}</span sugar='slot'></td>
								<td ><span sugar='slot17b'><input type="text" size="10" maxlength="15" id="impressions" name="wiz_step2_impressions" title="{$MOD.LBL_CAMPAIGN_IMPRESSIONS}" value="{$CAMP_IMPRESSIONS}"></span sugar='slot'></td></tr>
							<tr class="emptyRow">
								<td scope="col"><span sugar='slot18'>&nbsp;</span sugar='slot'></td>
								<td><span sugar='slot18b'>&nbsp;</td>
								<td scope="col"><span sugar='slot19'>&nbsp;</span sugar='slot'></td>
								<td><span sugar='slot19b'>&nbsp;</span sugar='slot'></td>
							</tr>
							<tr>
								<td valign="top" scope="row"><span sugar='slot20'>{$MOD.LBL_CAMPAIGN_OBJECTIVE}</span sugar='slot'></td>
								<td colspan="4"><span sugar='slot20b'><textarea id="objective" name="wiz_step2_objective" title='{$MOD.LBL_CAMPAIGN_OBJECTIVE}' cols="110" rows="5">{$OBJECTIVE}</textarea></span sugar='slot'></td>
							</tr>
							<tr>
								<td >&nbsp;</td>
								<td>&nbsp;</td>
								<td >&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</div>
		</div>
		{/if}

	</div>


	{literal}
	<script type="text/javascript">
		Calendar.setup ({{/literal}
			inputField : "start_date", ifFormat : "{$CALENDAR_DATEFORMAT}", showsTime : false, button : "start_date_trigger", singleClick : true, step : 1, weekNumbers:false
			{literal}
		});
		
		Calendar.setup ({{/literal}
			inputField : "end_date", ifFormat : "{$CALENDAR_DATEFORMAT}", showsTime : false, button : "end_date_trigger", singleClick : true, step : 2, weekNumbers:false
		{literal}
		});
	

    /*
     * this is the custom validation script that will validate the fields on step1 of wizard
     */
    
    function validate_step1(){
        //loop through and check for empty strings ('  ')
        requiredTxt = SUGAR.language.get('app_strings', 'ERR_MISSING_REQUIRED_FIELDS');
        var stepname = 'wiz_step_1_';
        var has_error = 0;
        var fields = new Array();
        fields[0] = 'name'; 
        fields[1] = 'status';
        fields[2] = 'end_date';
        {/literal}
        {if $campaign_type == "survey"}
        fields[3] = 'survey_id';
        {/if}
        {literal}
        var field_value = ''; 
        for (i=0; i < fields.length; i++){
            if(document.getElementById(fields[i]) !=null){
                field_value = trim(document.getElementById(fields[i]).value);
                if(field_value.length<1){
                //throw error if string is empty            
                add_error_style('wizform', fields[i], requiredTxt +' ' +document.getElementById(fields[i]).title );
                has_error = 1;
                }
            }
        }
        if(has_error == 1){
            //error has been thrown, return false
            return false;
        }
        //add fields to validation and call generic validation script 
        if(validate['wizform']!='undefined'){delete validate['wizform']};
        addToValidate('wizform', 'name', 'alphanumeric', true,  document.getElementById('name').title);
        addToValidate('wizform', 'status', 'alphanumeric', true,  document.getElementById('status').title);

        return check_form('wizform');
    }    





	</script>
	{/literal}
	<link rel="stylesheet" type="text/css" href="modules/EmailTemplates/EmailTemplate.css">

