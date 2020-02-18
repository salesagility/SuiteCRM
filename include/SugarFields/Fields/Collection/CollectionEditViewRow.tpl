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
<script type="text/javascript">
    var collection{$vardef.name} = (typeof collection{$vardef.name} == 'undefined') ? new Array() : collection{$vardef.name};
    collection{$vardef.name} = new SUGAR.collection('{$displayParams.formName}', '{$vardef.name}', '{$module}', '');
    collection{$vardef.name}.fields_count = '{$count}';
</script>
<div id="{$displayParams.formName}_{$vardef.name}" name="{$displayParams.formName}_{$vardef.name}">
    <span class="id-ff">
        <button class="button" type="button" name="remove_{$vardef.name}_collection_0" tabindex="{$tabindex}" class="utilsLink" onclick="collection{$vardef.name}.selectedRemove();">
            <img id="removeButton_collection_0" name="removeButton_collection_0" src="{sugar_getimagepath file="id-ff-remove-nobg.png"}"/>
            <p value={$APP.LBL_DELETE_BUTTON}></p>
        </button>
        <button class="button" type="button" name="allow_new_value_{$vardef.name}_collection_0" tabindex="{$tabindex}" class="utilsLink" onclick="collection{$vardef.name}.create_clone();collection{$vardef.name}.add();collection{$vardef.name}.cleanCurrent();">
            <img id="addButton_collection_0" name="addButton_collection_0" src="{sugar_getimagepath file="id-ff-add.png"}"/>
            <p value={$APP.LBL_ADD_BUTTON}></p>
        </button>
    </span>
<input hidden="hidden" id="collection_{$vardef.name}" name="collection_{$vardef.name}" value="{$vardef.name}">
<input hidden="hidden" id="collection_{$vardef.name}_remove" name="collection_{$vardef.name}_remove" value="">
<input hidden="hidden" id="collection_{$vardef.name}_change" name="collection_{$vardef.name}_change" value="">
<table id="table_collection_{$vardef.name}" style="border-collapse:collapse;border-top:solid 1px #999999;border-left:solid 1px #999999;border-right:solid 1px #999999; margin-top: 5px !important;border-radius: 6px;">
    <tr id="lineLabel_{$displayParams.formName}_{$vardef.name}" name="lineLabel_{$displayParams.formName}_{$vardef.name}">
        <td style="min-width: 30px; padding: 5px 5px 10px 5px !important; text-align: center;border-right: solid 1px #999999;">
            <span>{$APP.LBL_LINK_SELECT}</span>
        </td>
        {foreach item=extra_field from=$displayParams.collection_field_list key=key_extra}
            {if $extra_field.label != ''}
                <td style="padding: 5px 5px 10px 5px !important; text-align: center;{if $extra_field.displayParams.size != ''}width:{$extra_field.displayParams.size}{/if}">
                    {$extra_field.label}
                </td>
            {else}
                <td></td>
            {/if}
        {/foreach}
                <td style="min-width: 30px; padding: 5px 5px 10px 5px !important; text-align: center;border-left: solid 1px #999999;">
                    <span>{$APP.LBL_ID_FF_CLEAR}</span>
                </td>

   </tr>
    {foreach item=extra_value from=$count_values key=key_extra_value}
        <tr id="lineFields_{$displayParams.formName}_{$vardef.name}_{$extra_value}">
            <td style="min-width: 30px; padding: 5px 5px 10px 5px !important; text-align: center;border-right: solid 1px #999999;">
                <input onclick="this.value=='0' ? this.value='1' : this.value='0';" type="checkbox" id="check_{$vardef.name}_collection_{$extra_value}" name="check_{$vardef.name}_collection_{$extra_value}" value='0' {if $extra_value == '0'}style="display:none"{/if}>
            </td>
            {foreach item=extra_field from=$displayParams.to_display.$extra_value key=key_extra}
                {if !empty($extra_field.field)}
                    {if $extra_field.hidden != 'hidden'}
                        <td nowrap style="padding: 5px 5px 10px 5px !important; vertical-align: middle;" field="{$extra_field.name}" type="{$extra_field.type}">
                            {$extra_field.field}
                        </td>
                    {else}
                        <td>{$extra_field.field}</td>
                    {/if}
                {/if}
            {/foreach}
                    <td style="border-left: solid 1px #999999; text-align: center; vertical-align: middle;">
                        <span class="id-ff multiple">
                            <button class="button" type="button" name="clean_{$vardef.name}_collection_{$extra_value}" id="clean_{$vardef.name}_collection_{$extra_value}" tabindex="{$tabindex}" class="utilsLink" onclick="collection{$vardef.name}.cleanCurrent(this.id);collection{$vardef.name}.fieldRowChange(this.id,'clean');">
                                <img id="addButton_collection_{$extra_value}" name="addButton_collection_{$extra_value}" src="{sugar_getimagepath file="id-ff-clear.png"}"/>
                            </button>
                        </span>
                    </td>
       </tr>
   {/foreach}
</table>
<script type="text/javascript">
    var tableelement = document.getElementById('table_collection_{$vardef.name}');
    collection{$vardef.name}.correctnewpage(tableelement);
</script>
</div>
