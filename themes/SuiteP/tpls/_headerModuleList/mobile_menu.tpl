{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2020 SalesAgility Ltd.
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

<div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="dropdown">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <ul class="dropdown-menu mobile_menu" role="menu" id="mobile_menu">
        {foreach from=$groupTabs item=modules key=group name=groupList}
            {if $smarty.foreach.groupList.last}
                {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                {foreach from=$modules.modules item=module key=modulekey}
                    <li role="presentation" data-test="1">
                        {capture name=moduleTabId assign=moduleTabId}moduleTab_{$smarty.foreach.moduleList.index}_{$module}{/capture}
                        <a href="javascript:void(0)" onclick="window.location.href = '{sugar_link id=$moduleTabId module=$modulekey link_only=1 data=$module extraparams=$extraparams}'">
                            {$module}
                            {if $modulekey !='Home' && $modulekey !='Calendar'}
                                <span class="glyphicon glyphicon-plus"  onclick="window.location.href = 'index.php?action=EditView&module={$modulekey}'"></span>
                                {*<span class="glyphicon glyphicon-plus"  onclick="window.location.href = 'http://google.com'"></span>*}
                            {/if}
                        </a>
                    </li>
                {/foreach}
                {foreach from=$modules.extra item=submodulename key=submodule}
                    <li role="presentation" data-test="2">
                        <a href="javascript:void(0)" onclick="window.location.href = '{sugar_link module=$submodule link_only=1 extraparams=$extraparams}'">
                            {$submodulename}
                            <span class="glyphicon glyphicon-plus"  onclick="window.location.href = 'index.php?action=EditView&module={$submodule}'"></span>
                            {*<span class="glyphicon glyphicon-plus"  onclick="window.location.href = 'http://google.com'"></span>*}
                        </a>
                    </li>
                {/foreach}
            {/if}
        {/foreach}
    </ul>
    <div id="mobileheader" class="mobileheader">
        <div id="modulelinks" class="modulelinks">
            {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                {if $name == $MODULE_TAB}
                    <span class="modulename" data-toggle="dropdown" aria-expanded="false">
                        {sugar_link id="moduleTab_$name" module=$name data=$module caret=true}
                    </span>
                    <ul class="dropdown-menu" role="menu">
                        {if $name !='Home'}
                        {if is_array($shortcutTopMenu.$name) && count($shortcutTopMenu.$name) > 0}
                            <li class="mobile-current-actions" role="presentation">
                               <ul class="mobileCurrentTab">
                                   {foreach from=$shortcutTopMenu.$name item=item}
                                       {if $item.URL == "-"}
                                           <li class="mobile-action"><a></a><span>&nbsp;</span></li>
                                       {else}
                                           <li class="mobile-action"><a href="{$item.URL}">{$item.LABEL}</a></li>
                                       {/if}
                                   {/foreach}
                               </ul>
                            </li>
                        {else}
                            <li class="mobile-action"><a>{$APP.LBL_NO_SHORTCUT_MENU}</a></li>
                        {/if}
                        {/if}

                        {if is_array($recentRecords) && count($recentRecords) > 0}
                            <li class="recent-links-title" role="presentation">
                                <a><strong>{$APP.LBL_LAST_VIEWED}</strong></a>
                            </li>
                            <li role="presentation">
                                <ul class="recent-list">
                                    {foreach from=$recentRecords item=item name=lastViewed }
                                        {if $smarty.foreach.lastViewed.iteration < 4} {* limit to 3 results *}
                                            <li class="recentlinks" role="presentation">
                                                <a title="{sugar_translate module=$item.module_name label=LBL_MODULE_NAME}"
                                                   accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                   href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}" class="recent-links-detail">
                                                    <span class="suitepicon suitepicon-module-{$item.module_name|lower|replace:'_':'-'}"></span>
                                                    <span aria-hidden="true">{$item.item_summary_short}</span>
                                                </a>
                                                {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.item_id }{/capture}
                                                {if $access}
                                                     <a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" class="recent-links-edit"><span class=" glyphicon glyphicon-pencil"></a>
                                                {/if}
                                            </li>
                                        {/if}
                                    {/foreach}
                                </ul>
                             </li>
                        {/if}

                        {if is_array($favoriteRecords) && count($favoriteRecords) > 0}
                            <li class="favorite-links-title" role="presentation">
                                <a><strong>{$APP.LBL_FAVORITES}</strong></a>
                            </li>
                            <li>
                                <ul class="favorite-list">
                                    {foreach from=$favoriteRecords item=item name=lastViewed}
                                        {if $smarty.foreach.lastViewed.iteration < 4} {* limit to 3 results *}
                                            <li class="favoritelinks" role="presentation">
                                                <a title="{$item.module_name}"
                                                   accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                   href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}"  class="favorite-links-detail">
                                                    <span class="suitepicon suitepicon-module-{$item.module_name|lower|replace:'_':'-'}"></span>
                                                    <span aria-hidden="true">{$item.item_summary_short}</span>
                                                </a>
                                                {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.item_id }{/capture}
                                                {if $access}
                                                    <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" class="favorite-links-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                                {/if}
                                            </li>
                                        {/if}
                                    {/foreach}
                                </ul>
                            </li>
                        {/if}
                    </ul>
                {/if}
            {/foreach}
        </div>
    </div>
</div>
