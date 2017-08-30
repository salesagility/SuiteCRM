{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <!-- Password Security Settings -->
    <tr>
        <th align="left" scope="row" colspan="3"><h4>{$MOD.LBL_PWDSEC_SETS}</h4></th>
    </tr>

    <!-- Password Min Length -->
    <tr>
        <td width="25%" scope="row" valign="middle">
            {$MOD.LBL_PWDSEC_MIN_LENGTH}
            {sugar_help text=$MOD.LBL_PWDSEC_MIN_LENGTH_DESC}
        </td>
        <td valign="middle">
            <input name="passwordsetting_minpwdlength" id="passwordsetting_minpwdlength" type="number"
                   value="{$config.passwordsetting.minpwdlength}">
            {$MOD.LBL_PWDSEC_CHARS}
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>

    <!-- Password should contains uppercase characters -->
    <tr>
        <td width="25%" scope="row" valign="middle">
            {$MOD.LBL_PWDSEC_UPPERCASE}
            {sugar_help text=$MOD.LBL_PWDSEC_UPPERCASE_DESC}
        </td>
        <td valign="middle">
            <input name="passwordsetting_oneupper" id="passwordsetting_oneupper" type="checkbox"
                   {if $config.passwordsetting.oneupper}checked="checked"{/if} value="1">
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>

    <!-- Password should contains lowercase characters -->
    <tr>
        <td width="25%" scope="row" valign="middle">
            {$MOD.LBL_PWDSEC_LOWERCASE}
            {sugar_help text=$MOD.LBL_PWDSEC_LOWERCASE_DESC}
        </td>
        <td valign="middle">
            <input name="passwordsetting_onelower" id="passwordsetting_onelower" type="checkbox"
                   {if $config.passwordsetting.onelower}checked="checked"{/if} value="1">
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>

    <!-- Password should contains numbers -->
    <tr>
        <td width="25%" scope="row" valign="middle">
            {$MOD.LBL_PWDSEC_NUMBERS}
            {sugar_help text=$MOD.LBL_PWDSEC_NUMBERS_DESC}
        </td>
        <td valign="middle">
            <input name="passwordsetting_onenumber" id="passwordsetting_onenumber" type="checkbox"
                   {if $config.passwordsetting.onenumber}checked="checked"{/if} value="1">
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>

    <!-- Password should contains special characters -->
    <tr>
        <td width="25%" scope="row" valign="middle">
            {$MOD.LBL_PWDSEC_SPECCHAR}
            {sugar_help text=$MOD.LBL_PWDSEC_SPECCHAR_DESC}
        </td>
        <td valign="middle">
            <input name="passwordsetting_onespecial" id="passwordsetting_onespecial" type="checkbox"
                   {if $config.passwordsetting.onespecial}checked="checked"{/if} value="1">
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>

</table>