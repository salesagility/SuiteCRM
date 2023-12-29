{*
*******************************************************************************
 Step 1 of the donation form.
 Ask the main parameters of the form
*******************************************************************************
*}

{literal}
	<style>
		.edit {background-color: transparent !important; margin-top:30px !important;}
		td.check {width: 1%; max-width:150px; text-align: left;}
		td.text {white-space:nowrap; text-align: left; padding-right: 2px; vertical-align: middle;}
	</style>
	<script type="text/javascript">
		function enableRecaptchaConfigs(includeRecaptcha)
		{
			var recaptchaSelected = document.getElementById("recaptcha_selected");
			recaptchaSelected.disabled = !includeRecaptcha.checked;
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
        				<td style="width: 1%; max-width:150px; white-space:nowrap; text-align: left; padding-right: 2px; vertical-align: middle;">{$MOD.LBL_DONATION_WEB_MODULE}:&nbsp;</td>
        		        <td style="text-align: left;">
			    			<select name="web_module" id="web_module">
								{html_options options=$MAP.MODULES selected=$MAP.WEB_MODULE}
							</select>
						</td>
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

     <table width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td style="padding-top: 40px;">
				<input type="submit" name="button" title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value='{$MAP.RETURN_ACTION}'; this.form.module.value='{$MAP.RETURN_MODULE}'; this.form.record.value='{$MAP.RETURN_ID}'" value="{$APP.LBL_CANCEL_BUTTON_LABEL}"> 
				<input id="next_button" type='submit' title="{$APP.LBL_NEXT_BUTTON_LABEL}" class="button" name="next_button" value="{$APP.LBL_NEXT_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
</div>
