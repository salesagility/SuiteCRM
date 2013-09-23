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
<!-- BEGIN Labels Line -->
    <tr id="lineLabel_{$vardef.name}" name="lineLabel_{$vardef.name}">
        <td>
           {if empty($displayParams.hideNameLabel)}
           {ldelim}sugar_translate label='LBL_COLLECTION_NAME'{rdelim}:
           {/if}
        </td>
        {foreach item=extra_field from=$displayParams.collection_field_list key=key_extra}
        <td>
            {$extra_field.label}
            <script type="text/javascript">
                collection['{$vardef.name}'].extra_fields_count++;
            </script>
        </td>
        {/foreach}
        <td>

        </td>
        <td>

        </td>
        <td id="lineLabel_{$vardef.name}_primary" {if empty($values.role_field)}style="display:none"{/if}>
            {ldelim}sugar_translate label='LBL_COLLECTION_PRIMARY'{rdelim}
        </td>
<!-- BEGIN Add and collapse -->
        <td rowspan='1' valign='top'>
            &nbsp;&nbsp;<a class="utilsLink" href="javascript:collection['{$vardef.name}'].js_more();" id='more_{$vardef.name}' {if empty($values.secondaries)}style="display:none"{/if}>{sugar_getimage name="advanced_search" ext=".gif" width="8" height="8" alt=$app_strings.LBL_HIDE_SHOW other_attributes='border="0" id="more_img_{$vardef.name}" '}</a>
        </td>
<!-- END Add and collapse -->
    </tr>
<!-- END Labels Line -->
    <tr id="lineFields_{$vardef.name}_0" name="lineFields_{$vardef.name}_0" class="lineFields_{$vardef.name}">
        <td valign='top'>
            <input type="text" name="{$vardef.name}_collection_0" class="sqsEnabled {$displayParams.class}" tabindex="{$tabindex}" id="{$vardef.name}_collection_0" size="{$displayParams.size}" value="" title='{$vardef.help}' autocomplete="off" {$displayParams.readOnly} {$displayParams.field}>
            <input type="hidden" name="id_{$vardef.name}_collection_0" id="id_{$vardef.name}_collection_0" value="">
            {if $showSelectButton}
           		<input type="button" name="btn_{$vardef.name}_collection_0" tabindex="{$tabindex}" title="{sugar_translate label="{{$displayParams.accessKeySelectTitle}}" class="button" value="{sugar_translate label="{{$displayParams.accessKeySelectLabel}}" onclick='open_popup("{$module}", 600, 400, "", true, false, {$displayParams.popupData}, "single", true);'>
            {/if}
        </td>
        {foreach item=extra_field from=$displayParams.collection_field_list key=key_extra}
        <td class="td_extra_field" valign='top'>
            {$extra_field.field}
        </td>
        {/foreach}