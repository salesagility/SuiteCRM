{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
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

<div class="desktop-toolbar" id="toolbar">
    {if $USE_GROUP_TABS}
        <ul class="nav navbar-nav">
            <li class="navbar-brand-container">
                    <a class="navbar-brand with-home-icon suitepicon suitepicon-action-home" href="index.php?module=Home&action=index"></a>
            </li>
            {assign var="groupSelected" value=false}
            {foreach from=$moduleTopMenu item=module key=module_name name=moduleList}
                {if $module_name == $MODULE_TAB}
                    {if $module_name != 'Home'}
                        <li class="topnav">
                            <span class="currentTabLeft">&nbsp;</span>
                            <span class="currentTab">{sugar_link id="moduleTab_$module_name" module=$module_name data=$module}</span>
                            <span>&nbsp;</span>
                            {* check, is there any recent items *}
                            {assign var=foundRecents value=false}
                            {foreach from=$recentRecords item=item name=lastViewed}
                                {if $item.module_name == $module_name}
                                    {assign var=foundRecents value=true}
                                {/if}
                            {/foreach}


                            {* check, is there any favorite items *}
                            {assign var=foundFavorits value=false}
                            {foreach from=$favoriteRecords item=item name=lastViewed}
                                {if $item.module_name == $module_name}
                                    {assign var=foundFavorits value=true}
                                {/if}
                            {/foreach}
                            {if $foundRecents || $foundFavorits
                                || (is_array($shortcutTopMenu.$module_name) && count($shortcutTopMenu.$module_name) > 0)}

                                <ul class="dropdown-menu" role="menu">

                                    {include file="themes/SuiteP/tpls/_headerModuleList/toolbar/action_links.tpl"}

                                    {include file="themes/SuiteP/tpls/_headerModuleList/toolbar/recent_links.tpl"}

                                    {include file="themes/SuiteP/tpls/_headerModuleList/toolbar/favorite_links.tpl"}

                            </ul>

                            {/if}
                         </li>
                    {/if}
                {/if}
            {/foreach}
            {foreach from=$groupTabs item=modules key=group name=groupList}
                {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                <li class="topnav {if $smarty.foreach.groupList.last}all{/if}">
                    <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab">
                    <a href="#" id="grouptab_{$smarty.foreach.groupList.index}" class="dropdown-toggle grouptab">{$group}</a>
                    <span class="notCurrentTabRight">&nbsp;</span>
                    <ul class="dropdown-menu" role="menu" {if $smarty.foreach.groupList.last} class="All"{/if}>
                        {foreach from=$modules.modules item=module key=module_name}
                            <li>
                                {capture name=moduleTabId assign=moduleTabId}moduleTab_{$smarty.foreach.moduleList.index}_{$module}{/capture}
                                {sugar_link id=$moduleTabId module=$module_name data=$module extraparams=$extraparams}
                            </li>
                        {/foreach}
                        {foreach from=$modules.extra item=module_translated key=module_name}
                            <li>
                                <a href="{sugar_link module=$module_name link_only=1 extraparams=$extraparams}">{$module_translated}</a>
                            </li>
                        {/foreach}
                    </ul>
                </li>
            {/foreach}
        </ul>
        {* 7.8 Hide filter menu items when the window is too small to display them *}
    {literal}
        <script>
          var windowResize = function() {
            // Since the height can be changed in Sass.
            // Take a measurement of the initial desktop navigation bar height with just one menu item
            $('.desktop-toolbar ul.navbar-nav > li').not('.all').addClass('hidden');
            var dth = $('.desktop-toolbar').outerHeight();

            // Show all desktop menu items
            $('.desktop-toolbar ul.navbar-nav > li.hidden').removeClass('hidden');

            // Remove the each menu item from the end of the toolbar until
            // the navigation bar is the matches the initial height.
            while($('.desktop-toolbar').outerHeight() > dth) {
              ti = $('.desktop-toolbar ul.navbar-nav > li').not('.hidden').not('.all');
              $(ti).last().addClass('hidden');
            }
          };
          $(window).resize(windowResize);
          $(document).ready(windowResize);
        </script>
    {/literal}
    {else}

        <ul class="nav navbar-nav navbar-horizontal-fluid">
            <li class="navbar-brand-container">
                <a class="navbar-brand with-home-icon" href="index.php?module=Home&action=index">
                    <span class="suitepicon suitepicon-action-home"></span>
                </a>
            </li>
            {foreach from=$groupTabs item=modules key=group name=groupList}
                {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
            {/foreach}

            <!--nav items with actions -->
            {foreach from=$modules.modules item=module_translated key=module_name}
                {if $module_name != "Home"}
                    <li class="topnav with-actions">
                        <span class="notCurrentTabLeft">&nbsp;</span>
                        <span class="dropdown-toggle headerlinks notCurrentTab"> <a href="{sugar_link module=$module_name link_only=1 extraparams=$extraparams}">{$module_translated}</a> </span>
                        <span class="notCurrentTabRight">&nbsp;</span>
                        <ul class="dropdown-menu" role="menu">

                            {include file="themes/SuiteP/tpls/_headerModuleList/toolbar/action_links.tpl"}

                            {include file="themes/SuiteP/tpls/_headerModuleList/toolbar/recent_links.tpl"}

                            {include file="themes/SuiteP/tpls/_headerModuleList/toolbar/favorite_links.tpl"}

                        </ul>
                    </li>
                {/if}
            {/foreach}
            {if count($moduleExtraMenu) > 0}
                <li class="topnav overflow-toggle-menu">
                    <span class="notCurrentTabLeft">&nbsp;</span>
                    <span class="dropdown-toggle headerlinks notCurrentTab"><a href="#">{$APP.LBL_MORE}</a></span>
                    <span class="notCurrentTabRight">&nbsp;</span>
                    <ul id="overflow-menu" class="dropdown-menu" role="menu">
                        <!--nav items without actions -->
                        {foreach from=$modules.extra item=module_translated key=module_name}
                            <li class="topnav without-actions">
                                <span class=" notCurrentTab"> <a href="{sugar_link module=$module_name link_only=1 extraparams=$extraparams}">{$module_translated}</a> </span>
                            </li>
                        {/foreach}
                    </ul>
                </li>
            {/if}
        </ul>
        <div class="hidden hidden-actions"></div>
        {* Hide nav items when the window size is too small to display them *}
        {literal}
            <script>
                var windowResize = function() {
                    // reset navbar
                    var $navCollapsedItems = $('ul#overflow-menu > li.with-actions');
                    if(typeof $navCollapsedItems !== "undefined") {
                        $($navCollapsedItems).each(function() {
                            $(this).addClass('topnav');
                            $(this).insertBefore('.overflow-toggle-menu');
                        });
                    }



                    var $navItemMore = $('.navbar-horizontal-fluid > li.overflow-toggle-menu'),
                            $navItems = $('.navbar-horizontal-fluid > li.with-actions'),
                            navItemMoreWidth = navItemWidth = $navItemMore.width(),
                            windowWidth = $(window).width() - ($(window).width()  * 0.55),
                            navItemMoreLeft, offset, navOverflowWidth;

                    $navItems.each(function() {
                        navItemWidth += $(this).width();
                    });

                    // Remove nav items that are cause the right hand nav-bar items to wrap
                    while (navItemWidth > windowWidth) {
                        navItemWidth -= $navItems.last().width();
                        $navItems.last().removeClass('topnav');
                        $navItems.last().prependTo('#overflow-menu');
                        $navItems.splice(-1,1);
                    }
                    if(typeof $navItemMoreLeft !== "undefined") {
                        navItemMoreLeft = $('.navbar-horizontal-fluid .overflow-toggle-menu').offset().left;
                        navOverflowWidth = $('#overflow-menu').width();
                        offset = navItemMoreLeft + navItemMoreWidth - navOverflowWidth;
                    }
                };
                $(window).resize(windowResize);
                windowResize();
            </script>
        {/literal}

    {/if}
</div>
