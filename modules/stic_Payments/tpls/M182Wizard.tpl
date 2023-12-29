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
{* /*****************************************
.tpl template of 182 Model
****************************************/ *}
{literal}
    <style>
        #payment_type option:empty {
            display: none;
        }

    .letter13 {
        font-size: 13px;
    }

    .letter10 {
        font-size: 10px;
    }

    td,
    th {
        text-align: left;
        padding: 3px;
        padding-right: 50px;
    }
</style>
{/literal}

<table width="100%">
    <tr>
        {*TITLE*} <th style="text-align:left">
            <h2>{$MOD.LBL_M182_TITLE}</h2>
        </th>
    </tr>
</table>


{if $VAL.MISSING_SETTINGS|@count gt 0 }
<p style="text-align:left;color:#d5061e;font-weight:bold;">{$MOD.LBL_M182_MISSING_SETTINGS}:
    <br>
<ul>
    {foreach from=$VAL.MISSING_SETTINGS item=it}
    <li>{$it}</li>
    {/foreach}
</ul>
{else}

<br>
{*INSTRUCTIONS*}
{if $ERR.ERROR_TYPE== 0}
<p style="text-align:left;color:#000000;" class="wizard_info letter13">{$MOD.LBL_M182_INSTRUCT}</p> {/if}
{if $ERR.ERROR_TYPE== 1} <p style="text-align:left;color:#d5061e;" class="wizard_info letter13">{$MOD.LBL_M182_INSTRUCT}</p> {/if}

<br>
<form name="stic_Payments" method="POST">
    <input type="hidden" id="module" name="module" value="stic_Payments">
    <input type="hidden" id="action" name="action" value="createModel182">

    <table border="0" cellspacing="5">
        <br>
        {*TYPE OF PAYMENTS*}
        <select required id="payment_type" name="payment_type[]" multiple="multiple">
            {html_options values=$LAB.PAYMENT_TYPE_VALUES output=$INT.PAYMENT_TYPE_OUTPUT}
        </select>
    </table>

    <table width="100%">
        {*BUTTONS*}
        <tr>
            <br><br>
            <td align="left" style="padding-bottom: 2px;">
                <input title="{$MOD.LBL_M182_BACK}" class="button" type="reset" value="{$MOD.LBL_M182_BACK}">
                <input id="send_wizard" title="{$MOD.LBL_M182_NEXT}" class="button" type="submit" value="{$MOD.LBL_M182_NEXT}">
            </td>
        </tr>
    </table>

</form>

<script type="text/javascript">
                {literal}
    $('#send_wizard').on('click', function() {
        if ($('#payment_type option:selected').length == 0) {
            $('.wizard_info').css('color', 'red').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
            return false;
        }
    });

                {/literal}
</script>
{/if}