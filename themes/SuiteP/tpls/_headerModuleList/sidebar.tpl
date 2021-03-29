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

<div id='sidebar_container' class="container-fluid sidebar_container">

    <a id="buttontoggle" class="buttontoggle"><span></span></a>

    <div {if $smarty.cookies.sidebartoggle|default:'' == 'collapsed'}style="display:none"{/if}
         class="sidebar">

            <div id="actionMenuSidebar" class="actionMenuSidebar">
                {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                    {if $name == $MODULE_TAB}
                        <ul>
                            {if isset($shortcutTopMenu.$name) && is_array($shortcutTopMenu)
                                && count($shortcutTopMenu.$name) > 0}
                                <h2 class="recent_h3">{$APP.LBL_LINK_ACTIONS}</h2>
                                {foreach from=$shortcutTopMenu.$name item=item}
                                    {if $item.URL == "-"}
                                        <li><a></a><span>&nbsp;</span></li>
                                    {else}
                                        <li class="actionmenulinks" role="presentation">
                                            <a href="{$item.URL}" data-action-name="{$item.MODULE_NAME}">
                                                <div class="side-bar-action-icon">
                                                    <span class="suitepicon suitepicon-action-{$item.MODULE_NAME|lower|replace:'_':'-'}"></span>
                                                </div>
                                                <div class="actionmenulink">{$item.LABEL}</div>
                                            </a>
                                        </li>
                                    {/if}
                                {/foreach}
                            {/if}
                        </ul>
                    {/if}
                {/foreach}
            </div>

            <div id="recentlyViewedSidebar" class="recentlyViewedSidebar">
                {if is_array($recentRecords) && count($recentRecords) > 0}
                <h2 class="recent_h3">{$APP.LBL_LAST_VIEWED}</h2>
                {/if}
                <ul class="nav nav-pills nav-stacked">
                    {foreach from=$recentRecords item=item name=lastViewed}
                        {if $item.module_name != 'Emails' && $item.module_name != 'InboundEmail' && $item.module_name != 'EmailAddresses'}<!--Check to ensure that recently viewed emails or email addresses are not displayed in the recently viewed panel.-->
                            {if $smarty.foreach.lastViewed.index < 5}
                                <div class="recently_viewed_link_container_sidebar">
                                    <li class="recentlinks" role="presentation">
                                        <a title="{sugar_translate module=$item.module_name label=LBL_MODULE_NAME}"
                                           accessKey="{$smarty.foreach.lastViewed.iteration}"
                                           href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}"
                                           class="recent-links-detail">
                                            <span class="suitepicon suitepicon-module-{$item.module_name|lower|replace:'_':'-'}"></span>
                                            <span>{$item.item_summary_short}</span>
                                        </a>
                                        {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.item_id }{/capture}
                                        {if $access}
                                            <a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" class="recent-links-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                        {/if}
                                    </li>
                                </div>
                            {/if}
                        {/if}
                    {/foreach}
                </ul>
            </div>
             <div id="favoritesSidebar" class="favoritesSidebar">
            {if is_array($favoriteRecords) && count($favoriteRecords) > 0}
                <h2 class="recent_h3">{$APP.LBL_FAVORITES}</h2>
            {/if}
                <ul class="nav nav-pills nav-stacked">
                    {foreach from=$favoriteRecords item=item name=lastViewed}
                        {if $smarty.foreach.lastViewed.index < 5}
                        <div class="recently_viewed_link_container_sidebar">
                            <li class="recentlinks" role="presentation">
                                <a title="{$item.module_name}" accessKey="{$smarty.foreach.lastViewed.iteration}" href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}" class="favorite-links-detail">
                                    <span class="suitepicon suitepicon-module-{$item.module_name|lower|replace:'_':'-'}"></span>
                                    <span aria-hidden="true">{$item.item_summary_short}</span>
                                </a>
                                {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.item_id }{/capture}
                                {if $access}
                                    <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" class="favorite-links-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                {/if}
                            </li>
                        </div>
                        {/if}
                    {/foreach}
                </ul>
            </div>
        </div>
    <!--</div>-->
</div>
