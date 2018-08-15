{*
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

*}
<div class="ydlg-bd">
	<form name="editContactForm" id="editContactForm">
		<input type="hidden" id="contact_id" name="contact_id" value="{$contact.id}">
	<table>
		<tr>
			<td colspan="4">
				<input type="button" class="button" id="contact_save" 
					value="   {$app_strings.LBL_SAVE_BUTTON_LABEL}   "
					onclick="javascript:SUGAR.email2.addressBook.saveContact();"
				>&nbsp;
				<input type="button" class="button" id="contact_full_form" 
					value="   {$app_strings.LBL_FULL_FORM_BUTTON_LABEL}   "
					onclick="javascript:SUGAR.email2.addressBook.fullForm('{$contact.id}', '{$contact.module}');"
				>&nbsp;
				<input type="button" class="button" id="contact_cancel" 
					value="   {$app_strings.LBL_CANCEL_BUTTON_LABEL}   "
					onclick="javascript:SUGAR.email2.addressBook.cancelEdit();"
				>
				<br>&nbsp;
			</td>
		</tr>
		<tr>
			<td scope="row">
				<b>{$contact_strings.LBL_FIRST_NAME}</b>
			</td>
			<td >
				<input class="input" name="contact_first_name" id="contact_first_name" value="{$contact.first_name}">
			</td>
			<td scope="row">
				<b>{$contact_strings.LBL_LAST_NAME}</b> <span class="error">*</span>
			</td>
			<td >
				<input class="input" name="contact_last_name" id="contact_last_name" value="{$contact.last_name}">
			</td>
		</tr>
		<tr>
			<td scope="row" colspan="4">
				<b>{$contact_strings.LBL_EMAIL_ADDRESSES}</b>
			</td>
		</tr>
		<tr>
			<td  colspan="4">
				{$emailWidget}
			</td>
		</tr>
		<tr>
			<td scope="row" colspan="4">
				<i>{$app_strings.LBL_EMAIL_EDIT_CONTACT_WARN}</i>
			</td>
		</tr>
	</table>
	</form>
</div>