{if false}
/**
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
 */

{/if}
 
 <br>
 <p>{$CONFIRM_LAYOUT_DESC}</p>
 <br>
 
 <table width="100%" id="layoutSelection">
 <thead>
    <tr>
        {if $showCheckboxes}
        <th width="5%">&nbsp;</th>
        {/if}
        <th width="25%">{$APP.LBL_MODULE}</th>
        <th width="50%">{$MOD.LBL_LAYOUT_MODULE_TITLE}</th>
    </tr>
</thead>
<tbody>
{foreach from=$METADATA_DATA key=moduleKey item=data}
    <tr>
        {if $showCheckboxes}
        <td>
            <input type="checkbox" name="lm_{$moduleKey}" checked>
        </td>
        {/if}
        <td>
        {$data.moduleName}
        </td>
        <td>
            {foreach from=$data.layouts item=layout}
                    {$layout.label}
                 <br> 
            {/foreach}
        </td>
    </tr>
{/foreach}
</tbody>
</table>

<div id="upgradeDiv" style="display:none">
    <table cellspacing="0" cellpadding="0" border="0">
        <tr><td>
           <p><img src='modules/UpgradeWizard/processing.gif' alt='{$mod_strings.LBL_PROCESSING}'></p>
        </td></tr>
     </table>
 </div>