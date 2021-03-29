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

<div class="mobile-bar">
    <ul id="toolbar" class="toolbar">
        <li id="quickcreatetop" class="create dropdown nav navbar-nav quickcreatetop">
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/quick_create.tpl"}
        </li>
        <li id="" class="dropdown nav navbar-nav navbar-search">
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/navbar-search.tpl"}
        </li>
        <li id="desktop_notifications" class="dropdown nav navbar-nav desktop_notifications">
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/desktop_notifications.tpl"}
        </li>
        <li>
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/search_form.tpl"}
        </li>
        <li id="globalLinks" class="dropdown nav navbar-nav globalLinks-mobile">

            <button id="usermenucollapsed" class="dropdown-toggle btn btn-default usermenucollapsed" data-toggle="dropdown" aria-expanded="true">
                <span class="suitepicon suitepicon-action-user-small"></span>
            </button>
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/global_links.tpl"}
        </li>
    </ul>
</div>
<div class="tablet-bar">
    <ul id="toolbar" class="toolbar">
        <li id="quickcreatetop" class="create dropdown nav navbar-nav quickcreatetop">
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/quick_create.tpl"}
        </li>
        <li id="" class="dropdown nav navbar-nav navbar-search">
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/navbar-search.tpl"}
        </li>
        <li>
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/search_form.tpl"}
        </li>
        <li id="desktop_notifications" class="dropdown nav navbar-nav desktop_notifications">
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/desktop_notifications.tpl"}
        </li>
        <li id="globalLinks" class="dropdown nav navbar-nav globalLinks-mobile">

            <button id="usermenucollapsed" class="dropdown-toggle btn btn-default usermenucollapsed" data-toggle="dropdown"
                    aria-expanded="true">
                <span class="suitepicon suitepicon-action-current-user"></span>
            </button>
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/global_links.tpl"}
        </li>
    </ul>
</div>
<div class="desktop-bar">
    <ul id="toolbar" class="toolbar">
        <li id="quickcreatetop" class="create dropdown nav navbar-nav quickcreatetop">
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/quick_create.tpl"}
        </li>
        <li id="" class="dropdown nav navbar-nav navbar-search">
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/navbar-search.tpl"}
        </li>
        <li>
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/search_form.tpl"}
        </li>
        <li id="desktop_notifications" class="dropdown nav navbar-nav desktop_notifications">
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/desktop_notifications.tpl"}
        </li>
        <li id="globalLinks" class="dropdown nav navbar-nav globalLinks-desktop">
            <button id="with-label" class="dropdown-toggle user-menu-button" title="{$CURRENT_USER}"data-toggle="dropdown" aria-expanded="true">
                <span class="suitepicon suitepicon-action-current-user"></span>
                <span>{$CURRENT_USER}</span>
                <span class="suitepicon suitepicon-action-caret"></span>
            </button>
            {include file="themes/SuiteP/tpls/_headerModuleList/global_menu/global_links.tpl"}
        </li>
    </ul>
</div>
