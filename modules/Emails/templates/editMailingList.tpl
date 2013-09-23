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

*}
<div class="ydlg-bd">
	<form name="editMailingListForm" id="editMailingListForm">
		<input type="hidden" id="mailing_list_id" name="mailing_list_id" value="{$mailing_list_id}">
	<table>
		<tr>
			<td colspan="2">
				<input type="button" class="button" id="ml_save" 
					value="   {$app_strings.LBL_SAVE_BUTTON_LABEL}   "
					onclick="javascript:SUGAR.email2.addressBook.editMailingListSave();"
				>&nbsp;
				<input type="button" class="button" id="ml_save" 
					value="   {$app_strings.LBL_EMAIL_REVERT}   "
					onclick="javascript:SUGAR.email2.addressBook.editMailingListRevert();"
				>&nbsp;
				<input type="button" class="button" id="ml_cancel" 
					value="   {$app_strings.LBL_CANCEL_BUTTON_LABEL}   "
					onclick="javascript:SUGAR.email2.addressBook.cancelEdit();"
				>
				<br>&nbsp;
			</td>
		</tr>
		<tr>
			<td scope="row">
				<b>{$app_strings.LBL_EMAIL_ML_NAME}</b>
			</td>
			<td >
				<input class="input" name="mailing_list_name" id="mailing_list_name" value="{$mailing_list_name}">
			</td>
		</tr>
		<tr>
			<td scope="row" align="top" height="200">
				<b>{$app_strings.LBL_EMAIL_ML_ADDRESSES_1}</b>
				<br />&nbsp;<br />
				<div id="ml_used" style="overflow:auto; height:90%; margin:5px; padding:2px; border:1px solid #ccc;"></div>
			</td>
			<td scope="row" align="top" height="200">
				<b>{$app_strings.LBL_EMAIL_ML_ADDRESSES_2}</b>
				<br />&nbsp;<br />
				<div id="ml_available" style="overflow:auto; height:90%; margin:5px; padding:2px; border:1px solid #ccc;"></div>
			</td>
		</tr>
	</table>
	</form>
</div>