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

<script type="text/javascript">
js_iso4217 = {$JS_ISO4217};
</script>
<script type="text/javascript" src="{sugar_getjspath file='modules/Currencies/EditView.js'}"></script>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="edit view">
<tr>
    <td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="15%" scope="row" nowrap><span>{$MOD.LBL_LIST_NAME}: <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
<td width="35%"><span><input name='name' tabindex='1' size='30' maxlength='50' type="text" value="{$NAME}"></span></td>
<td width="15%" scope="row" nowrap><span>{$MOD.LBL_LIST_ISO4217}:&nbsp;{sugar_help text=$MOD.LBL_LIST_ISO4217_HELP}</span></td>
<td width="35%"><span><input name='iso4217' tabindex='1' size='3'
  maxlength='3' type="text" value="{$ISO4217}" onKeyUp='isoUpdate(this);'></span></td>
</tr>
<tr>

</tr>
<tr>
<td width="15%" scope="row" nowrap><span> {$MOD.LBL_LIST_RATE}: <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
<td width="35%"><span><input name='conversion_rate' tabindex='1' size='30' maxlength='50' type="text" value="{$CONVERSION_RATE}">
{sugar_help text=$MOD.LBL_LIST_RATE_HELP }
</span></td>
<td width="15%" scope="row" nowrap><span>{$MOD.LBL_LIST_SYMBOL}: <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></span></td>
<td width="35%"><span><input name='symbol' tabindex='1' size='3' maxlength='50' type="text" value="{$SYMBOL}"></span></td>

</tr>
<tr>

</tr>
<tr>
<td scope="row"><span>{$MOD.LBL_LIST_STATUS}:</span></td>
<td><span><select name='status' tabindex='1'>{$STATUS_OPTIONS}</select> <em>{$MOD.NTC_STATUS}</em></span></td>
</tr></table>
</td>
</tr>
</table>
<input type='hidden' name='record' value='{$ID}'>
</form>
{$JAVASCRIPT}
