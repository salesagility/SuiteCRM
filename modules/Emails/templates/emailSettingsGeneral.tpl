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

<form name="formEmailSettingsGeneral" id="formEmailSettingsGeneral">
    <table cellpadding="4" class="view emailSettings">
        <tr>
            <th colspan="4" colspan="4" scope="row">
                <h4>{$app_strings.LBL_EMAIL_SETTINGS_TITLE_PREFERENCES}</h4>
            </th>
        </tr>
        <tr>
            <td scope="row">
                {$app_strings.LBL_EMAIL_SETTINGS_CHECK_INTERVAL}:
            </td>
            <td>
                {html_options options=$emailCheckInterval.options selected=$emailCheckInterval.selected name='emailCheckInterval' id='emailCheckInterval'}
            </td>
            <td scope="row">
                {$app_strings.LBL_DEFAULT_EMAIL_SIGNATURES}:
            </td>
            <td>
                {$signaturesSettings} {$signatureButtons}
                <input type="hidden" name="signatureDefault" id="signatureDefault" value="{$signatureDefaultId}">
            </td>
        </tr>
        <tr>
            <td scope="row">
                {$app_strings.LBL_EMAIL_SETTINGS_SEND_EMAIL_AS}:
            </td>
            <td>
                <input class="checkbox" type="checkbox" id="sendPlainText" name="sendPlainText"
                       value="1" {$sendPlainTextChecked} />
            </td>
            <td scope="row">
                {$mod_strings.LBL_SIGNATURE_PREPEND}:
            </td>
            <td>
                <input type="checkbox" name="signature_prepend" {$signaturePrepend}>
            </td>
        </tr>
        <tr>
            <td scope="row">
                {$app_strings.LBL_EMAIL_CHARSET}:
            </td>
            <td>
                {html_options options=$charset.options selected=$charset.selected name='default_charset' id='default_charset'}
            </td>
            <td scope="row">
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
    </table>
    <table cellpadding="4" cellspacing="0" border="0" class="view">
        <tr>
            <th colspan="4">
                <h4>{$app_strings.LBL_EMAIL_SETTINGS_TITLE_LAYOUT}</h4>
            </th>
        </tr>
        <tr>
            <td scope="row" width="20%">
                {$app_strings.LBL_EMAIL_SETTINGS_SHOW_NUM_IN_LIST}:
                <div id="rollover">
                    <a href="#"
                       class="rollover">{sugar_getimage alt=$mod_strings.LBL_HELP name="helpInline" ext=".gif" other_attributes='border="0" '}
                        <span>{$app_strings.LBL_EMAIL_SETTINGS_REQUIRE_REFRESH}</span></a>
                </div>
            </td>
            <td>
                <select name="showNumInList" id="showNumInList">
                    {$showNumInList}
                </select>
            </td>
            <td scope="row">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>

    {include file="modules/Emails/templates/emailSettingsFolders.tpl"}


</form>

