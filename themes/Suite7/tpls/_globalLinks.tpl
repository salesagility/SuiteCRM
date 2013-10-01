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
<div id="globalLinks">
    <ul>
    {foreach from=$GCLS item=GCL name=gcl key=gcl_key}
    <li>
    {if !$smarty.foreach.gcl.first}<span>|</span>{/if}
    <a id="{$gcl_key}_link" href="{$GCL.URL}"{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a>
    {foreach from=$GCL.SUBMENU item=GCL_SUBMENU name=gcl_submenu key=gcl_submenu_key}
    {if $smarty.foreach.gcl_submenu.first}
    {sugar_getimage name="menuarrow" ext=".gif" alt="" other_attributes=''}<br />
    <ul class="cssmenu">
    {/if}
    <li><a id="{$gcl_submenu_key}_link" href="{$GCL_SUBMENU.URL}"{if !empty($GCL_SUBMENU.ONCLICK)} onclick="{$GCL_SUBMENU.ONCLICK}"{/if}>{$GCL_SUBMENU.LABEL}</a></li>
    {if $smarty.foreach.gcl_submenu.last}
    </ul>
    {/if}
    {/foreach}
    </li>
    {/foreach}
    </ul>
</div>
