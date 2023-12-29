{*
********************************************************************************
 Step 1 of the event registration form.
 Ask the main parameters of the form
********************************************************************************
*}

{literal}
	<style>
		.edit {background-color: transparent !important; margin-top:30px !important;}
		td.check {width: 1%; max-width:150px; text-align: left;}
		td.text {white-space:nowrap; text-align: left; padding-right: 2px; vertical-align: middle;}
	</style>

	<script type="text/javascript">
		function enableOptions(includeOrg) 
		{
			var cif = document.getElementById("account_code_mandatory");
			var nameOrg = document.getElementById("account_name_optional");
			cif.disabled = ! includeOrg.checked;
			nameOrg.disabled = ! includeOrg.checked;
			if (cif.disabled) 
			{
				cif.checked = false;
			}
			if (nameOrg.disabled) 
			{
				nameOrg.checked = false;
			}
		}

		function enableRecaptchaConfigs(includeRecaptcha)
		{
			var recaptchaSelected = document.getElementById("recaptcha_selected");
			recaptchaSelected.disabled = !includeRecaptcha.checked;
		}

		function optionalNameCtrl(account_code_mandatory) 
		{
			var nameOrg = document.getElementById("account_name_optional");
			nameOrg.disabled = account_code_mandatory.checked;
			if (nameOrg.disabled) 
			{
				nameOrg.checked = false;
			}
		}
	</script>
{/literal}

<div id='grid_Div'>
    <table width="100%">
        <tr>
            <td><h2>{$MOD.LBL_WEBFORMS_STEP1}</h2></td>
        </tr>
    </table>

    <table width="100%" class="edit view">
    	<tr>
    		<td>
        		<table width="100%" style="border-spacing: 0px; border-collapse: separate; border: none; margin-top: 5px">
        			<tr>
        				<td class="check"><input type="checkbox" name="include_payment_commitment" id="include_payment_commitment" value="1" {$FP_CHECKED}></td>
        				<td class="text">{$MOD.LBL_WEBFORMS_INCLUDES_PAYMENTS}</td>
        			</tr>
					<tr>
					    <td class="check"><input type="checkbox" name="include_organization" id="include_organization" value="1" {$ORG_CHECKED} onclick="enableOptions(this);"></td>
        				<td class="text">{$MOD.LBL_WEBFORMS_INCLUDES_ORGANIZATION}</td>
        			</tr>
        			<tr>
					    <td class="check" style="padding-left: 5px"><input type="checkbox" name="account_name_optional" id="account_name_optional" value="1" {$NAME_ORG_CHECKED} {if (! $ORG_CHECKED || $CIF_CHECKED)} disabled {/if}></td>
        				<td class="text">{$MOD.LBL_WEBFORMS_MAKE_ACCOUNT_NAME_OPTIONAL}</td>
        			</tr>
        			<tr>
            		   	<td class="check" style="padding-left: 5px"><input type="checkbox" name="account_code_mandatory" id="account_code_mandatory" value="1" {$CIF_CHECKED} {if ! $ORG_CHECKED} disabled {/if} onclick="optionalNameCtrl(this);"> </td>
        				<td class="text"">{$MOD.LBL_WEBFORMS_MAKE_CIF_REQUIRED}</td>
        			</tr>
        			<tr>
        				<td class="check"><input type="checkbox" name="include_registration" id="include_registration" value="1" {$INS_CHECKED}></td>
        				<td class="text">{$MOD.LBL_WEBFORMS_INCLUDES_REGISTRATION}</td>
        			</tr>
					<tr>
						<td class="check"><input type="checkbox" name="include_recaptcha" id="include_recaptcha" value="1" {$RECAPTCHA_CHECKED} {if empty($RECAPTCHA_CONFIGKEYS)} disabled {else} onclick="enableRecaptchaConfigs(this);" {/if}></td>
						<td class="text">{$MOD.LBL_WEBFORMS_INCLUDES_RECAPTCHA} {sugar_help text=$MOD.LBL_WEBFORMS_RECAPTCHA_HELP}</td>
					</tr>
					{if !empty($RECAPTCHA_CONFIGKEYS)} 
						<tr>
							<td class="check"></td>
							<td style="text-align: left;">
								{$MOD.LBL_WEBFORMS_CHOOSE_RECAPTCHA}
								<select name="recaptcha_selected" id="recaptcha_selected" disabled>
									{html_options options=$RECAPTCHA_CONFIGKEYS selected=$MAP.RECAPTCHA_SELECTED}
								</select>
							</td>
						</tr>
					{/if}
                </table>
            </td>
        </tr>
     </table>
	 
     <table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td style="padding-top: 40px;">
				<input type="submit" name="button" title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value='{$MAP.RETURN_ACTION}'; this.form.module.value='{$MAP.RETURN_MODULE}'; this.form.record.value='{$MAP.RETURN_ID}'" value="{$APP.LBL_CANCEL_BUTTON_LABEL}"> 
				<input id="next_button" type='submit' title="{$APP.LBL_NEXT_BUTTON_LABEL}" class="button" name="next_button" value="{$APP.LBL_NEXT_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
</div>
