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
<div class="template-panel">
	<div class="template-panel-container panel">
		<div class="template-container-full">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<th colspan="4" align="left" ><h4 class="header-4">{$MOD.LBL_WIZ_NEWSLETTER_TITLE_STEP2}</h4></th>
		</tr>
		<tr><td class="wizard-step-info" colspan="3"><label>{$MOD.LBL_WIZARD_BUDGET_MESSAGE}</label></td><td class="emptyField">&nbsp;</td></tr>
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
		<tr>
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
	</div>
	<p>
	
	<script>
	var	num_grp_sep ='{$NUM_GRP_SEP}';
	var	dec_sep = '{$DEC_SEP}';
	var campaignBudget = true;

    /*
     * this is the custom validation script that will validate the fields on step2 of wizard
     */
	{literal}
    function validate_step2(){
        //add fields to validation and call generic validation script
        var requiredTxt = SUGAR.language.get('app_strings', 'ERR_MISSING_REQUIRED_FIELDS');
        if(validate['wizform']!='undefined'){delete validate['wizform']};
        addToValidate('wizform', 'budget', 'float', false,  document.getElementById('budget').title);
        addToValidate('wizform', 'actual_cost', 'float', false,  document.getElementById('actual_cost').title);
        addToValidate('wizform', 'expected_revenue', 'float', false,  document.getElementById('expected_revenue').title);
        addToValidate('wizform', 'expected_cost', 'float', false,  document.getElementById('expected_cost').title);
        addToValidate('wizform', 'impressions', 'float', false,  document.getElementById('impressions').title);        
		var check_date = new Date();
		oldStartsWith =84;
		return check_form('wizform');
    }    
    
	function ConvertItems(id) {
		var items = new Array();
	
		//get the items that are to be converted
		expected_revenue = document.getElementById('expected_revenue');
		budget = document.getElementById('budget');
		actual_cost = document.getElementById('actual_cost');
		expected_cost = document.getElementById('expected_cost');	
	
		//unformat the values of the items to be converted
		expected_revenue.value = unformatNumber(expected_revenue.value, num_grp_sep, dec_sep);
		expected_cost.value = unformatNumber(expected_cost.value, num_grp_sep, dec_sep);
		budget.value = unformatNumber(budget.value, num_grp_sep, dec_sep);
		actual_cost.value = unformatNumber(actual_cost.value, num_grp_sep, dec_sep);
		
		//add the items to an array
		items[items.length] = expected_revenue;
		items[items.length] = budget;
		items[items.length] = expected_cost;
		items[items.length] = actual_cost;
	
		//call function that will convert currency
		ConvertRate(id, items);
	
		//Add formatting back to items
		expected_revenue.value = formatNumber(expected_revenue.value, num_grp_sep, dec_sep);
		expected_cost.value = formatNumber(expected_cost.value, num_grp_sep, dec_sep);
		budget.value = formatNumber(budget.value, num_grp_sep, dec_sep);
		actual_cost.value = formatNumber(actual_cost.value, num_grp_sep, dec_sep);
	}    
	{/literal}
	</script>	
