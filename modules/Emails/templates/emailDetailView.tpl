<!--
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/**

 */
-->
<!-- BEGIN: main -->
{$emailTitle}

<P/>

<script type="text/javascript" src="{sugar_getjspath file="modules/Emails/javascript/Email.js"}"></script>
<script type="text/javascript" language="Javascript">
{$JS_VARS}
</script>
<form action="index.php" method="POST" name="DetailView" id="emailDetailView">
    <input type="hidden" name="inbound_email_id" value="{$ID}">
    <input type="hidden" name="type" value="out">
    <input type="hidden" name="email_name" value="{$EMAIL_NAME}">
    <input type="hidden" name="to_email_addrs" value="{$FROM}">
    <input type="hidden" name="module" value="Emails">
    <input type="hidden" name="record" value="{$ID}">
    <input type="hidden" name="isDuplicate" value=false>
    <input type="hidden" name="action">
    <input type="hidden" name="contact_id" value="{$CONTACT_ID}">
    <input type="hidden" name="user_id" value="{$USER_ID}">
    <input type="hidden" name="return_module">
    <input type="hidden" name="return_action">
    <input type="hidden" name="return_id">
    <input type="hidden" name="assigned_user_id">
    <input type="hidden" name="parent_id" value="{$PARENT_ID}">
    <input type="hidden" name="parent_type" value="{$PARENT_TYPE}">
    <input type="hidden" name="parent_name" value="{$PARENT_NAME}">
</form>

<table  border="0" cellspacing="{$GRIDLINE}" cellpadding="0" class="detail view">
	<tr>
		<td  valign="top" scope="row">{$APP.LBL_ASSIGNED_TO}</td>
		<td  valign="top">{$ASSIGNED_TO}</td>
		<td  scope="row">{$MOD.LBL_DATE_SENT}</td>
		<td  colspan="3">{$DATE_START} {$TIME_START}</td>
	</tr>
	<tr>
		<td scope="row">&nbsp;</td>
		<td>&nbsp;</td>
		<td scope="row">{$PARENT_TYPE}</td>
		<td>{$PARENT_NAME}</td>
	</tr>
	<tr>
		<td scope="row">{$MOD.LBL_FROM}</td>
		<td colspan=3>{$FROM}</td>
	</tr>
	<tr>
		<td scope="row">{$MOD.LBL_TO}</td>
		<td colspan='3'>{$TO}</td>
	</tr>
	<tr>
		<td scope="row">{$MOD.LBL_CC}</td>
		<td colspan='3'>{$CC}</td>
	</tr>
	<tr>
		<td scope="row">{$MOD.LBL_BCC}</td>
		<td colspan='3'>{$BCC}</td>
	</tr>
	<tr>
		<td scope="row">{$MOD.LBL_SUBJECT}</td>
		<td colspan='3'>{$NAME}</td>
	</tr>
	<tr>
		<td valign="top" valign="top" scope="row">{$MOD.LBL_BODY}</td>
		<td colspan="3"  style="background-color: #ffffff; color: #000000" >
			<div id="html_div" style="background-color: #ffffff;padding: 5px">{$DESCRIPTION_HTML}</div>
			<input id='toggle_textarea_elem' onclick="toggle_textarea();" type="checkbox" name="toggle_html"/> <label for='toggle_textarea_elem'>{$MOD.LBL_SHOW_ALT_TEXT}</label><br>
			<div id="text_div" style="display: none;background-color: #ffffff;padding: 5px">{$DESCRIPTION}</div>
			<script type="text/javascript" language="Javascript">
				var plainOnly = {$SHOW_PLAINTEXT};
				{literal}
				if(plainOnly == true) {
					document.getElementById("toggle_textarea_elem").checked = true;
					toggle_textarea();
				}
				{/literal}
			</script>
		</td>
	</tr>
	<tr>
		<td valign="top" scope="row">{$MOD.LBL_ATTACHMENTS}</td>
		<td colspan="3">{$ATTACHMENTS}</td>
	</tr>
</table>
{literal}
<script>
$(document).ready(function(){
	SUGAR.themes.actionMenu();
});
</script>
{/literal}

{$SUBPANEL}
<!-- END: main -->
