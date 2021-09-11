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
{$title}
<div class="history-subpanel-config">
<form name="AdminSettings" method="POST">
    <input type="hidden" name="action" value="historyContactsEmailsSave">
    <input type="hidden" name="module" value="Configurator">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
        <tr>
            <td width="100%" colspan="2" class="action-buttons">
                <input type="submit" id="configuratorHistoryContactsEmails_admin_save"  class="button primary" title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
                <input type="button" id="configuratorHistoryContactsEmails_admin_cancel" onclick="location.href='index.php?module=Administration&amp;action=index';" class="button" title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr>
            <td scope="row" align="right" valign="top" nowrap>{$MOD.LBL_ENABLE_HISTORY_CONTACTS_EMAILS}:</td>
            <td colspan="4" width="95%" style='vertical-align:middle;'>
                <table id="sugarfeed_modulelist" cellspacing=3 border=0>
                    {foreach name=feedModuleList from=$modules item=entry}
                        {if ($smarty.foreach.feedModuleList.index % 2)==0}<tr>{/if}
                        <tr>
                            <td scope="row" align="right">{$entry.label}:</td>
                            <td>
                            <input type="hidden" name="modules[{$entry.module}]" value="0">
                            <input type="checkbox" id="modules[{$entry.module}]" name="modules[{$entry.module}]" value="1" {if $entry.enabled==1}CHECKED{/if}>
                        </td>
                        </tr>     
                        {if ($i % 2)==1}</tr>{/if}
                    {/foreach}
                </table>
            </td></tr>
    </table>
</form>
</div>
