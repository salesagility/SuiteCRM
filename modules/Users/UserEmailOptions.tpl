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
<div id="email_options">
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr>
            <th align="left" scope="row" colspan="4">
                <h4>{$MOD.LBL_MAIL_OPTIONS_TITLE}</h4>
                <strong style="float: left;">{$MOD.LBL_EMAIL}</strong>
            </th>
        </tr>
        <tr>
            <td scope="row" width="17%">
                {$MOD.LBL_EMAIL}:  {if $REQUIRED_EMAIL_ADDRESS}<span class="required" id="mandatory_email">{$APP.LBL_REQUIRED_SYMBOL}</span> {/if}
            </td>
            <td>
                {$NEW_EMAIL}
            </td>
        </tr>
        <tr id="email_options_link_type" style='display:{$HIDE_FOR_GROUP_AND_PORTAL}'>
            <td scope="row" width="17%">
                {$MOD.LBL_EMAIL_LINK_TYPE}:&nbsp;{sugar_help text=$MOD.LBL_EMAIL_LINK_TYPE_HELP WIDTH=450}
            </td>
            <td>
                <select id="email_link_type" name="email_link_type" tabindex='410'>
                    {$EMAIL_LINK_TYPE}
                </select>
            </td>
        </tr>
        {if !$HIDE_IF_CAN_USE_DEFAULT_OUTBOUND}
            <tr id="mail_smtpserver_tr">
                <td width="20%" scope="row"><span id="mail_smtpserver_label">{$MOD.LBL_EMAIL_PROVIDER}</span></td>
                <td width="30%" ><slot>{$mail_smtpdisplay}<input id='mail_smtpserver' name='mail_smtpserver' type="hidden" value='{$mail_smtpserver}' /></slot></td>
                <td>&nbsp;</td>
                <td >&nbsp;</td>
            </tr>
            {if !empty($mail_smtpauth_req) }

                <tr id="mail_smtpuser_tr">
                    <td width="20%" scope="row" nowrap="nowrap"><span id="mail_smtpuser_label">{$MOD.LBL_MAIL_SMTPUSER}</span></td>
                    <td width="30%" ><slot><input type="text" id="mail_smtpuser" name="mail_smtpuser" size="25" maxlength="64" value="{$mail_smtpuser}" tabindex='1' ></slot></td>
                    <td>&nbsp;</td>
                    <td >&nbsp;</td>
                </tr>
                <tr id="mail_smtppass_tr">
                    <td width="20%" scope="row" nowrap="nowrap"><span id="mail_smtppass_label">{$MOD.LBL_MAIL_SMTPPASS}</span></td>
                    <td width="30%" ><slot>
                            <input type="password" id="mail_smtppass" name="mail_smtppass" size="25" maxlength="64" value="{$mail_smtppass}" tabindex='1'>
                            <a href="javascript:void(0)" id='mail_smtppass_link' onClick="SUGAR.util.setEmailPasswordEdit('mail_smtppass')" style="display: none">{$APP.LBL_CHANGE_PASSWORD}</a>
                        </slot></td>
                    <td>&nbsp;</td>
                    <td >&nbsp;</td>
                </tr>
            {/if}

            <tr id="test_outbound_settings_tr">
                <td width="17%" scope="row"><input type="button" class="button" value="{$APP.LBL_EMAIL_TEST_OUTBOUND_SETTINGS}" onclick="startOutBoundEmailSettingsTest();"></td>
                <td width="33%" >&nbsp;</td>
                <td width="17%">&nbsp;</td>
                <td width="33%" >&nbsp;</td>
            </tr>
        {/if}
    </table>
</div>