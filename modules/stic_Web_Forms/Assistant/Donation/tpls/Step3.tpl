{*
***********************************************
 Show the final parameters of the form
***********************************************
*}

<link rel="stylesheet" type="text/css" href="include/javascript/yui/build/datatable/assets/skins/sam/datatable.css?v={$VERSION_MARK}">

{literal}
	<style>
		.edit {background-color: transparent !important;}
		.edit table {margin: 40px 10px 10px 40px !important; background-color:transparent !important}
		.edit tr td {height: 40px; line-height: 20px !important;}
		.edit tr td table tr td {padding: 0px 3px 25px 0;}		
		.tabDetailViewDF {border-bottom: 0px;}
		input, textarea, select { width: 300px;	}
		input[type="button"], .button {width: 150px; }
	</style>

	<script>
		function editUrl() {
			var chk_url_elm = document.getElementById("chk_edit_url");
			if (chk_url_elm.checked == true) 
			{
				var url_elm = document.getElementById("post_url");
				url_elm.disabled = false;
			}
			if (chk_url_elm.checked == false) 
			{
				var url_elm = document.getElementById("post_url");
				url_elm.disabled = true;
			}
		}
	</script>
{/literal}
    
<table width="100%">
	<tr>
		<td><h2>{$MOD.LBL_WEBFORMS_STEP5}</h2></td>
		<td align="right" nowrap><span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span> {$APP.NTC_REQUIRED}</td>
	</tr>
</table>

<table width="100%" class="edit view">
	<tr>
		<td>
			<table style="width: 100%">
				<tr>
					<td scope="row">{$MOD.LBL_WEBFORMS_HEADER}:</td>
					<td width="80%">
						<input id="web_header" name="web_header" title="{$MOD.LBL_DEFINE_HEADER}" size="60" value="{$MAP.FORM_HEADER|default:$MOD.LBL_DEFINE_HEADER}" type="text">
					</td>
				</tr>
				<tr>
					<td scope="row">{$MOD.LBL_WEBFORMS_DESCRIPTION}:</td>
					<td width="80%">
						{assign var="DEFAULT_DESC" value=$MOD.LBL_DESCRIPTION_TEXT_FORM|cat:"&nbsp;"|cat:$MOD.LBL_DESCRIPTION_TEXT_FP_FORM}
						<textarea id="web_description" name="web_description" rows="2" cols="55">{$MAP.FORM_DESCRIPTION|default:$DEFAULT_DESC}</textarea>
					</td>
				</tr>
				<tr>
					<td scope="row">{$MOD.LBL_WEBFORMS_SUBMIT}:</td>
					<td width="80%">
						<input id="web_submit" name="web_submit" title="{$MOD.LBL_WEBFORMS_SUBMIT}" size="60" value="{$MAP.FORM_SUBMIT_LABEL|default:$MOD.LBL_WEBFORMS_SUBMIT_DEFAULT}" type="text">
					</td>
				</tr>
				<tr>
					<td scope="row">{$MOD.LBL_WEBFORMS_POST_URL}:</td>
					<td width="80%">
						<input id="post_url" name="post_url" size="60" disabled='true' value="{$MAP.FORM_WEB_POST_URL}" type="text">
						<input id="chk_edit_url" name="chk_edit_url" onclick="editUrl();" class='checkbox' type='checkbox'><span class="dataLabel" width="10%">{$MOD.LBL_WEBFORMS_POST_URL_MODIFY}</span>
					</td>
				</tr>
				<tr>
					<td scope="row">{$MOD.LBL_WEBFORMS_REDIRECT_OK_URL}:&nbsp;<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td>
					<td>
						<input id="redirect_ok_url" name="redirect_ok_url" size="60" value="{$MAP.FORM_REDIRECT_OK_URL|default:$MAP.REDIRECT_OK_URL_DEFAULT}" type="text">
					</td>
				</tr>
				<tr>
					<td scope="row">{$MOD.LBL_WEBFORMS_REDIRECT_KO_URL}:&nbsp;<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td>
					<td>
						<input id="redirect_ko_url" name="redirect_ko_url" size="60" value="{$MAP.FORM_REDIRECT_KO_URL|default:$MAP.REDIRECT_KO_URL_DEFAULT}" type="text">
					</td>
				</tr>
				<tr>
					<td scope="row">{$MOD.LBL_WEBFORMS_PAYMENT_TYPE}:&nbsp;<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td>
					<td>
						<select id="payment_type" name="payment_type">
						{html_options options=$MAP.PAYMENT_TYPE_OPTIONS selected=$MAP.PAYMENT_TYPE}
						</select>
					</td>
				</tr>
				<tr>
					<td scope="row">{$MOD.LBL_WEBFORMS_RELATION_TYPE}:&nbsp;</td>
					<td>
						<select id="relation_type" name="relation_type">
						{html_options options=$MAP.RELATION_TYPE_OPTIONS selected=$MAP.RELATION_TYPE}
						</select>
					</td>
				</tr>
				<tr>
					<td scope="row">{$MOD.LBL_NOTIFICATION_EMAIL_TEMPLATE}:&nbsp;</td>
					<td>
						<span sugar="slot40b"> 
							<input class="sqsEnabled" autocomplete="off" id="check_" name="email_template_name" type="text" value="{$MAP.EMAIL_TEMPLATE_NAME}" /> 
							<input id="email_template_id" name="email_template_id" type="hidden" value="{$MAP.EMAIL_TEMPLATE_ID}" /> 
							<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="button" class="button" value='{$APP.LBL_SELECT_BUTTON_LABEL}' name=btn1 onclick='open_popup("EmailTemplates", 600, 400, "", true, false,{$MAP.EMAIL_TEMPLATES_POPUP_REQ_DATA});' />
						</span sugar="slot">
					</td>
				</tr>
				{* Check Identification Number *}
				<tr>
					<td scope="row">{$MOD.LBL_CHECK_IDENTIFICATION_NUMBER}:&nbsp;</td>
					<td>
						<span sugar="slot40b"> 
							<input type="radio" id="validate_identification_number" name="validate_identification_number"  checked value="1"> {$APP.LBL_YES} &nbsp;&nbsp;
							<input type="radio" id="validate_identification_number" name="validate_identification_number"  value="0"> {$APP.LBL_NO}
						</span sugar="slot">
					</td>
				</tr>
				{* // *}
				{* Allow card recurring payments*}
				<tr>
					<td scope="row">{$MOD.LBL_ALLOW_CARD_RECURRING_PAYMENTS}:&nbsp;{sugar_help text=$MOD.LBL_ALLOW_CARD_RECURRING_PAYMENTS_INFO}</td>
					<td>
						<span sugar="slot40b"> 
							<input type="radio" id="allow_card_recurring_payments" name="allow_card_recurring_payments"  value="1"> {$APP.LBL_YES} &nbsp;&nbsp;
							<input type="radio" id="allow_card_recurring_payments" name="allow_card_recurring_payments"  checked value="0"> {$APP.LBL_NO}
						</span sugar="slot">
						
					</td>
				</tr>
				{* // *}
				{* Allow paypal recurring payments*}
				<tr>
					<td scope="row">{$MOD.LBL_ALLOW_PAYPAL_RECURRING_PAYMENTS}:&nbsp;{sugar_help text=$MOD.LBL_ALLOW_PAYPAL_RECURRING_PAYMENTS_INFO}</td>
					<td>
						<span sugar="slot40b"> 
							<input type="radio" id="allow_paypal_recurring_payments" name="allow_paypal_recurring_payments"  value="1"> {$APP.LBL_YES} &nbsp;&nbsp;
							<input type="radio" id="allow_paypal_recurring_payments" name="allow_paypal_recurring_payments"  checked value="0"> {$APP.LBL_NO}
						</span sugar="slot">
					</td>
				</tr>
				{* // *}
				{* Allow stripe recurring payments*}
				<tr>
					<td scope="row">{$MOD.LBL_ALLOW_STRIPE_RECURRING_PAYMENTS}:&nbsp;{sugar_help text=$MOD.LBL_ALLOW_STRIPE_RECURRING_PAYMENTS_INFO}</td>
					<td>
						<span sugar="slot40b"> 
							<input type="radio" id="allow_stripe_recurring_payments" name="allow_stripe_recurring_payments"  value="1"> {$APP.LBL_YES} &nbsp;&nbsp;
							<input type="radio" id="allow_stripe_recurring_payments" name="allow_stripe_recurring_payments"  checked value="0"> {$APP.LBL_NO}
						</span sugar="slot">
					</td>
				</tr>
				{* // *}
				<tr>
					<td scope="row">{$MOD.LBL_RELATED_CAMPAIGN}:&nbsp;<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td>
					<td>
						<span sugar="slot40b"> 
							<input class="sqsEnabled" autocomplete="off" id="campaign_name" name="campaign_name" type="text" value="{$MAP.CAMPAIGN_NAME}" /> 
							<input id="campaign_id" name="campaign_id" type="hidden" value="{$MAP.CAMPAIGN_ID}" /> 
							<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="button" class="button" value='{$APP.LBL_SELECT_BUTTON_LABEL}' name=btn1 onclick='open_popup("Campaigns", 600, 400, "", true, false,{$MAP.CAMPAIGNS_POPUP_REQ_DATA});' />
						</span sugar="slot">
					</td>
				</tr>
				<tr>
						<td scope="row">{$APP.LBL_ASSIGNED_TO}&nbsp;<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td>
						<td>
						<span sugar="slot45b">
							<input class="sqsEnabled" autocomplete="off" id="assigned_user_name" name="assigned_user_name" type="text" value="{$MAP.ASSIGNED_USER_NAME}">
							<input id="assigned_user_id" name="assigned_user_id" type="hidden" value="{$MAP.ASSIGNED_USER_ID}" />
							<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="button" class="button" value="{$APP.LBL_SELECT_BUTTON_LABEL}" name=btn1 onclick='open_popup("Users", 600, 400, "", true, false, {$MAP.USERS_POPUP_REQ_DATA});' />
						</span sugar='slot'>
					</td>
				</tr>
				<tr>
					<td scope="row">{$MOD.LBL_WEBFORMS_FOOTER}:</td>
					<td>
						<textarea name='web_footer' rows='2' cols='55'>{$MAP.FORM_FOOTER|default:$MOD.LBL_WEBFORMS_FOOTER_DEFAULT}</textarea>
					</td>
				</tr>
				<tr>
					<td scope="row">{$MOD.LBL_WEBFORMS_ATTACHED_FILES_NUMBER}:</td>
					<td>
						<slot>
							<select name="num_attachment">
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</slot>
					</td>
				</tr>								
			</table>
		</td>
	</tr>
</table>

<table width="100%">
	<tr>
		<td>
			<input title="{$APP.LBL_BACK}" accessKey="{$APP.LBL_BACK}" class="button" onclick="return back('webforms');" type="submit" name="button" value="{$APP.LBL_BACK}"> 
			<input title="{$APP.LBL_NEXT_BUTTON_LABEL}" class="button" type="submit" name="button" value="{$APP.LBL_NEXT_BUTTON_LABEL}" onclick="return check_form('webforms')">
		</td>
	</tr>
</table>
