{*
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2019 Salesagility Ltd.
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
 ********************************************************************************/

*}
<div id="{$displayParams.formName}_{$vardef.name}" name="{$displayParams.formName}_{$vardef.name}">
<table id="table_collection_{$vardef.name}" style="border-collapse:separate;border-top:solid 1px #999999;border-left:solid 1px #999999;border-right:solid 1px #999999; margin-top: 5px !important;border-radius: 6px;">
    <tr style="font-weight: bold;" id="lineLabel_{$displayParams.formName}_{$vardef.name}" name="lineLabel_{$displayParams.formName}_{$vardef.name}">
        {foreach item=extra_field from=$displayParams.collection_field_list key=key_extra}
            {if $extra_field.displayParams.hidden != 'hidden'}
                <th style="padding: 5px 5px 10px 5px !important; text-align: center;{if $extra_field.displayParams.size != ''}width:{$extra_field.displayParams.size}{/if}">
                    {$extra_field.label}
                </th>
            {/if}
        {/foreach}
   </tr>
    {foreach item=extra_value from=$count_values key=key_extra_value}
        <tr id="lineFields_{$displayParams.formName}_{$vardef.name}_{$extra_value}">
            {foreach item=extra_field from=$displayParams.to_display.$extra_value key=key_extra}
                {if $extra_field.hidden != 'hidden'}
                    <td nowrap style="padding: 5px 5px 10px 5px !important; vertical-align: middle;text-align: right;">
                        {$extra_field.field}
                    </td>
                {/if}
            {/foreach}
       </tr>
   {/foreach}
</table>
</div>