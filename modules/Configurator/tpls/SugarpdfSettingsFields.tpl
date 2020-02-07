{*
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




*}
{if $property.type == "image"}
{if $count is not odd}</tr>{/if}
<tr>
    <td scope="row" width="20%">{$property.label}:<span class="error" id="resized_{$name}_img" style="display:none"> {$MOD.LBL_IMG_RESIZED}</span>{sugar_help text=$property.info_label} </td>
    <td colspan="3">
        <img src='{$property.path}' id='{$name}_img' style='margin-bottom: 10px;'>
        <input type='hidden' id='{$name}' name='{$name}' value='{$property.value}'>
        <script type='text/javascript'>
            {literal}
            YAHOO.util.Event.onDOMReady(function() {
                if(document.getElementById({/literal}"{$name}_img"{literal}).width>document.width/2){
                    document.getElementById({/literal}"{$name}_img"{literal}).width = document.width/2;
                    document.getElementById({/literal}"resized_{$name}_img"{literal}).style.display="";
                }
            });
            {/literal}
        </script>
    </td>
</tr>
{counter}
{else}
    {if $count is odd}
    <tr>
    {/if}
        <td scope="row" width="20%">{$property.label}:{if isset($property.required) && $property.required == true} <span class="required">*</span>{/if}{sugar_help text=$property.info_label} </td>
        <td  width="30%">
            {if isset($property.custom)}
                {$property.custom}
            {elseif $property.type == "text"}
                <input type='text' size='40' name='{$name}' id='{$name}' value='{$property.value}'>
            {elseif $property.type == "number"}
                <input type='text' size='10' name='{$name}' id='{$name}' value='{$property.value}' onchange="verifyNumber('{$name}')">
                {if isset($property.unit)}
                    {$property.unit}
                {/if}
            {elseif $property.type == "percent"}
                <input type='text' size='20' name='{$name}' id='{$name}' value='{$property.value}' onchange="verifyPercent('{$name}')">
            {elseif $property.type == "select"}
                {html_options name=$name options=$property.selectList selected=$property.value}
            {elseif $property.type == "multiselect"}
                <select name='{$name}[]' multiple size=4>
                {html_options options=$property.selectList selected=$property.value}
                </select>
            {elseif $property.type == "bool"}
                <input type="hidden" name='{$name}' value='false'>
                <input type='checkbox' name='{$name}' value='true' id='{$name}' {if $property.value == "true"}CHECKED{/if}>
            {elseif $property.type == "password"}
                <input type='password' size='20' name='{$name}' id='{$name}' value='{$property.value}'>
            {elseif $property.type == "file"}
                <input type="file" id='{$name}' name='{$name}' size="20" onBlur="checkFileType('{$name}',0);"/>
            {/if}
        </td>
    {if $count is not odd}
    </tr>
    {/if}
{/if}