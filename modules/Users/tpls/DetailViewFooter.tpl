<!--
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

-->
<!-- END METADATA SECTION -->
            <div id='email_options'>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail view">
                    <tr>
                        <th align="left" scope="row" colspan="4">
                            <h4>{$MOD.LBL_MAIL_OPTIONS_TITLE}</h4>
                        </th>
                    </tr>
                    <tr>
                        <td align="top" scope="row" width="15%">
                            {$MOD.LBL_EMAIL|strip_semicolon}:
                        </td>
                        <td align="top" width="85%">
                            {$NEW_EMAIL}
                        </td>
                    </tr>
                    <tr id="email_options_link_type">
                        <td align="top"  scope="row">
                            {$MOD.LBL_EMAIL_LINK_TYPE|strip_semicolon}:
                        </td>
                        <td >
                            {$EMAIL_LINK_TYPE}
                        </td>
                    </tr>
                    {if !$HIDE_IF_CAN_USE_DEFAULT_OUTBOUND}
                    <tr>
                        <td scope="row" width="15%">
                            {$MOD.LBL_EMAIL_PROVIDER|strip_semicolon}:
                        </td>
                        <td width="35%">
                            {$mail_smtpserver}
                        </td>
                    </tr>
                    <tr>
                        <td align="top"  scope="row">
                            {$MOD.LBL_MAIL_SMTPUSER|strip_semicolon}:
                        </td>
                        <td width="35%">
                            {$mail_smtpuser}
                        </td>
                    </tr>
                    {/if}
                </table>
            </div>
        </div>
        <div>
        <div id="settings">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail view">
                <tr>
                <th colspan='4' align="left" width="100%" valign="top"><h4><slot>{$MOD.LBL_USER_SETTINGS}</slot></h4></th>
                </tr>
                <tr>
                <td scope="row"><slot>{$MOD.LBL_RECEIVE_NOTIFICATIONS|strip_semicolon}:</slot></td>
                <td><slot><input class="checkbox" type="checkbox" disabled {$RECEIVE_NOTIFICATIONS}></slot></td>
                <td><slot>{$MOD.LBL_RECEIVE_NOTIFICATIONS_TEXT}&nbsp;</slot></td>
                </tr>
                <tr>
                <td scope="row" valign="top"><slot>{$MOD.LBL_REMINDER|strip_semicolon}:</td>
                <td valign="top" nowrap><slot>{include file="modules/Meetings/tpls/reminders.tpl"}</slot></td>
                <td ><slot>{$MOD.LBL_REMINDER_TEXT}&nbsp;</slot></td>

                </tr>
                <tr>
                <td valign="top" scope="row"><slot>{$MOD.LBL_MAILMERGE|strip_semicolon}:</slot></td>
                <td valign="top" nowrap><slot><input tabindex='3' name='mailmerge_on' disabled class="checkbox" type="checkbox" {$MAILMERGE_ON}></slot></td>
                <td><slot>{$MOD.LBL_MAILMERGE_TEXT}&nbsp;</slot></td>
                </tr>
                <tr>
                <td valign="top" scope="row"><slot>{$MOD.LBL_SETTINGS_URL|strip_semicolon}:</slot></td>
                <td valign="top" nowrap><slot>{$SETTINGS_URL}</slot></td>
                <td><slot>{$MOD.LBL_SETTINGS_URL_DESC}&nbsp;</slot></td>
                </tr>
                <tr>
                <td scope="row" valign="top"><slot>{$MOD.LBL_EXPORT_DELIMITER|strip_semicolon}:</slot></td>
                <td><slot>{$EXPORT_DELIMITER}</slot></td>
                <td><slot>{$MOD.LBL_EXPORT_DELIMITER_DESC}</slot></td>
                </tr>
                <tr>
                <td scope="row" valign="top"><slot>{$MOD.LBL_EXPORT_CHARSET|strip_semicolon}:</slot></td>
                <td><slot>{$EXPORT_CHARSET_DISPLAY}</slot></td>
                <td><slot>{$MOD.LBL_EXPORT_CHARSET_DESC}</slot></td>
                </tr>
                <tr>
                <td scope="row" valign="top"><slot>{$MOD.LBL_USE_REAL_NAMES|strip_semicolon}:</slot></td>
                <td><slot><input tabindex='3' name='use_real_names' disabled class="checkbox" type="checkbox" {$USE_REAL_NAMES}></slot></td>
                <td><slot>{$MOD.LBL_USE_REAL_NAMES_DESC}</slot></td>
                </tr>
                {if $DISPLAY_EXTERNAL_AUTH}
                <tr>
                  <td scope="row" valign="top"><slot>{$EXTERNAL_AUTH_CLASS|strip_semicolon}:</slot></td>
                  <td valign="top" nowrap><slot><input id="external_auth_only" name="external_auth_only" type="checkbox" class="checkbox" {$EXTERNAL_AUTH_ONLY_CHECKED}></slot></td>
                  <td><slot>{$MOD.LBL_EXTERNAL_AUTH_ONLY} {$EXTERNAL_AUTH_CLASS}</slot></td>
                </tr>
                {/if}
            </table>
        </div>

        <div id='locale'>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail view">
                <tr>
                    <th colspan='4' align="left" width="100%" valign="top">
                        <h4><slot>{$MOD.LBL_USER_LOCALE}</slot></h4></th>
                </tr>
                <tr>
                    <td width="15%" scope="row"><slot>{$MOD.LBL_DATE_FORMAT|strip_semicolon}:</slot></td>
                    <td><slot>{$DATEFORMAT}&nbsp;</slot></td>
                    <td><slot>{$MOD.LBL_DATE_FORMAT_TEXT}&nbsp;</slot></td>
                </tr>
                <tr>
                    <td width="15%" scope="row"><slot>{$MOD.LBL_TIME_FORMAT|strip_semicolon}:</slot></td>
                    <td><slot>{$TIMEFORMAT}&nbsp;</slot></td>
                    <td><slot>{$MOD.LBL_TIME_FORMAT_TEXT}&nbsp;</slot></td>
                </tr>
                <tr>
                    <td width="15%" scope="row"><slot>{$MOD.LBL_TIMEZONE|strip_semicolon}:</slot></td>
                    <td nowrap><slot>{$TIMEZONE}&nbsp;</slot></td>
                    <td><slot>{$MOD.LBL_ZONE_TEXT}&nbsp;</slot></td>
                </tr>
                <tr>
                    <td width="15%" scope="row"><slot>{$MOD.LBL_CURRENCY|strip_semicolon}:</slot></td>
                    <td><slot>{$CURRENCY_DISPLAY}&nbsp;</slot></td>
                    <td><slot>{$MOD.LBL_CURRENCY_TEXT}&nbsp;</slot></td>
                </tr>
                <tr>
                    <td width="15%" scope="row"><slot>{$MOD.LBL_CURRENCY_SIG_DIGITS|strip_semicolon}:</slot></td>
                    <td><slot>{$CURRENCY_SIG_DIGITS}&nbsp;</slot></td>
                    <td><slot>{$MOD.LBL_CURRENCY_SIG_DIGITS_DESC}&nbsp;</slot></td>
                </tr>
                <tr>
                    <td width="15%" scope="row"><slot>{$MOD.LBL_NUMBER_GROUPING_SEP|strip_semicolon}:</slot></td>
                    <td><slot>{$NUM_GRP_SEP}&nbsp;</slot></td>
                    <td><slot>{$MOD.LBL_NUMBER_GROUPING_SEP_TEXT}&nbsp;</slot></td>
                </tr><tr>
                    <td width="15%" scope="row"><slot>{$MOD.LBL_DECIMAL_SEP|strip_semicolon}:</slot></td>
                    <td><slot>{$DEC_SEP}&nbsp;</slot></td>
                    <td><slot></slot>{$MOD.LBL_DECIMAL_SEP_TEXT}&nbsp;</td>
                </tr>
                </tr><tr>
                    <td width="15%" scope="row"><slot>{$MOD.LBL_LOCALE_DEFAULT_NAME_FORMAT|strip_semicolon}:</slot></td>
                    <td><slot>{$NAME_FORMAT}&nbsp;</slot></td>
                    <td><slot></slot>{$MOD.LBL_LOCALE_NAME_FORMAT_DESC}&nbsp;</td>
                </tr>
            </table>
        </div>


        <div id='calendar_options'>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail view">
            <tr>
            <th colspan='4' align="left" width="100%" valign="top"><h4><slot>{$MOD.LBL_CALENDAR_OPTIONS}</slot></h4></th>
            </tr>
            <tr>
            <td width="15%" scope="row"><slot>{$MOD.LBL_PUBLISH_KEY|strip_semicolon}:</slot></td>
            <td width="20%"><slot>{$CALENDAR_PUBLISH_KEY}&nbsp;</slot></td>
            <td width="65%"><slot>{$MOD.LBL_CHOOSE_A_KEY}&nbsp;</slot></td>
            </tr>
            <tr>
            <td width="15%" scope="row"><slot><nobr>{$MOD.LBL_YOUR_PUBLISH_URL|strip_semicolon}:</nobr></slot></td>
            <td colspan=2>{if $CALENDAR_PUBLISH_KEY}{$CALENDAR_PUBLISH_URL}{else}{$MOD.LBL_NO_KEY}{/if}</td>
            </tr>
            <tr>
            <td width="15%" scope="row"><slot>{$MOD.LBL_SEARCH_URL|strip_semicolon}:</slot></td>
            <td colspan=2><slot>{if $CALENDAR_PUBLISH_KEY}{$CALENDAR_SEARCH_URL}{else}{$MOD.LBL_NO_KEY}{/if}</slot></td>
            </tr>
            <tr>
            <td width="15%" scope="row"><slot>{$MOD.LBL_ICAL_PUB_URL|strip_semicolon}: {sugar_help text=$MOD.LBL_ICAL_PUB_URL_HELP}</slot></td>
            <td colspan=2><slot>{if $CALENDAR_PUBLISH_KEY}{$CALENDAR_ICAL_URL}{else}{$MOD.LBL_NO_KEY}{/if}</slot></td>
            </tr>
            <tr>
            <td width="15%" scope="row"><slot>{$MOD.LBL_FDOW|strip_semicolon}:</slot></td>
            <td><slot>{$FDOWDISPLAY}&nbsp;</slot></td>
            <td><slot></slot>{$MOD.LBL_FDOW_TEXT}&nbsp;</td>
            </tr>
            </table>
        </div>
        <div id='edit_tabs'>
            <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="detail view">
            <tr>
            <th colspan='4' align="left" width="100%" valign="top"><h4><slot>{$MOD.LBL_LAYOUT_OPTIONS}</slot></h4></th>
            </tr>
            <tr>
            <td width="15%" scope="row"><slot>{$MOD.LBL_USE_GROUP_TABS|strip_semicolon}:</slot></td>
            <td><slot><input class="checkbox" type="checkbox" disabled {$USE_GROUP_TABS}></slot></td>
            <td><slot>{$MOD.LBL_NAVIGATION_PARADIGM_DESCRIPTION}&nbsp;</slot></td>
            </tr>
            <tr>
            <td width="15%" scope="row"><slot>{$MOD.LBL_SUBPANEL_TABS|strip_semicolon}:</slot></td>
            <td><slot><input class="checkbox" type="checkbox" disabled {$SUBPANEL_TABS}></slot></td>
            <td><slot>{$MOD.LBL_SUBPANEL_TABS_DESCRIPTION}&nbsp;</slot></td>
            </tr>
            </table>
        </div>
    </div>
{if $SHOW_ROLES}
    {$ROLE_HTML}
{else}
</div>
{/if}
