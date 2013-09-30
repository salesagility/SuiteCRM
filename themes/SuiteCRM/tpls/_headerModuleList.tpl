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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

*}
{if $USE_GROUP_TABS}
    <div id="moduleList">
        <ul>
            <li class="noBorder">&nbsp;</li>
            {assign var="groupSelected" value=false}
            {foreach from=$groupTabs item=modules key=group name=groupList}
                {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                {if ( ( $smarty.request.parentTab == $group || (!$smarty.request.parentTab && in_array($MODULE_TAB,$modules.modules)) ) && !$groupSelected ) || ($smarty.foreach.groupList.index == 0 && $defaultFirst)}
                    <li class="noBorder">
                        <span class="currentTabLeft">&nbsp;</span><span class="currentTab">
            <a href="#" id="grouptab_{$smarty.foreach.groupList.index}">{$group}</a>
        </span><span class="currentTabRight">&nbsp;</span>
                        {assign var="groupSelected" value=true}
                        {else}
                    <li>
                    <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab">
        <a href="#" id="grouptab_{$smarty.foreach.groupList.index}">{$group}</a>
        </span><span class="notCurrentTabRight">&nbsp;</span>
                {/if}
                </li>
            {/foreach}
        </ul>
    </div>
    <div class="clear"></div>
    <div id="subModuleList">
        {assign var="groupSelected" value=false}
        {foreach from=$groupTabs item=modules key=group name=moduleList}
            {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
            <span id="moduleLink_{$smarty.foreach.moduleList.index}" {if ( ( $smarty.request.parentTab == $group || (!$smarty.request.parentTab && in_array($MODULE_TAB,$modules.modules)) ) && !$groupSelected ) || ($smarty.foreach.moduleList.index == 0 && $defaultFirst)}class="selected" {assign var="groupSelected" value=true}{/if}>
    	<ul>
            {foreach from=$modules.modules item=module key=modulekey}
                <li>
                    {capture name=moduleTabId assign=moduleTabId}moduleTab_{$smarty.foreach.moduleList.index}_{$module}{/capture}
                    {sugar_link id=$moduleTabId module=$modulekey data=$module extraparams=$extraparams}
                </li>
            {/foreach}
            {if !empty($modules.extra)}
                <li class="subTabMore">
                    <a>>></a>
                    <ul class="cssmenu">
                        {foreach from=$modules.extra item=submodulename key=submodule}
                            <li>
                                <a href="{sugar_link module=$submodule link_only=1 extraparams=$extraparams}">{$submodulename}
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                </li>
            {/if}
        </ul>

    </span>
        {/foreach}
    </div>
{else}
    <div id="moduleList">
        <ul>
            <li class="noBorder">&nbsp;</li>
            {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                {if $name == $MODULE_TAB}
                    <li class="noBorder">
                        <span class="currentTabLeft">&nbsp;</span><span class="currentTab">{sugar_link id="moduleTab_$name" module=$name}</span><span class="currentTabRight">&nbsp;</span>
                        {else}
                    <li>
                    <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab">{sugar_link id="moduleTab_$name" module=$name data=$module}</span><span class="notCurrentTabRight">&nbsp;</span>
                {/if}
                </li>
            {/foreach}
            {if count($moduleExtraMenu) > 0}
                <li id="moduleTabExtraMenu">
                    <a href="#">&gt;&gt;</a><br />
                    <ul class="cssmenu">
                        {foreach from=$moduleExtraMenu item=module key=name name=moduleList}
                        <li>{sugar_link id="moduleTab_$name" module=$name data=$module}
                            {/foreach}
                    </ul>
                </li>
            {/if}
        </ul>
    </div>
{/if}