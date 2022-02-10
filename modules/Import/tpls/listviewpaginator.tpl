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

<tr class='pagination' role='presentation'>
    <td colspan='{$colCount}'>
        <table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
            <tr>
                <td  nowrap='nowrap' width='1%' align="left" class='paginationChangeButtons'>
                {if $pageData.offsets.current != 0}
                    <button type='button' id='listViewStartButton' name='listViewStartButton' title='{$navStrings.start}' class='button' onClick='SUGAR.IV.getTable("{$tableID}",0);'>
                        <img src='{sugar_getimagepath file='start.png'}' alt='{$navStrings.start}' align='absmiddle' border='0'>
                    </button>
                    {else}
                    <button type='button' id='listViewStartButton' name='listViewStartButton' title='{$navStrings.start}' class='button' disabled='disabled'>
                        <img src='{sugar_getimagepath file='start_off.png'}' alt='{$navStrings.start}' align='absmiddle' border='0'>
                    </button>
                {/if}
                {if $pageData.offsets.current != 0 }
                    <button type='button' id='listViewPrevButton' name='listViewPrevButton' title='{$navStrings.previous}' class='button' onClick='SUGAR.IV.getTable("{$tableID}", {$pageData.offsets.previous});'>
                        <img src='{sugar_getimagepath file='previous.png'}' alt='{$navStrings.previous}' align='absmiddle' border='0'>
                    </button>
                    {else}
                    <button type='button' id='listViewPrevButton' name='listViewPrevButton' class='button' title='{$navStrings.previous}' disabled='disabled'>
                        <img src='{sugar_getimagepath file='previous_off.png'}' alt='{$navStrings.previous}' align='absmiddle' border='0'>
                    </button>
                {/if}
                    <span class='pageNumbers'>({if $pageData.offsets.lastOffsetOnPage == 0}0{else}{$pageData.offsets.current+1}{/if} - {$pageData.offsets.lastOffsetOnPage} {$navStrings.of} {$pageData.offsets.total})</span>
                {if $pageData.offsets.next > 0}
                    <button type='button' id='listViewNextButton' name='listViewNextButton' title='{$navStrings.next}' class='button' onClick='SUGAR.IV.getTable("{$tableID}", {$pageData.offsets.next});'>
                        <img src='{sugar_getimagepath file='next.png'}' alt='{$navStrings.next}' align='absmiddle' border='0'>
                    </button>
                {else}
                    <button type='button' id='listViewNextButton' name='listViewNextButton' class='button' title='{$navStrings.next}' disabled='disabled'>
                        <img src='{sugar_getimagepath file='next_off.png'}' alt='{$navStrings.next}' align='absmiddle' border='0'>
                    </button>
                {/if}
                {if $pageData.offsets.next > 0}
                    <button type='button' id='listViewEndButton' name='listViewEndButton' title='{$navStrings.end}' class='button' onClick='SUGAR.IV.getTable("{$tableID}", {$pageData.offsets.last});' >
                        <img src='{sugar_getimagepath file='end.png'}' alt='{$navStrings.end}' align='absmiddle' border='0'>
                    </button>
                {else}
                    <button type='button' id='listViewEndButton' name='listViewEndButton' title='{$navStrings.end}' disabled='disabled' class='button' onClick='SUGAR.IV.getTable("{$tableID}", {$pageData.offsets.last});' >
                        <img src='{sugar_getimagepath file='end_off.png'}' alt='{$navStrings.end}' align='absmiddle' border='0'>
                    </button>
                {/if}
                </td>
                <td nowrap="nowrap" width='2%' class='paginationActionButtons'></td>
            </tr>
        </table>
    </td>
</tr>