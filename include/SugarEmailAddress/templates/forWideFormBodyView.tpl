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

*}
<tr>
    <td scope="row">{$app_strings.LBL_EMAIL_ADDRESSES}: </td>
</tr>

<script type="text/javascript" src="{sugar_getjspath file='include/SugarEmailAddress/SugarEmailAddress.js'}"></script>
<script type="text/javascript">
	var module = '{$module}';
</script>
<tr>
<td colspan="4">
<table style="border-spacing: 0pt;">
	<tr>
		<td  valign="top" NOWRAP>
			<table cellpadding="0" cellspacing="0" border="0" id="{$module}emailAddressesTable{$index}" class="emailaddresses">
				<tbody id="targetBody"></tbody>
				<tr>
					<td>
						<input type=hidden name='emailAddressWidget' value=1>
						<span class="id-ff multiple ownline">
						<button class='button' type='button' id="{$module}{$index}_email_widget_add"
onClick="javascript:SUGAR.EmailAddressWidget.instances.{$module}{$index}.addEmailAddress('{$module}emailAddressesTable{$index}','','');" 
value='{$app_strings.LBL_ADD_BUTTON}'>{sugar_getimage name="id-ff-add" alt=$app_strings.LBL_ID_FF_ADD ext=".png" other_attributes=''}</button>
						</span>					

					</td>
					<td scope="row" NOWRAP>
					    &nbsp;
					</td>
					<td scope="row" NOWRAP>
						{$app_strings.LBL_EMAIL_PRIMARY}
					</td>
					{if $useReplyTo == true}
					<td scope="row" NOWRAP>
						{$app_strings.LBL_EMAIL_REPLY_TO}
					</td>
					{/if}
					{if $useOptOut == true}
					<td scope="row" NOWRAP>
						{$app_strings.LBL_EMAIL_OPT_OUT}
					</td>
					{/if}
					{if $useInvalid == true}
					<td scope="row" NOWRAP>
						{$app_strings.LBL_EMAIL_INVALID}
					</td>
					{/if}
				</tr>
			</table>
		</td>
	</tr>
</table>
<input type="hidden" name="useEmailWidget" value="true">
</td>
</tr>

<script type="text/javascript" language="javascript">
    var table = YAHOO.util.Dom.get("{$module}emailAddressesTable{$index}");
    var eaw = SUGAR.EmailAddressWidget.instances.{$module}{$index} = new SUGAR.EmailAddressWidget("{$module}");
    eaw.emailView = '{$emailView}';
    eaw.emailIsRequired = "{$required}";
    var addDefaultAddress = '{$addDefaultAddress}';
    var prefillEmailAddress = '{$prefillEmailAddresses}';
    var prefillData = {$prefillData};
    if(prefillEmailAddress == 'true') {ldelim}
        eaw.prefillEmailAddresses('{$module}emailAddressesTable{$index}', prefillData);
	{rdelim} else if(addDefaultAddress == 'true') {ldelim}
        eaw.addEmailAddress('{$module}emailAddressesTable{$index}');
	{rdelim}
</script>