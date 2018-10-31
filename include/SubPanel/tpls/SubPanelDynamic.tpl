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
{*
 /*
  * This template is now displays to the sub panel
  */
*}
<table cellpadding="0" cellspacing="0" border="0"  data-empty="{$APP.MSG_LIST_VIEW_NO_RESULTS_BASIC}" class="list view table-responsive">
    <thead>
        {$PAGINATION}
        <tr>
            {foreach from=$HEADER_CELLS key=colHeader item=header}
                <th data-type="html">{$header}</th>
            {/foreach}
            <th data-type="html"><!-- extra th for the button --></th>
        </tr>
        <tr id="{$SUBPANEL_ID}_search" class="pagination" style="{$DISPLAY_SPS}">
            <td align="right" colspan="20">
                {$SUBPANEL_SEARCH}
            </td>
        </tr>
    </thead>
    <tbody>
    {foreach from=$ROWS key=rowHeader item=row}
        <tr>
            {foreach from=$row key=colHeader item=cell}
                <td>{$cell}</td>
            {/foreach}
            <td>
                {if $ROWS_BUTTONS.$rowHeader|@count gt 0}
                    {sugar_action_menu id="$rowHeader" buttons=$ROWS_BUTTONS.$rowHeader class="clickMenu subpanel records fancymenu button" flat=false}
                {/if}
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>