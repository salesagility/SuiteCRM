{*
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * this program; if not, see ttp://www.gnu.org/licenses or write to the Free
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

*}
<!--Start Responsive Top Navigation Menu -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">{$APP.LBL_BROWSER_TITLE}</a>
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
                            <span class="modulename" data-toggle="dropdown" aria-expanded="false">{sugar_link id="moduleTab_$name" module=$name data=$module}</span>
                            {if $name !='Home'}
                                <ul class="dropdown-menu" role="menu">
                                    {if count($shortcutTopMenu.$name) > 0}
                                        {foreach from=$shortcutTopMenu.$name item=item}
                                            {if $item.URL == "-"}
                                                <li><a></a><span>&nbsp;</span></li>
                                            {else}
                                                <li><a href="{$item.URL}">{$item.LABEL}</a></li>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                </ul>
                            {/if}
                        {/if}
                    {/foreach}
                </div>
                <form id="searchmobile" onsubmit="return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()" action="index.php" name="UnifiedSearch">
                    <input class="form-control" type="hidden" value="UnifiedSearch" name="action">
                    <input class="form-control" type="hidden" value="Home" name="module">
                    <input class="form-control" type="hidden" value="false" name="search_form">
                    <input class="form-control" type="hidden" value="false" name="advanced">
                <span class="input-group-btn">
                    <input id="query_string" class="form-control" type="text" placeholder="Search..." name="query_string">
                </span>
                </form>
                <div id="mobilegloballinks">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-option-vertical"></span></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        {foreach from=$GCLS item=GCL name=gcl key=gcl_key}
                            <li role="presentation">
                                <a id="{$gcl_key}_link" href="{$GCL.URL}"{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a>
                            </li>
                        {/foreach}
                        <li role="presentation"><a role="menuitem" id="logout_link" href='{$LOGOUT_LINK}' class='utilsLink'>{$LOGOUT_LABEL}</a></li>
                    </ul>
                </div>
                <div id="userlinks_head" class="navbar-toggle collapsed">
                    <a href="javascript:void(0)" id="userlinks_togglemobilesearch"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                </div>
            </div>
        </div>
        <div class="hidden-xs hidden-sm" id="bs-example-navbar-collapse-1">
            {if $USE_GROUP_TABS}
                <ul class="nav navbar-nav">
                    {assign var="groupSelected" value=false}
                    {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                        {if $name == $MODULE_TAB}
                            <li class="topnav">
                                {if $name != 'Home'}
                                    <span class="currentTabLeft">&nbsp;</span>
                                    <span class="currentTab" style="color:#ffffff !important;">{sugar_link id="moduleTab_$name" module=$name data=$module}</span><span>&nbsp;</span>
                                {/if}
                                <ul class="dropdown-menu" role="menu">
                                    {if count($shortcutTopMenu.$name) > 0}
                                        <h3 class="home_h3">{$APP.LBL_LINK_ACTIONS}</h3>
                                        {foreach from=$shortcutTopMenu.$name item=item}
                                            {if $item.URL == "-"}
                                                <li><a></a><span>&nbsp;</span></li>
                                            {else}
                                                <li><a href="{$item.URL}">{$item.LABEL}</a></li>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                    <h3 class="recent_h3">{$APP.LBL_LAST_VIEWED}</h3>
                                    {foreach from=$recentRecords item=item name=lastViewed}
                                        {if $item.module_name == $name}
                                            <div class="recently_viewed_link_container">
                                                <li class="recentlinks_topedit">
                                                    <a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" style="margin-left:10px;"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                                </li>
                                                <li class="recentlinks_top" role="presentation">
                                                    <a title="{$item.module_name}" accessKey="{$smarty.foreach.lastViewed.iteration}" href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}">{$item.item_summary_short}</a>
                                                </li>
                                            </div>
                                        {/if}
                                        {foreachelse}
                                        {$APP.NTC_NO_ITEMS_DISPLAY}
                                    {/foreach}
                                    <h3 class="recent_h3">{$APP.LBL_FAVORITES}</h3>
                                    {foreach from=$favoriteRecords item=item name=lastViewed}
                                        {if $item.module_name == $name}
                                            <div class="recently_viewed_link_container">
                                                <li class="recentlinks_topedit">
                                                    <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" style="margin-left:10px;"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                                </li>
                                                <li class="recentlinks_top" role="presentation">
                                                    <a title="{$item.module_name}" accessKey="{$smarty.foreach.lastViewed.iteration}" href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}">{$item.item_summary_short}</a>
                                                </li>
                                            </div>
                                        {/if}
                                        {foreachelse}
                                        {$APP.NTC_NO_ITEMS_DISPLAY}
                                    {/foreach}
                                </ul>
                            </li>
                        {/if}
                    {/foreach}
                    {foreach from=$groupTabs item=modules key=group name=groupList}
                        {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                        <li class="topnav">
                            <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab">
                            <a href="#" id="grouptab_{$smarty.foreach.groupList.index}" class="dropdown-toggle" data-toggle="dropdown">{$group}</a>
                            <span class="notCurrentTabRight">&nbsp;</span>
                            <ul class="dropdown-menu" role="menu" {if $smarty.foreach.groupList.last} class="All"{/if}>
                                {foreach from=$modules.modules item=module key=modulekey}
                                    <li>
                                        {capture name=moduleTabId assign=moduleTabId}moduleTab_{$smarty.foreach.moduleList.index}_{$module}{/capture}
                                        {sugar_link id=$moduleTabId module=$modulekey data=$module extraparams=$extraparams}
                                    </li>
                                {/foreach}
                                {foreach from=$modules.extra item=submodulename key=submodule}
                                    <li><a href="{sugar_link module=$submodule link_only=1 extraparams=$extraparams}">{$submodulename}</a></li>
                                {/foreach}
                            </ul>
                        </li>
                    {/foreach}
                </ul>
            {else}
                <ul class="nav navbar-nav">
                    {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                        {if $name == $MODULE_TAB}
                            <li class="topnav">
                                {if $name !='Home'}
                                    <span class="currentTabLeft">&nbsp;</span>
                                    <span class="dropdown-toggle headerlinks currentTab">{sugar_link id="moduleTab_$name" module=$name data=$module}</span><span>&nbsp;</span>
                                {/if}
                                <ul class="dropdown-menu" role="menu">
                                    {if count($shortcutTopMenu.$name) > 0}
                                        <h3 class="home_h3">{$APP.LBL_LINK_ACTIONS}</h3>
                                        {foreach from=$shortcutTopMenu.$name item=item}
                                            {if $item.URL == "-"}
                                                <li><a></a><span>&nbsp;</span></li>
                                            {else}
                                                <li><a href="{$item.URL}" class=""><span>{$item.LABEL}</span></a></li>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                    <h3 class="recent_h3">{$APP.LBL_LAST_VIEWED}</h3>
                                    {foreach from=$recentRecords item=item name=lastViewed}
                                        {if $item.module_name == $name}
                                            <div class="recently_viewed_link_container">
                                                <li class="recentlinks_topedit"><a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" style="margin-left:10px;"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a></li>
                                                <li class="recentlinks_top" role="presentation">
                                                    <a title="{$item.module_name}"
                                                       accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                       href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}">
                                                        {$item.item_summary_short}
                                                    </a>
                                                </li>
                                            </div>
                                        {/if}
                                        {foreachelse}
                                        {$APP.NTC_NO_ITEMS_DISPLAY}
                                    {/foreach}
                                    <h3 class="recent_h3">{$APP.LBL_FAVORITES}</h3>
                                    {foreach from=$favoriteRecords item=item name=lastViewed}
                                        {if $item.module_name == $name}
                                            <div class="recently_viewed_link_container">
                                                <li class="recentlinks_topedit">
                                                    <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" style="margin-left:10px;"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                                </li>
                                                <li class="recentlinks_top" role="presentation">
                                                    <a title="{$item.module_name}" accessKey="{$smarty.foreach.lastViewed.iteration}" href="{sugar_link module=$item.module action='DetailView' record=$item.id link_only=1}">{$item.item_summary_short}</a>
                                                </li>
                                            </div>
                                        {/if}
                                        {foreachelse}
                                        {$APP.NTC_NO_ITEMS_DISPLAY}
                                    {/foreach}
                                </ul>
                            </li>
                        {else}
                            <li class="topnav">
                                {if $name != 'Home'}
                                    <span class="notCurrentTabLeft">&nbsp;</span>
                                    <span class="dropdown-toggle headerlinks notCurrentTab">{sugar_link id="moduleTab_$name" module=$name data=$module}</span><span class="notCurrentTabRight">&nbsp;</span>
                                {/if}
                                <ul class="dropdown-menu" role="menu">
                                    {if count($shortcutTopMenu.$name) > 0}
                                        <h3 class="home_h3">{$APP.LBL_LINK_ACTIONS}</h3>
                                        {foreach from=$shortcutTopMenu.$name item=item}
                                            {if $item.URL == "-"}
                                                <li><a></a><span>&nbsp;</span></li>
                                            {else}
                                                <li><a href="{$item.URL}">{$item.LABEL}</a></li>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                    <h3 class="recent_h3">{$APP.LBL_LAST_VIEWED}</h3>
                                    {foreach from=$recentRecords item=item name=lastViewed}
                                        {if $item.module_name == $name}
                                            <div class="recently_viewed_link_container">
                                                <li class="recentlinks_topedit"><a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" style="margin-left:10px;"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a></li>
                                                <li class="recentlinks_top" role="presentation">
                                                    <a title="{$item.module_name}"
                                                       accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                       href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}">
                                                        {$item.item_summary_short}
                                                    </a>
                                                </li>
                                            </div>
                                        {/if}
                                        {foreachelse}
                                        {$APP.NTC_NO_ITEMS_DISPLAY}
                                    {/foreach}
                                    <h3 class="recent_h3">{$APP.LBL_FAVORITES}</h3>
                                    {foreach from=$favoriteRecords item=item name=lastViewed}
                                        {if $item.module_name == $name}
                                            <div class="recently_viewed_link_container">
                                                <li class="recentlinks_topedit">
                                                    <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" style="margin-left:10px;"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                                </li>
                                                <li class="recentlinks_top" role="presentation">
                                                    <a title="{$item.module_name}" accessKey="{$smarty.foreach.lastViewed.iteration}" href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}">{$item.item_summary_short}</a>
                                                </li>
                                            </div>
                                        {/if}
                                        {foreachelse}
                                        {$APP.NTC_NO_ITEMS_DISPLAY}
                                    {/foreach}
                                </ul>
                            </li>
                        {/if}
                    {/foreach}
                    {if count($moduleExtraMenu) > 0}
                        <li class="dropdown-toggle moremenu ">
                            <a class="dropdown-toggle" data-toggle="dropdown">{$APP.LBL_MORE} &raquo;</a>
                            <ul class="dropdown-menu" role="menu">
                                <div class="bigmenu">
                                    {foreach from=$moduleExtraMenu item=module key=name name=moduleList}
                                        <li>{sugar_link id="moduleTab_$name" module=$name data=$module}</li>
                                    {/foreach}
                                </div>
                            </ul>
                        </li>
                    {/if}
                </ul>
            {/if}
            <div id="globalLinks" class="dropdown nav navbar-nav navbar-right">
                <li id="usermenu" class="dropdown-toggle" aria-expanded="true">
                    <a href='index.php?module=Users&action=EditView&record={$CURRENT_USER_ID}'><span class="glyphicon glyphicon-user"> </span> {$CURRENT_USER}
                        <span class="caret"></span>
                    </a>
                </li>
                <button id="usermenucollapsed" class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="true">
                    <span class="glyphicon glyphicon-user"> </span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    {foreach from=$GCLS item=GCL name=gcl key=gcl_key}
                        <li role="presentation">
                            <a id="{$gcl_key}_link" href="{$GCL.URL}"{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a>
                        </li>
                    {/foreach}
                    <li role="presentation"><a role="menuitem" id="logout_link" href='{$LOGOUT_LINK}' class='utilsLink'>{$LOGOUT_LABEL}</a></li>
                </ul>
            </div>

            <div id="search" class="dropdown nav navbar-nav navbar-right">
                <button id="searchbutton" class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="true">
                    <span class="glyphicon glyphicon-search"> </span>
                </button>
                <div  class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <form id="searchformdropdown" name='UnifiedSearch' action='index.php' onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
                        <input type="hidden" class="form-control" name="action" value="UnifiedSearch">
                        <input type="hidden" class="form-control" name="module" value="Home">
                        <input type="hidden" class="form-control" name="search_form" value="false">
                        <input type="hidden" class="form-control" name="advanced" value="false">
                        <div class="input-group">
                            <input type="text" class="form-control"  name="query_string" id="query_string" placeholder="{$APP.LBL_SEARCH}..." value="{$SEARCH}" />
                            <span class="input-group-btn">
                                <button  type="submit" class="btn btn-default" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <form id="searchform" class="navbar-form navbar-right" name='UnifiedSearch' action='index.php' onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
                <input type="hidden" class="form-control" name="action" value="UnifiedSearch">
                <input type="hidden" class="form-control" name="module" value="Home">
                <input type="hidden" class="form-control" name="search_form" value="false">
                <input type="hidden" class="form-control" name="advanced" value="false">
                <div class="input-group">
                    <input type="text" class="form-control"  name="query_string" id="query_string" placeholder="{$APP.LBL_SEARCH}..." value="{$SEARCH}" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </span>
                </div>
            </form>
            <div id="quickcreatetop" class="dropdown nav navbar-nav navbar-right">
                <a class="dropdown-toggle" aria-expanded="false">
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=Accounts&action=EditView&return_module=Accounts&return_action=DetailView">{$APP.LBL_QUICK_ACCOUNT}</a></li>
                    <li><a href="index.php?module=Contacts&action=EditView&return_module=Contacts&return_action=DetailView">{$APP.LBL_QUICK_CONTACT}</a></li>
                    <li><a href="index.php?module=Opportunities&action=EditView&return_module=Opportunities&return_action=DetailView">{$APP.LBL_QUICK_OPPORTUNITY}</a></li>
                    <li><a href="index.php?module=Leads&action=EditView&return_module=Leads&return_action=DetailView">{$APP.LBL_QUICK_LEAD}</a></li>
                    <li><a href="index.php?module=Documents&action=EditView&return_module=Documents&return_action=DetailView">{$APP.LBL_QUICK_DOCUMENT}</a></li>
                    <li><a href="index.php?module=Calls&action=EditView&return_module=Calls&return_action=DetailView">{$APP.LBL_QUICK_CALL}</a></li>
                    <li><a href="index.php?module=Tasks&action=EditView&return_module=Tasks&return_action=DetailView">{$APP.LBL_QUICK_TASK}</a></li>
                </ul>
            </div>
            <div id="desktop_notifications" class="dropdown nav navbar-nav navbar-right">
                <button class="alertsButton dropdown-toggle btn btn-success" data-toggle="dropdown" aria-expanded="false">
                   <span class="badge"><span class="alert_count" >0</span> <span class="glyphicon glyphicon-comment"></span>
                </button>
                <div id="alerts" class="dropdown-menu" role="menu">{$APP.LBL_EMAIL_ERROR_VIEW_RAW_SOURCE}</div>
            </div>
        </div>

        <div class="collapse navbar-collapse hidden-lg hidden-md" id="mobile_menu">
            {foreach from=$groupTabs item=modules key=group name=groupList}
                {if $smarty.foreach.groupList.last}
                {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                                {foreach from=$modules.modules item=module key=modulekey}
                                    {if $modulekey !='Home' && $modulekey !='Calendar'}
                                        <li style="float:right;">
                                            <a href="{sugar_link module=$modulekey action='EditView' link_only=1}"><span class="glyphicon glyphicon-plus"></span></a>
                                        </li>
                                    {/if}
                                    <li>
                                        {capture name=moduleTabId assign=moduleTabId}moduleTab_{$smarty.foreach.moduleList.index}_{$module}{/capture}
                                        {sugar_link id=$moduleTabId module=$modulekey data=$module extraparams=$extraparams}
                                    </li>
                                {/foreach}
                                {foreach from=$modules.extra item=submodulename key=submodule}
                                    <li style="float:right;">
                                        <a href="{sugar_link module=$modulekey action='EditView' link_only=1}"><span class="glyphicon glyphicon-plus"></span></a>
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
        <a href="javascript:void(0)" id="buttontoggle"><span class="glyphicon glyphicon-th-list"></span></a>
        <div class="row">
            <div {if $smarty.cookies.sidebartoggle == 'collapsed'}style="display:none"{/if} class="col-sm-3 col-md-2 sidebar">
                <div id="actionMenuSidebar">
                    {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                        {if $name == $MODULE_TAB}
                            <ul class="nav nav-pills nav-stacked">
                                {if count($shortcutTopMenu.$name) > 0}
                                    <h2 class="recent_h3">{$APP.LBL_LINK_ACTIONS}</h2>
                                    {foreach from=$shortcutTopMenu.$name item=item}
                                        {if $item.URL == "-"}
                                            <li><a></a><span>&nbsp;</span></li>
                                        {else}
                                            <li class="actionmenulinks" role="presentation"><a href="{$item.URL}"><span>{$item.LABEL}</span></a></li>
                                        {/if}
                                    {/foreach}
                                    <br>
                                {/if}
                            </ul>
                        {/if}
                    {/foreach}
                </div>
                <div id="recentlyViewedSidebar">
                    <h2 class="recent_h3">{$APP.LBL_LAST_VIEWED}</h2>
                    <ul class="nav nav-pills nav-stacked">
                        {foreach from=$recentRecords item=item name=lastViewed}
                            <div class="recently_viewed_link_container_sidebar">
                                <li class="recentlinks_edit"><a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" style="margin-left:10px;"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a></li>
                                <li class="recentlinks" role="presentation">
                                    <a title="{$item.module_name}"
                                       accessKey="{$smarty.foreach.lastViewed.iteration}"
                                       href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}">
                                        {$item.image}&nbsp;<span aria-hidden="true">{$item.item_summary_short}</span>
                                    </a>
                                </li>
                            </div>
                        {/foreach}
                    </ul>
                </div>
                </br>
                <div id="favoritesSidebar">
                    <h2 class="recent_h3">{$APP.LBL_FAVORITES}</h2>
                    <ul class="nav nav-pills nav-stacked">
                        {foreach from=$favoriteRecords item=item name=lastViewed}
                            <div class="recently_viewed_link_container_sidebar" id="{$item.id}">
                                <li class="recentlinks_edit"><a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" style="margin-left:10px;"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a></li>
                                <li class="recentlinks" role="presentation">
                                    <a title="{$item.module_name}"
                                       accessKey="{$smarty.foreach.lastViewed.iteration}"
                                       href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}">
                                        {$item.image}&nbsp;<span aria-hidden="true">{$item.item_summary_short}</span>
                                    </a>
                                </li>
                            </div>
                        {/foreach}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--End Responsive Sidebar -->
{/if}
<!--Start Page content -->