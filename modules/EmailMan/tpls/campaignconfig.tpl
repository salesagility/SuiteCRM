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
{$ROLLOVER}
<script type="text/javascript" src="{sugar_getjspath file='modules/Users/User.js'}"></script>
<script type="text/javascript">
<!--
{literal}
function change_state(radiobutton) 
{
	if (radiobutton.value == '1') {
		radiobutton.form['massemailer_tracking_entities_location'].disabled=true;
		radiobutton.form['massemailer_tracking_entities_location'].value='{/literal}{$MOD.TRACKING_ENTRIES_LOCATION_DEFAULT_VALUE}{literal}';
	} 
	else {
		radiobutton.form['massemailer_tracking_entities_location'].disabled=false;
		radiobutton.form['massemailer_tracking_entities_location'].value='{/literal}{$SITEURL}{literal}';
	}
}
{/literal}
-->
</script>
<form name="ConfigureSettings" id="EditView" method="POST" >
	<input type="hidden" name="module" value="EmailMan">
	<input type="hidden" name="campaignConfig" value="true">
	<input type="hidden" name="action">
	<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
	<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
	<input type="hidden" name="source_form" value="config" />

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<th align="left" scope="row" colspan="4">
						<h4>
							{$MOD.LBL_OUTBOUND_EMAIL_TITLE}
						</h4>
					</th>
				</tr>
				<tr>
					<td width="40%" scope="row">
						{$MOD.LBL_EMAILS_PER_RUN}&nbsp;<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
					</td>
					<td width="50%" >
						<input name='massemailer_campaign_emails_per_run' tabindex='1' maxlength='128' type="text" value="{$EMAILS_PER_RUN}">
					</td>
				</tr>
				<tr>
					<td scope="row">
						{$MOD.LBL_LOCATION_TRACK}&nbsp;<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
					</td>
					<td >
						<input type='radio' onclick="change_state(this);" name='massemailer_tracking_entities_location_type' value="1" {$default_checked}>
						{$MOD.LBL_DEFAULT_LOCATION}&nbsp;<input type='radio' {$userdefined_checked} onclick="change_state(this);" name='massemailer_tracking_entities_location_type' value="2">{$MOD.LBL_CUSTOM_LOCATION} 
				</tr>
				<tr>
					<td scope="row">
					</td>
					<td >
						<input name='massemailer_tracking_entities_location' {$TRACKING_ENTRIES_LOCATION_STATE} maxlength='128' type="text" value="{$TRACKING_ENTRIES_LOCATION}">
					</td>
				</tr>
				<tr>
					<td scope="row">
					<div id="rollover">
						{$MOD.LBL_CAMP_MESSAGE_COPY}&nbsp;<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
                        <a href="#" class="rollover"><span>{$MOD.LBL_CAMP_MESSAGE_COPY_DESC}</span><img border="0" alt=$mod_strings.LBL_HELP src="index.php?entryPoint=getImage&themeName={$THEME}&imageName=helpInline.gif"></a>
                    </div>
					</td>
					<td >
						<input type='radio' name='massemailer_email_copy' value="1" {$yes_checked}>
						{$MOD.LBL_YES}&nbsp;<input type='radio' {$no_checked} name='massemailer_email_copy' value="2">{$MOD.LBL_NO} 
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<div style="padding-top:2px;">
    <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button" onclick="this.form.action.value='Save';return verify_data(this);" type="submit" name="button" value=" {$APP.LBL_SAVE_BUTTON_LABEL} ">
    <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" class="button" onclick="this.form.action.value='{$RETURN_ACTION}'; this.form.module.value='{$RETURN_MODULE}';" type="submit" name="button" value=" {$APP.LBL_CANCEL_BUTTON_LABEL} ">
</div>

</form>
{$JAVASCRIPT}