{*
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
 *}

 <div id='detailpanel_report' class='detail view  detail508 expanded' style="overflow:auto">
    {counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
    <h4>
        <a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel('report');">
            <img border="0" id="detailpanel_report_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
        <a href="javascript:void(0)" class="expandLink" onclick="expandPanel('report');">
            <img border="0" id="detailpanel_report_img_show" src="{sugar_getimagepath file="advanced_search.gif"}"></a>
        {sugar_translate label='LBL_REPORT' module='AOR_MatrixReporting'}
        <script>
          document.getElementById('detailpanel_report').className += ' expanded';
        </script>
    </h4>

    <table id='FIELDS' class="panelContainer table table-bordered" border="1" cellspacing='{$gridline}'>
        <tbody>
        <tr>
            {foreach from=$header key=name item=title}
                {if $title|is_array}
                    <td colspan="{$level1Break}">
                        {$name}
                    </td>
                {else}
                    <td>
                        {$title}
                    </td>
                {/if}
            {/foreach}
        </tr>
        {if $level2 == "true"}
            <tr>
                {foreach from=$header key=name item=title}
                    {if $title|is_array}
                        {foreach from=$title key=subname item=subtitle}
                            {if $subtitle|is_array}
                                <td colspan="{$subtitle|@count}">{$subname}</td>
                            {else}
                                <td>{$subtitle}</td>
                            {/if}
                        {/foreach}
                    {else}
                        <td></td>
                    {/if}
                {/foreach}
            </tr>
        {/if}
        {if $level3 == "true"}
            <tr>
                {foreach from=$header key=name item=title}
                    {if $title|is_array}
                        {foreach from=$title key=name item=subtitle}
                            {if $subtitle|is_array}
                                {foreach from=$subtitle key=name item=subsubtitle}
                                    <td colspan="">{$subsubtitle}</td>
                                {/foreach}
                            {else}
                                <td></td>
                            {/if}
                        {/foreach}
                    {else}
                        <td></td>
                    {/if}
                {/foreach}
            </tr>
        {/if}
        </tbody>

        {foreach from=$data key=name item=group}
            <tbody>
            <tr>
                {foreach from=$group key=field item=value}
                    <td>
                        {$value}
                    </td>
                {/foreach}
            </tr>

            </tbody>
        {/foreach}
        <tbody>
        <tr>
            {foreach from=$counts key=totalkey item=totalvalue}
                <td><b>{$totalvalue}</b></td>
            {/foreach}
        </tr>
        </tbody>
    </table>
    <script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() {ldelim} initPanel('report', 'expanded'); {rdelim}); </script>
</div>

