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

<div id='SpotResults'>
{if !empty($displayResults)}
    {foreach from=$displayResults key=module item=data}
    <section>
        <div class="resultTitle">
            {if isset($appListStrings.moduleList[$module])}
                {$appListStrings.moduleList[$module]}
            {else}
                {$module}
            {/if}
            {if !empty($displayMoreForModule[$module])}
                {assign var="more" value=$displayMoreForModule[$module]}
                <br>
                <small class='more' onclick="DCMenu.spotZoom('{$more.query}', '{$module}', '{$more.offset}');">({$more.countRemaining} {$appStrings.LBL_SEARCH_MORE})</small>
            {/if}
        </div>
            <ul>
                {foreach from=$data key=id item=name}
                        <div onmouseover="DCMenu.showQuickViewIcon('{$id}')" onmouseout="DCMenu.hideQuickViewIcon('{$id}')" class="gs_div" style="position: relative" >
                            <div id="gs_div_{$id}" style="position: absolute;left: 0" class="SpanQuickView">
                                    <img id="gs_img_{$id}" class="QuickView" src="themes/default/images/Search.gif" alt="quick_view_{$id}" onclick="DCMenu.showQuickView('{$module}', '{$id}');return false;">

                            </div>

                        <div class="gsLinkWrapper" >
                            <a href="index.php?module={$module}&action=DetailView&record={$id}" class="gs_link">{$name}</a>
                        </div>
                        </div>
                {/foreach}
            </ul>
        <div class="clear"></div>
    </section>
    {/foreach}
    <a href='index.php?module=Home&action=UnifiedSearch&search_form=false&advanced=false&query_string={$queryEncoded}' class="resultAll">
        {$appStrings.LNK_SEARCH_NONFTS_VIEW_ALL}
    </a>
{else}
    <section class="resultNull">
        <h1>{$appStrings.LBL_EMAIL_SEARCH_NO_RESULTS}</h1>
        <div style="float:right;">
            <a href="index.php?module=Home&action=UnifiedSearch&search_form=false&advanced=false&query_string={$queryEncoded}">{$appStrings.LNK_ADVANCED_SEARCH}</a>
        </div>
    </section>
{/if}
</div>
