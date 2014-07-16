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
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<th colspan="4" align="left" ><h4>{$MOD.LBL_WIZ_NEWSLETTER_TITLE_STEP4}</h4></th>
	</tr>
	<tr>
	<td colspan="4">{$MOD.LBL_WIZARD_SUBSCRIPTION_MESSAGE}<br></td>
	</tr>
	<tr>
	<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
	<td scope='row'><span sugar='slot26'>{sugar_help text=$MOD.LBL_SUBSCRIPTION_TARGET_WIZARD_DESC }
	{$MOD.LBL_SUBSCRIPTION_LIST_NAME}</span sugar='slot'>
	</td>
	<td><input type='radio' onclick="change_target_list(this,'subs');" name='wiz_subscriptions_def_type' id='wiz_subscriptions_def_type' title="{$MOD.LBL_DEFAULT_LOCATION}" value="1" >{$MOD.LBL_DEFAULT_LOCATION}<br>
	    <input type='radio' onclick="change_target_list(this,'subs');" name='wiz_subscriptions_def_type' id='wiz_subscriptions_def_type' title="{$MOD.LBL_CUSTOM_LOCATION}" value="2" checked >{$MOD.LBL_CUSTOM_LOCATION}
	</td>
	<td  colspan='2'><span sugar='slot26b'>
	<input class="sqsEnabled" autocomplete="off" id="subscription_name" name="wiz_step3_subscription_name" title='{$MOD.LBL_SUBSCRIPTION_LIST_NAME}' type="text" size='35' value="{$SUBSCRIPTION_NAME}">
	<input id='prospect_list_type_default' name='prospect_list_type_default' type="hidden" value="default" />	
	<input id='wiz_step3_subscription_name_id' name='wiz_step3_subscription_list_id' title='Subscription List ID' type="hidden" value='{$SUBSCRIPTION_ID}'>
	<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="button"  class="button" value='{$APP.LBL_SELECT_BUTTON_LABEL}' name=btn1 id='wiz_step3_subscription_name_button'
 	onclick='open_popup("ProspectLists", 600, 400, "&list_type=default", true, false,  {$encoded_subscription_popup_request_data}, "single", true);'>
	</span sugar='slot'></td>
	</tr>
	<tr><td colspan='4'>&nbsp;</td></tr>

	<tr>
	<td scope='row'><span sugar='slot27'>{sugar_help text=$MOD.LBL_UNSUBSCRIPTION_TARGET_WIZARD_DESC }
	{$MOD.LBL_UNSUBSCRIPTION_LIST_NAME}</span sugar='slot'>
	</td>
	<td><input type='radio' onclick="change_target_list(this,'unsubs');" name='wiz_unsubscriptions_def_type' id='wiz_unsubscriptions_def_type' title="{$MOD.LBL_DEFAULT_LOCATION}" value="1">{$MOD.LBL_DEFAULT_LOCATION}<br>
	<input type='radio' onclick="change_target_list(this,'unsubs');" name='wiz_unsubscriptions_def_type' id='wiz_unsubscriptions_def_type' title="{$MOD.LBL_CUSTOM_LOCATION}" value="2" checked>{$MOD.LBL_CUSTOM_LOCATION}
	</td>
	<td colspan='2'><span sugar='slot27b'>
	<input  class="sqsEnabled" autocomplete="off" id="unsubscription_name" name="wiz_step3_unsubscription_name" title='{$MOD.LBL_UNSUBSCRIPTION_LIST_NAME}' type="text" size='35' value="{$UNSUBSCRIPTION_NAME}" >
	<input id='prospect_list_type_exempt' name='prospect_list_type_exempt' type="hidden" value="exempt" />	
	<iput id='wiz_step3_unsubscription_name_id' name='wiz_step3_unsubscription_list_id' title='UnSubscription List ID' type="hidden" value='{$UNSUBSCRIPTION_ID}'>
	<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="button"  class="button" value='{$APP.LBL_SELECT_BUTTON_LABEL}' name=btn2 id='wiz_step3_unsubscription_name_button'
 	onclick='open_popup("ProspectLists", 600, 400, "&list_type=exempt", true, false,  {$encoded_unsubscription_popup_request_data}, "single", true);'>
	</span sugar='slot'></td>
	</tr>
	<tr><td colspan='4'>&nbsp;</td></tr>
	<tr>
	<td scope='row'>
	<span sugar='slot28'>{sugar_help text=$MOD.LBL_TEST_TARGET_WIZARD_DESC }
	{$MOD.LBL_TEST_LIST_NAME}</span sugar='slot'>
	</td>
	<td><input type='radio' onclick="change_target_list(this,'test');" name='wiz_test_def_type' id='wiz_test_def_type' title="{$MOD.LBL_DEFAULT_LOCATION}" value="1" >{$MOD.LBL_DEFAULT_LOCATION}<br>
	<input type='radio' onclick="change_target_list(this,'test');" name='wiz_test_def_type' id='wiz_test_def_type' title="{$MOD.LBL_CUSTOM_LOCATION}" value="2" checked >{$MOD.LBL_CUSTOM_LOCATION}
	</td>
	<td   colspan='2'><span sugar='slot28b'>
	<input  class="sqsEnabled" autocomplete="off" id="test_name" name="wiz_step3_test_name" title='{$MOD.LBL_TEST_LIST_NAME}' type="text" size='35' value="{$TEST_NAME}">
	<input id='prospect_list_type_test' name='prospect_list_type_test' type="hidden" value="test" />	
	<input id='wiz_step3_test_name_id' name='wiz_step3_test_list_id' title='Test List ID' type="hidden" value='{$TEST_ID}'>
	<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="button"  class="button" value='{$APP.LBL_SELECT_BUTTON_LABEL}' name=btn3 id='wiz_step3_test_name_button'
 	onclick='open_popup("ProspectLists", 600, 400, "&list_type=test", true, false,  {$encoded_test_popup_request_data}, "single", true);'>	
	</span sugar='slot'></td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
	</table>
	<p>

	{literal}
	<script type="text/javascript" >
	//this function will toggle the popup forms to be read only if "Default" is selected,
	//and enable the pop up select if "Custom" is selected
	function change_target_list(radiobutton,list) {
	var def_value ='';
		if(list == 'subs'){
			list_name = 'wiz_step3_subscription_name';
			{/literal}
			def_id ='{$SUBSCRIPTION_ID}';
			def_value ='{$SUBSCRIPTION_NAME}'
			{literal}
		}
		if(list == 'unsubs'){
			list_name = 'wiz_step3_unsubscription_name';
			{/literal}
			def_id ='{$UNSUBSCRIPTION_ID}';
			def_value ='{$UNSUBSCRIPTION_NAME}'
			{literal}
		}
		if(list == 'test'){
			list_name = 'wiz_step3_test_name';
			{/literal}
			def_id ='{$TEST_ID}';
			def_value ='{$TEST_NAME}'
			{literal}
		}		
			//default selected, set inputs to read only
			if (radiobutton.value == '1') {
				radiobutton.form[list_name].disabled=true;
				radiobutton.form[list_name+"_button"].style.visibility='hidden';								
				radiobutton.form[list_name+"_id"].value=def_id;								
				//call function that populates the default value
				change_target_list_names(list,def_value);				
			} else {
				//custom selected, make inputs editable
				radiobutton.form[list_name].disabled=false;
				radiobutton.form[list_name+"_button"].style.visibility='visible';												
				radiobutton.form[list_name].value='';
				radiobutton.form[list_name+"_id"].value='';								
			}
	}

	//this function will populate the "default" name on the target list.  It will either do one, 
	//if specified, or all three widgets, if blank idis passed in
	function change_target_list_names(list,def_value)	{
		//id was passed in, create the listname and inputname variables
		if(list != ''){
	       switch (list){{/literal}
	            case 'subs':
	            listname = '{$MOD.LBL_SUBSCRIPTION_LIST}';               
	            inputname = 'subscription_name';
	            break;
	            case 'unsubs':
	            listname = '{$MOD.LBL_UNSUBSCRIPTION_LIST}';               
	            inputname = 'unsubscription_name';	            
	            break;   
	            case 'test':
	            inputname = 'test_name';	            
	            listname = '{$MOD.LBL_TEST_LIST}';
	            break;                              
	            default: 
	            inputname = '';
	            {literal}
			}		
		}

	//populate specified input with default value
	if(def_value==''){
	def_value = document.getElementById('name').value + ' ' + listname;}
	document.getElementById(inputname).value = def_value;
	}
	
	</script>	
	{/literal}
