{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
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
 */
*}
<!--Start Responsive Top Navigation Menu -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php?module=Home&action=index">{$APP.LBL_BROWSER_TITLE}</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobile_menu">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div id="mobileheader">
                <div id="modulelinks">
                    {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                        {if $name == $MODULE_TAB}
                            <span class="modulename" data-toggle="dropdown"
                                  aria-expanded="false">{sugar_link id="moduleTab_$name" module=$name data=$module}
                            </span>

                                <ul class="dropdown-menu" role="menu">
                                {if $name !='Home'}
                                    {if count($shortcutTopMenu.$name) > 0}
                                       <ul>
                                           {foreach from=$shortcutTopMenu.$name item=item}
                                               {if $item.URL == "-"}
                                                   <li class="mobile-action"><a></a><span>&nbsp;</span></li>
                                               {else}
                                                   <li class="mobile-action"><a href="{$item.URL}">{$item.LABEL}</a></li>
                                               {/if}
                                           {/foreach}
                                       </ul>
                                    {else}
                                        <li class="mobile-action"><a>{$APP.LBL_NO_SHORTCUT_MENU}</a></li>
                                    {/if}
                            {/if}

                                    {if count($recentRecords) > 0}
                                        <li class="recent-links-title" role="presentation">
                                            <a><strong>{$APP.LBL_LAST_VIEWED}</strong></a>
                                        </li>
                                        <li role="presentation">
                                            <ul class="recent-list">
                                                {foreach from=$recentRecords item=item name=lastViewed }
                                                    {if $smarty.foreach.lastViewed.iteration < 4} {* limit to 3 results *}
                                                        <li class="recentlinks" role="presentation">
                                                            <a title="{$item.module_name}"
                                                               accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                               href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}" class="recent-links-detail">
                                                                <img src="{sugar_getimagepath directory='sidebar/modules' file_name=$item.module_name file_extension='svg' file='sidebar/modules/'.$item.module_name.'.svg' }"><span aria-hidden="true">{$item.item_summary_short}</span>
                                                            </a>
                                                            <a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" class="recent-links-edit"><span class=" glyphicon glyphicon-pencil"></a>
                                                        </li>
                                                    {/if}
                                                {/foreach}
                                            </ul>
                                         </li>
                                    {/if}

                                    {if count($favoriteRecords) > 0}
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
                                                                <img src="{sugar_getimagepath directory='sidebar/modules' file_name=$item.module_name file_extension='svg' file='sidebar/modules/'.$item.module_name.'.svg'}"><span aria-hidden="true">{$item.item_summary_short}</span>
                                                            </a>
                                                            <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" class="favorite-links-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
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
        <div class="hidden-xs hidden-sm hidden-md hidden-mdlg" id="bs-example-navbar-collapse-1">
            {if $USE_GROUP_TABS}
                <ul class="nav navbar-nav">
                    {assign var="groupSelected" value=false}
                    {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                        {if $name == $MODULE_TAB}
                            {if $name != 'Home'}
                                <li class="topnav">
                                    <span class="currentTabLeft">&nbsp;</span>
                                    <span class="currentTab">{sugar_link id="moduleTab_$name" module=$name data=$module}</span>
                                    <span>&nbsp;</span>



                                    {* check, is there any recent items *}
                                    {assign var=foundRecents value=false}
                                    {foreach from=$recentRecords item=item name=lastViewed}
                                        {if $item.module_name == $name}
                                            {assign var=foundRecents value=true}
                                        {/if}
                                    {/foreach}


                                    {* check, is there any favorit items *}
                                    {assign var=foundFavorits value=false}
                                    {foreach from=$favoriteRecords item=item name=lastViewed}
                                        {if $item.module_name == $name}
                                            {assign var=foundFavorits value=true}
                                        {/if}
                                    {/foreach}
                                    {if $foundRecents || $foundFavorits || count($shortcutTopMenu.$name) > 0}

                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <ul>
                                                    {if count($shortcutTopMenu.$name) > 0}
                                                        {foreach from=$shortcutTopMenu.$name item=item}
                                                            {if $item.URL == "-"}
                                                                {*<li><a></a><span>&nbsp;</span></li>*}
                                                            {else}
                                                                <li><a href="{$item.URL}"><span class="topnav-fake-icon">{* fakes the space the icon takes *}</span><span aria-hidden="true">{$item.LABEL}</span></a></li>
                                                            {/if}
                                                        {/foreach}
                                                    {/if}
                                                </ul>
                                            </li>

                                            {* when records are found for the current submodule show recent header *}
                                            {counter start=0 name="submoduleRecentRecordsTotal" assign="submoduleRecentRecordsTotal"  print=false}
                                            {foreach from=$recentRecords item=item name=lastViewed}
                                                {if $item.module_name == $name and $submoduleRecentRecordsTotal == 0}
                                                    <li class="recent-links-title"><a><strong>{$APP.LBL_LAST_VIEWED}</strong></a></li>
                                                    {counter name="submoduleRecentRecordsTotal" print=false}
                                                {/if}
                                            {/foreach}
                                                <li>
                                                    <ul>
                                                        {* when records are found for the current submodule show the first 3 records *}
                                                        {counter start=0 name="submoduleRecentRecords" assign="submoduleRecentRecords"  print=false}
                                                        {foreach from=$recentRecords item=item name=lastViewed}
                                                            {if $item.module_name == $name and $submoduleRecentRecords < 3}
                                                                <li class="recentlinks" role="presentation">
                                                                    <a title="{$item.module_name}"
                                                                       accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                                       href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}" class="recent-links-detail">
                                                                        <span aria-hidden="true">{$item.item_summary_short}</span>
                                                                    </a>
                                                                    <a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" class="recent-links-edit"><span class=" glyphicon glyphicon-pencil"></a>
                                                                </li>
                                                                {counter name="submoduleRecentRecords" print=false}
                                                            {/if}
                                                        {/foreach}
                                                    </ul>
                                                </li>





                                            {counter start=0 name="submoduleFavoriteRecordsTotal" assign="submoduleFavoriteRecordsTotal"  print=false}
                                            {foreach from=$favoriteRecords item=item name=lastViewed}
                                                {if $item.module_name == $name and $submoduleFavoriteRecordsTotal == 0}
                                                    <li class="favorite-links-title"><a><strong>{$APP.LBL_FAVORITES}</strong></a></li>
                                                    {counter name="submoduleFavoriteRecordsTotal" print=false}
                                                {/if}
                                            {/foreach}
                                            <li>
                                                <ul>
                                                    {* when records are found for the current submodule show the first 3 records *}
                                                    {counter start=0 name="submoduleFavoriteRecords" assign="submoduleFavoriteRecords" print=false}
                                                    {foreach from=$favoriteRecords item=item name=lastViewed}
                                                        {if $item.module_name == $name and $submoduleFavoriteRecords < 3}
                                                            <li class="favoritelinks" role="presentation">
                                                                <a title="{$item.module_name}"
                                                                   accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                                   href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}" class="favorite-links-detail">
                                                                    <span aria-hidden="true">{$item.item_summary_short}</span>
                                                                </a>
                                                                <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" class="favorite-links-edit"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                                            </li>
                                                            {counter name="submoduleFavoriteRecords" print=false}
                                                        {/if}
                                                    {/foreach}
                                                </ul>
                                            </li>
                                        </ul>

                                    {/if}
                                 </li>
                            {/if}

                        {/if}
                    {/foreach}
                    {foreach from=$groupTabs item=modules key=group name=groupList}
                        {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                        <li class="topnav">
                            <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab">
                            <a href="#" id="grouptab_{$smarty.foreach.groupList.index}" class="dropdown-toggle"
                               data-toggle="dropdown">{$group}</a>
                            <span class="notCurrentTabRight">&nbsp;</span>
                            <ul class="dropdown-menu" role="menu" {if $smarty.foreach.groupList.last} class="All"{/if}>
                                {foreach from=$modules.modules item=module key=modulekey}
                                    <li>
                                        {capture name=moduleTabId assign=moduleTabId}moduleTab_{$smarty.foreach.moduleList.index}_{$module}{/capture}
                                        {sugar_link id=$moduleTabId module=$modulekey data=$module extraparams=$extraparams}
                                    </li>
                                {/foreach}
                                {foreach from=$modules.extra item=submodulename key=submodule}
                                    <li>
                                        <a href="{sugar_link module=$submodule link_only=1 extraparams=$extraparams}">{$submodulename}</a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                    {/foreach}
                </ul>
            {else}

                <ul class="nav navbar-nav navbar-horizontal-fluid">
                    {foreach from=$groupTabs item=modules key=group name=groupList}
                        {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                    {/foreach}

                    <!--nav items with actions -->
                    {foreach from=$modules.modules item=submodulename key=submodule}
                        {if $submodule != "Home"}
                            <li class="topnav with-actions">
                                <span class="notCurrentTabLeft">&nbsp;</span>
                                <span class="dropdown-toggle headerlinks notCurrentTab"> <a href="{sugar_link module=$submodule link_only=1 extraparams=$extraparams}">{$submodulename}</a> </span>
                                <span class="notCurrentTabRight">&nbsp;</span>
                                <ul class="dropdown-menu" role="menu">
                                    {*<li class="action-links-title"><a><strong>{$APP.LBL_LINK_ACTIONS}</strong></a></li>*}
                                    <li>
                                        <ul>
                                            {if count($shortcutTopMenu) > 0}
                                                {foreach from=$shortcutTopMenu.$submodule item=item}
                                                    {if $item.URL == "-"}
                                                        {*<li><a></a><span>&nbsp;</span></li>*}
                                                    {else}
                                                        <li><a href="{$item.URL}"><span class="topnav-fake-icon">{* fakes the space the icon takes *}</span><span aria-hidden="true">{$item.LABEL}</span></a></li>
                                                    {/if}
                                                {/foreach}
                                            {/if}
                                        </ul>
                                    </li>
                                    {* when records are found for the current submodule show recent header *}
                                    {counter start=0 name="submoduleRecentRecordsTotal" assign="submoduleRecentRecordsTotal"  print=false}
                                    {foreach from=$recentRecords item=item name=lastViewed}
                                        {if $item.module_name == $submodule and $submoduleRecentRecordsTotal == 0}
                                            <li class="recent-links-title"><a><strong>{$APP.LBL_LAST_VIEWED}</strong></a></li>
                                            {counter name="submoduleRecentRecordsTotal" print=false}
                                        {/if}
                                    {/foreach}
                                    <li>
                                        <ul>
                                            {* when records are found for the current submodule show the first 3 records *}
                                            {counter start=0 name="submoduleRecentRecords" assign="submoduleRecentRecords"  print=false}
                                            {foreach from=$recentRecords item=item name=lastViewed}
                                                {if $item.module_name == $submodule and $submoduleRecentRecords < 3}
                                                    <li class="recentlinks" role="presentation">
                                                        <a title="{$item.module_name}"
                                                           accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                           href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}" class="recent-links-detail">
                                                            <span aria-hidden="true">{$item.item_summary_short}</span>
                                                        </a>
                                                        <a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" class="recent-links-edit"><span class=" glyphicon glyphicon-pencil"></a>
                                                    </li>
                                                    {counter name="submoduleRecentRecords" print=false}
                                                {/if}
                                            {/foreach}
                                        </ul>
                                    </li>
                                    {* when records are found for the current submodule show favorites header *}
                                    {counter start=0 name="submoduleFavoriteRecordsTotal" assign="submoduleFavoriteRecordsTotal"  print=false}
                                    {foreach from=$favoriteRecords item=item name=lastViewed}
                                        {if $item.module_name == $submodule and $submoduleFavoriteRecordsTotal == 0}
                                            <li class="favorite-links-title"><a><strong>{$APP.LBL_FAVORITES}</strong></a></li>
                                            {counter name="submoduleFavoriteRecordsTotal" print=false}
                                        {/if}
                                    {/foreach}
                                    <li>
                                        <ul>
                                        {* when records are found for the current submodule show the first 3 records *}
                                        {counter start=0 name="submoduleFavoriteRecords" assign="submoduleFavoriteRecords" print=false}
                                        {foreach from=$favoriteRecords item=item name=lastViewed}
                                            {if $item.module_name == $submodule and $submoduleFavoriteRecords < 3}
                                                <li class="favoritelinks" role="presentation">
                                                    <a title="{$item.module_name}"
                                                       accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                       href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}" class="favorite-links-detail">
                                                        <span aria-hidden="true">{$item.item_summary_short}</span>
                                                    </a>
                                                    <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" class="favorite-links-edit"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                                </li>
                                                {counter name="submoduleFavoriteRecords" print=false}
                                            {/if}
                                        {/foreach}
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        {/if}
                    {/foreach}
                    <li class="topnav overflow-toggle-menu">
                        <span class="notCurrentTabLeft">&nbsp;</span>
                        <span class="dropdown-toggle headerlinks notCurrentTab"><a href="#">{$APP.LBL_MORE}</a></span>
                        <span class="notCurrentTabRight">&nbsp;</span>
                        <ul id="overflow-menu" class="dropdown-menu" role="menu">
                            <!--nav items without actions -->
                            {foreach from=$modules.extra item=submodulename key=submodule}
                                <li class="topnav without-actions">
                                    <span class=" notCurrentTab"> <a href="{sugar_link module=$submodule link_only=1 extraparams=$extraparams}">{$submodulename}</a> </span>
                                </li>
                            {/foreach}
                        </ul>
                    </li>
                </ul>
                <div class="hidden hidden-actions"></div>

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

                            navItemMoreLeft = $('.navbar-horizontal-fluid .overflow-toggle-menu').offset().left;
                            navOverflowWidth = $('#overflow-menu').width();
                            offset = navItemMoreLeft + navItemMoreWidth - navOverflowWidth;
                        };
                        $(window).resize(windowResize);
                        windowResize();
                    </script>
                {/literal}

            {/if}
            <div id="globalLinks" class="dropdown nav navbar-nav navbar-right globalLinks-desktop">
                <li id="usermenu" class="user-dropdown" aria-expanded="false">
                    <a>
                        <span class="user_icon"> </span> {$CURRENT_USER}
                        <span class="caret"></span>
                    </a>
                </li>

                <ul class="dropdown-menu user-dropdown" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation">
                        <a href='index.php?module=Users&action=EditView&record={$CURRENT_USER_ID}'>
                            {$APP.LBL_PROFILE}
                        </a>
                    </li>
                    {foreach from=$GCLS item=GCL name=gcl key=gcl_key}
                        <li role="presentation">
                            <a id="{$gcl_key}_link"
                               href="{$GCL.URL}"{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a>
                        </li>
                    {/foreach}
                    <li role="presentation"><a role="menuitem" id="logout_link" href='{$LOGOUT_LINK}'
                                               class='utilsLink'>{$LOGOUT_LABEL}</a></li>
                </ul>
            </div>


            
        </div>

        <!-- Right side of the main navigation -->
        <div class="mobile-bar" id="bs-example-navbar-collapse-1">
            <div id="globalLinks" class="dropdown nav navbar-nav navbar-right">

                <button id="usermenucollapsed" class="dropdown-toggle btn btn-default " data-toggle="dropdown"
                        aria-expanded="true">
                </button>
                <ul class="dropdown-menu user-dropdown" role="menu" aria-labelledby="dropdownMenu2">
                    <li role="presentation">
                        <a href='index.php?module=Users&action=EditView&record={$CURRENT_USER_ID}'>
                            {$APP.LBL_PROFILE}
                        </a>
                    </li>
                    {foreach from=$GCLS item=GCL name=gcl key=gcl_key}
                        <li role="presentation">
                            <a id="{$gcl_key}_link"
                               href="{$GCL.URL}"{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a>
                        </li>
                    {/foreach}
                    <li role="presentation"><a role="menuitem" id="logout_link" href='{$LOGOUT_LINK}'
                                               class='utilsLink'>{$LOGOUT_LABEL}</a></li>
                </ul>
            </div>
            <div id="desktop_notifications" class="dropdown nav navbar-nav navbar-right">
                <button class="alertsButton dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                    <span class="alert_count hidden">0</span>
                </button>
                <div id="alerts" class="dropdown-menu" role="menu">{$APP.LBL_EMAIL_ERROR_VIEW_RAW_SOURCE}</div>
            </div>
            <div id="search" class="dropdown nav navbar-nav navbar-right">
                <button id="searchbutton" class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="true">
                    <!--<span class="glyphicon glyphicon-search"> </span>-->Search
                </button>
                <div class="dropdown-menu" role="menu" aria-labelledby="searchbutton">
                    <form id="searchformdropdown" name='UnifiedSearch' action='index.php'
                          onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
                        <input type="hidden" class="form-control" name="action" value="UnifiedSearch">
                        <input type="hidden" class="form-control" name="module" value="Home">
                        <input type="hidden" class="form-control" name="search_form" value="false">
                        <input type="hidden" class="form-control" name="advanced" value="false">
                        <div class="input-group">
                            <input type="text" class="form-control" name="query_string" id="query_string"
                                   placeholder="{$APP.LBL_SEARCH}..." value="{$SEARCH}"/>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><!--<span class="glyphicon glyphicon-search"
                                                                                    aria-hidden="true"></span>-->Search</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <form id="searchform" class="navbar-form navbar-right" name='UnifiedSearch' action='index.php'
                  onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
                <input type="hidden" class="form-control" name="action" value="UnifiedSearch">
                <input type="hidden" class="form-control" name="module" value="Home">
                <input type="hidden" class="form-control" name="search_form" value="false">
                <input type="hidden" class="form-control" name="advanced" value="false">
                <div class="input-group">
                    <input type="text" class="form-control" name="query_string" id="query_string"
                           placeholder="{$APP.LBL_SEARCH}..." value="{$SEARCH}"/>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><!--<span class="glyphicon glyphicon-search"
                                                                            aria-hidden="true"></span>-->Search</button>
                    </span>
                </div>
            </form>
            <div id="quickcreatetop" class="create dropdown nav navbar-nav navbar-right">
                <a class="dropdown-toggle" aria-expanded="false">
                    {$APP.LBL_CREATE_BUTTON_LABEL}
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="index.php?module=Accounts&action=EditView&return_module=Accounts&return_action=DetailView">{$APP.LBL_QUICK_ACCOUNT}</a>
                    </li>
                    <li>
                        <a href="index.php?module=Contacts&action=EditView&return_module=Contacts&return_action=DetailView">{$APP.LBL_QUICK_CONTACT}</a>
                    </li>
                    <li>
                        <a href="index.php?module=Opportunities&action=EditView&return_module=Opportunities&return_action=DetailView">{$APP.LBL_QUICK_OPPORTUNITY}</a>
                    </li>
                    <li>
                        <a href="index.php?module=Leads&action=EditView&return_module=Leads&return_action=DetailView">{$APP.LBL_QUICK_LEAD}</a>
                    </li>
                    <li>
                        <a href="index.php?module=Documents&action=EditView&return_module=Documents&return_action=DetailView">{$APP.LBL_QUICK_DOCUMENT}</a>
                    </li>
                    <li>
                        <a href="index.php?module=Calls&action=EditView&return_module=Calls&return_action=DetailView">{$APP.LBL_QUICK_CALL}</a>
                    </li>
                    <li class="last">
                        <a href="index.php?module=Tasks&action=EditView&return_module=Tasks&return_action=DetailView">{$APP.LBL_QUICK_TASK}</a>
                    </li>
                </ul>
            </div>
        </div>


        <div class="collapse navbar-collapse" id="mobile_menu">
            {foreach from=$groupTabs item=modules key=group name=groupList}
                {if $smarty.foreach.groupList.last}
                    {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                    {foreach from=$modules.modules item=module key=modulekey}
                        {if $modulekey !='Home' && $modulekey !='Calendar'}
                            <li style="float:right;">
                                <a href="{sugar_link module=$modulekey action='EditView' link_only=1}"><span
                                            class="glyphicon glyphicon-plus"></span></a>
                            </li>
                        {/if}
                        <li>
                            {capture name=moduleTabId assign=moduleTabId}moduleTab_{$smarty.foreach.moduleList.index}_{$module}{/capture}
                            {sugar_link id=$moduleTabId module=$modulekey data=$module extraparams=$extraparams}
                        </li>
                    {/foreach}
                    {foreach from=$modules.extra item=submodulename key=submodule}
                        <li style="float:right;">
                            <a href="{sugar_link module=$modulekey action='EditView' link_only=1}"><span
                                        class="glyphicon glyphicon-plus"></span></a>
                        </li>
                        <li>
                            <a href="{sugar_link module=$submodule link_only=1 extraparams=$extraparams}">{$submodulename}</a>
                        </li>
                    {/foreach}
                {/if}
            {/foreach}            
        </div>
</nav>
<!--End Responsive Top Navigation Menu -->
{if $THEME_CONFIG.display_sidebar}
    <!--Start Page Container and Responsive Sidebar -->
    <div id='sidebar_container' class="container-fluid">

        <a id="buttontoggle"><span></span></a>
                
        <!--<div class="row">-->
            <!--<div {if $smarty.cookies.sidebartoggle == 'collapsed'}style="display:none"{/if}
                 class="col-sm-3 col-md-2 sidebar">-->
             <div {if $smarty.cookies.sidebartoggle == 'collapsed'}style="display:none"{/if}
             class="sidebar">
                
                <div id="actionMenuSidebar">
                    {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                        {if $name == $MODULE_TAB}
                            <ul>
                                {if count($shortcutTopMenu.$name) > 0}
                                    <h2 class="recent_h3">{$APP.LBL_LINK_ACTIONS}</h2>
                                    {foreach from=$shortcutTopMenu.$name item=item}
                                        {if $item.URL == "-"}
                                            <li><a></a><span>&nbsp;</span></li>
                                        {else}
                                            <li class="actionmenulinks" role="presentation">
                                                <a href="{$item.URL}" >
                                                    <div class="side-bar-{$item.MODULE_NAME} side-bar-action-icon"></div>
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
                
                <div id="recentlyViewedSidebar">
                {if count($recentRecords) > 0}
                    <h2 class="recent_h3">{$APP.LBL_LAST_VIEWED}</h2>
                {/if}
                    <ul class="nav nav-pills nav-stacked">
                        {foreach from=$recentRecords item=item name=lastViewed}
                            {if $smarty.foreach.lastViewed.index < 5}
                            <div class="recently_viewed_link_container_sidebar">
                                <li class="recentlinks" role="presentation">
                                    <a title="{$item.module_name}" accessKey="{$smarty.foreach.lastViewed.iteration}" href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}" class="recent-links-detail">
                                        <img src="{sugar_getimagepath directory='sidebar/modules'  file_name=$item.module_name file_extension="svg" file='sidebar/modules/'.$item.module_name.".svg"}"/><span>{$item.item_summary_short}</span>
                                    </a>
                                </li>
                            </div>
                            {/if}
                        {/foreach}
                    </ul>
                </div>
     
                <div id="favoritesSidebar">
                {if count($favoriteRecords) > 0}
                    <h2 class="recent_h3">{$APP.LBL_FAVORITES}</h2>
                {/if}
                    <ul class="nav nav-pills nav-stacked">
                        {foreach from=$favoriteRecords item=item name=lastViewed}
                            {if $smarty.foreach.lastViewed.index < 5}
                            <div class="recently_viewed_link_container_sidebar">
                                <li class="recentlinks" role="presentation">
                                    <a title="{$item.module_name}" accessKey="{$smarty.foreach.lastViewed.iteration}" href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}" class="favorite-links-detail">
                                        <img src="{sugar_getimagepath  directory='sidebar/modules' file_name=$item.module_name file_extension="svg" file='sidebar/modules/'.$item.module_name.".svg"}"/><span aria-hidden="true">{$item.item_summary_short}</span>
                                    </a>
                                </li>
                            </div>
                            {/if}
                        {/foreach}
                    </ul>
                </div>
            </div>
        <!--</div>-->
    </div>
    <!--End Responsive Sidebar -->
{/if}
<!--Start Page content -->
