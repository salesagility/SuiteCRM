{*
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 *}
<style type="text/css">{literal}
.warn { font-style:italic;
        font-weight:bold;
        color:red;
}{/literal}
</style>

<script type='text/javascript' src='{sugar_getjspath file='include/javascript/popup_helper.js'}'></script>

<div id="{$tableID}_content">
    <table cellpadding='0' cellspacing='0' width='50%' border='0' class='list view'>
        {include file='modules/stic_Import_Validation/tpls/listviewpaginator.tpl'}
        <tr height='20'>
            {counter start=0 name="colCounter" print=false assign="colCounter"}
            {if $displayColumns eq false}
                <th scope='col'  style="text-align: left;" nowrap="nowrap" colspan="{$maxColumns}">{$MOD.LBL_MISSING_HEADER_ROW}</th>
            {else}
                {foreach from=$displayColumns key=colHeader item=label}
                    <th scope='col' nowrap="nowrap">
                        <div style='white-space: nowrap; width:100%; text-align:left;'>
                        {$label}
                        </div>
                    </th>
                    {counter name="colCounter"}
                {/foreach}
            {/if}
        </tr>
        {counter start=$pageData.offsets.current print=false assign="offset" name="offset"}
        {foreach name=rowIteration from=$data key=id item=rowData}
            {counter name="offset" print=false}

            {if $smarty.foreach.rowIteration.iteration is odd}
                {assign var='_rowColor' value=$rowColor[0]}
            {else}
                {assign var='_rowColor' value=$rowColor[1]}
            {/if}
            <tr height='20' class='{$_rowColor}S1'>
                {counter start=0 name="colCounter" print=false assign="colCounter"}
                {foreach from=$rowData key=col item=params}
                    {strip}
                    <td align='left' valign="top">
                        {$params}
                    </td>
                    {/strip}
                    {counter name="colCounter"}
                {/foreach}
                </tr>
        {foreachelse}
        <tr height='20' class='{$rowColor[0]}S1'>
            <td colspan="{$colCounter}">
                <em>{$APP.LBL_NO_DATA}</em>
            </td>
        </tr>
        {/foreach}
    {include file='modules/stic_Import_Validation/tpls/listviewpaginator.tpl'}
    </table>
</div>
